<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $this->touchAgentPresence();
        $sessions = $this->sessionQuery()->get();
        $selectedSession = null;
        $messages = collect();

        if ($request->filled('session')) {
            $selectedSession = $this->findSession($request->query('session'));

            if ($selectedSession) {
                $this->markSessionAsRead($selectedSession->session_id);
                $messages = $this->messageCollection($selectedSession->session_id);
            }
        }

        // Open the most recent conversation by default so the inbox feels like
        // the Messenger-style reference layout instead of showing an empty
        // center panel on every first visit.
        if (!$selectedSession && $sessions->isNotEmpty()) {
            $selectedSession = $sessions->first();
            $this->markSessionAsRead($selectedSession->session_id);
            $messages = $this->messageCollection($selectedSession->session_id);
        }

        return view('admin.chat.index', [
            'sessions' => $sessions,
            'selectedSession' => $selectedSession,
            'messages' => $messages,
        ]);
    }

    public function sessions(Request $request): JsonResponse
    {
        $this->touchAgentPresence();
        $query = $this->sessionQuery();

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('s.status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = '%' . $request->input('search') . '%';
            $query->where(function ($builder) use ($search) {
                $builder->where('s.visitor_name', 'like', $search)
                    ->orWhere('s.visitor_email', 'like', $search);
            });
        }

        return response()->json(['sessions' => $query->get()]);
    }

    public function messages(string $sessionId): JsonResponse
    {
        $session = $this->findSessionOrFail($sessionId);
        $this->touchAgentPresence($session->session_id);
        $this->markSessionAsRead($session->session_id);

        return response()->json([
            'session' => $this->sessionQuery()->where('s.session_id', $session->session_id)->first(),
            'messages' => $this->messageCollection($session->session_id),
        ]);
    }

    public function storeMessage(Request $request, string $sessionId): JsonResponse
    {
        $session = $this->findSessionOrFail($sessionId);
        $this->touchAgentPresence($session->session_id);

        if ($session->status === 'closed') {
            return response()->json(['message' => 'This conversation is closed.'], 422);
        }

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $messageId = DB::table('chat_messages')->insertGetId([
            'session_id' => $session->session_id,
            'sender' => 'agent',
            'message_type' => 'text',
            'message' => trim($validated['message']),
            'status' => 'sent',
            'is_read' => 0,
            'created_at' => now(),
        ]);

        DB::table('chat_sessions')
            ->where('session_id', $session->session_id)
            ->update(['last_activity' => now()]);

        $message = DB::table('chat_messages')->where('id', $messageId)->first();

        return response()->json(['message' => $this->formatMessage($message)], 201);
    }

    public function markRead(string $sessionId): JsonResponse
    {
        $session = $this->findSessionOrFail($sessionId);
        $this->touchAgentPresence($session->session_id);
        $this->markSessionAsRead($session->session_id);

        return response()->json(['success' => true]);
    }

    private function sessionQuery()
    {
        return DB::table('chat_sessions as s')
            ->select([
                's.session_id',
                's.visitor_name',
                's.visitor_email',
                's.status',
                's.is_blocked',
                's.is_read',
                's.last_activity',
                's.last_presence',
                's.created_at',
            ])
            ->selectSub(function ($query) {
                $query->from('forms as f')
                    ->select('f.id')
                    ->whereColumn('f.email', 's.visitor_email')
                    ->orderByDesc('f.id')
                    ->limit(1);
            }, 'form_id')
            ->selectSub(function ($query) {
                $query->from('forms as f')
                    ->select('f.full_name')
                    ->whereColumn('f.email', 's.visitor_email')
                    ->orderByDesc('f.id')
                    ->limit(1);
            }, 'form_full_name')
            ->selectSub(function ($query) {
                $query->from('forms as f')
                    ->select('f.number')
                    ->whereColumn('f.email', 's.visitor_email')
                    ->orderByDesc('f.id')
                    ->limit(1);
            }, 'form_number')
            ->selectSub(function ($query) {
                $query->from('forms as f')
                    ->select('f.game_id')
                    ->whereColumn('f.email', 's.visitor_email')
                    ->orderByDesc('f.id')
                    ->limit(1);
            }, 'form_game_id')
            ->selectSub(function ($query) {
                $query->from('forms as f')
                    ->select('f.facebook_name')
                    ->whereColumn('f.email', 's.visitor_email')
                    ->orderByDesc('f.id')
                    ->limit(1);
            }, 'form_facebook_name')
            ->selectSub(function ($query) {
                $query->from('forms as f')
                    ->select('f.mail')
                    ->whereColumn('f.email', 's.visitor_email')
                    ->orderByDesc('f.id')
                    ->limit(1);
            }, 'form_mail')
            ->selectSub(function ($query) {
                $query->from('forms as f')
                    ->select('f.balance')
                    ->whereColumn('f.email', 's.visitor_email')
                    ->orderByDesc('f.id')
                    ->limit(1);
            }, 'form_balance')
            ->selectSub(function ($query) {
                $query->from('chat_messages as m')
                    ->select('m.message')
                    ->whereColumn('m.session_id', 's.session_id')
                    ->orderByDesc('m.created_at')
                    ->limit(1);
            }, 'last_message')
            ->selectSub(function ($query) {
                $query->from('chat_messages as m')
                    ->select('m.message_type')
                    ->whereColumn('m.session_id', 's.session_id')
                    ->orderByDesc('m.created_at')
                    ->limit(1);
            }, 'last_message_type')
            ->selectSub(function ($query) {
                $query->from('chat_messages as m')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('m.session_id', 's.session_id')
                    ->where('m.sender', 'visitor')
                    ->where('m.is_read', 0);
            }, 'unread_count')
            ->selectRaw("(TIMESTAMPDIFF(SECOND, COALESCE(s.last_presence, s.last_activity), NOW()) < 10) as visitor_online")
            ->orderByRaw('COALESCE(s.last_activity, s.created_at) DESC');
    }

    private function findSession(string $sessionId)
    {
        return DB::table('chat_sessions')
            ->where('session_id', $sessionId)
            ->first();
    }

    private function findSessionOrFail(string $sessionId)
    {
        abort_unless($session = $this->findSession($sessionId), 404);

        return $session;
    }

    private function messageCollection(string $sessionId): Collection
    {
        return DB::table('chat_messages')
            ->select([
                'id',
                'sender',
                'message',
                'message_type',
                'file_path',
                'file_name',
                'status',
                'created_at',
            ])
            ->where('session_id', $sessionId)
            ->orderBy('created_at')
            ->orderBy('id')
            ->get()
            ->map(fn ($message) => $this->formatMessage($message));
    }

    private function formatMessage($message): array
    {
        $data = (array) $message;
        $data['file_url'] = !empty($data['file_path'])
            ? asset(ltrim($data['file_path'], '/'))
            : null;

        return $data;
    }

    private function markSessionAsRead(string $sessionId): void
    {
        DB::table('chat_sessions')
            ->where('session_id', $sessionId)
            ->update(['is_read' => 1]);

        DB::table('chat_messages')
            ->where('session_id', $sessionId)
            ->where('sender', 'visitor')
            ->update([
                'is_read' => 1,
                'status' => 'seen',
            ]);
    }

    private function touchAgentPresence(?string $sessionId = null): void
    {
        if (!Schema::hasTable('admin_users')) {
            return;
        }

        $user = auth()->user();
        $username = (string) ($user->email ?? $user->name ?? 'admin');
        $displayName = (string) ($user->name ?? $user->email ?? 'Support Agent');
        $presence = [
            'last_activity' => now(),
            'is_viewing' => $sessionId ? 1 : 0,
            'is_typing' => 0,
            'viewing_session_id' => $sessionId,
        ];

        $existing = DB::table('admin_users')->where('username', $username)->first();
        if ($existing) {
            DB::table('admin_users')->where('id', $existing->id)->update($presence);
            return;
        }

        $firstAgent = DB::table('admin_users')->orderBy('id')->first();
        if ($firstAgent) {
            DB::table('admin_users')->where('id', $firstAgent->id)->update(array_merge($presence, [
                'username' => $username,
                'display_name' => $displayName,
            ]));
            return;
        }

        // The presence table is optional for existing installations. Do not
        // create an authentication-like record just to report online status.
    }
}
