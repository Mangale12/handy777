<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Services\ChatPushService;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $this->touchAgentPresence();
        $status = in_array($request->query('status', 'open'), ['open', 'closed', 'all'], true)
            ? $request->query('status', 'open')
            : 'open';
        $sessionsQuery = $this->sessionQuery();
        if ($status !== 'all') {
            $sessionsQuery->where('s.status', $status);
        }
        $sessions = $sessionsQuery->get();
        $selectedSession = null;
        $messages = collect();

        if ($request->filled('session')) {
            $selectedSession = $this->findSession($request->query('session'));

            if ($selectedSession) {
                if (!$sessions->contains('session_id', $selectedSession->session_id)) {
                    $selectedSummary = $this->sessionQuery()
                        ->where('s.session_id', $selectedSession->session_id)
                        ->first();
                    if ($selectedSummary) {
                        $sessions->prepend($selectedSummary);
                    }
                }
                $this->markSessionAsRead($selectedSession->session_id);
                $this->syncAgentMessageStatuses($selectedSession->session_id);
                $messages = $this->messageCollection($selectedSession->session_id);
            }
        }

        // Open the most recent conversation by default so the inbox feels like
        // the Messenger-style reference layout instead of showing an empty
        // center panel on every first visit.
        if (!$selectedSession && $sessions->isNotEmpty()) {
            $selectedSession = $sessions->first();
            $this->markSessionAsRead($selectedSession->session_id);
            $this->syncAgentMessageStatuses($selectedSession->session_id);
            $messages = $this->messageCollection($selectedSession->session_id);
        }

        return view('admin.chat.index', [
            'sessions' => $sessions,
            'selectedSession' => $selectedSession,
            'messages' => $messages,
            'status' => $status,
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
                    ->orWhere('s.visitor_email', 'like', $search)
                    ->orWhere('s.ip_address', 'like', $search);
            });
        }

        return response()->json(['sessions' => $query->get()]);
    }

    public function pushConfig(): JsonResponse
    {
        return response()->json([
            'enabled' => ChatPushService::isConfigured(),
            'public_key' => config('services.webpush.public_key'),
        ]);
    }

    public function subscribePush(Request $request): JsonResponse
    {
        if (!ChatPushService::isConfigured()) {
            return response()->json(['message' => 'Web Push is not configured on the server.'], 503);
        }

        $data = $request->validate([
            'endpoint' => ['required', 'url', 'max:2048'],
            'keys' => ['required', 'array'],
            'keys.p256dh' => ['required', 'string', 'max:512'],
            'keys.auth' => ['required', 'string', 'max:512'],
            'contentEncoding' => ['nullable', 'string', 'in:aes128gcm,aesgcm'],
        ]);

        DB::table('chat_push_subscriptions')->updateOrInsert(
            ['endpoint' => $data['endpoint']],
            [
                'user_id' => optional($request->user())->id,
                'public_key' => $data['keys']['p256dh'],
                'auth_token' => $data['keys']['auth'],
                'content_encoding' => $data['contentEncoding'] ?? 'aes128gcm',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return response()->json(['success' => true]);
    }

    public function unsubscribePush(Request $request): JsonResponse
    {
        $data = $request->validate([
            'endpoint' => ['required', 'url', 'max:2048'],
        ]);

        DB::table('chat_push_subscriptions')->where('endpoint', $data['endpoint'])->delete();

        return response()->json(['success' => true]);
    }

    public function messages(string $sessionId): JsonResponse
    {
        $session = $this->findSessionOrFail($sessionId);
        $this->touchAgentPresence($session->session_id);
        $this->markSessionAsRead($session->session_id);
        $this->syncAgentMessageStatuses($session->session_id);

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
            'message' => ['nullable', 'string', 'max:5000'],
            'file' => ['nullable', 'file', 'max:10240', 'mimes:jpg,jpeg,png,gif,webp,avif,bmp,heic,heif,tif,tiff,pdf,doc,docx,xls,xlsx,csv,txt,zip'],
        ]);

        $messageText = trim((string) ($validated['message'] ?? ''));
        if ($messageText === '' && !$request->hasFile('file')) {
            return response()->json(['message' => 'Write a message or attach a file.'], 422);
        }

        $status = $this->visitorIsViewing($session) ? 'seen'
            : ($this->visitorIsOnline($session) ? 'delivered' : 'sent');

        $messageData = [
            'message_type' => 'text',
            'message' => $messageText !== '' ? $messageText : null,
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = \Illuminate\Support\Str::random(32) . '.' . strtolower($file->getClientOriginalExtension());
            $uploadDirectory = public_path('uploads');

            if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0755, true)) {
                return response()->json(['message' => 'File upload failed: upload folder is not writable.'], 500);
            }

            // Read the MIME type while the uploaded temporary file still exists.
            $mimeType = (string) $file->getMimeType();
            try {
                $file->move($uploadDirectory, $fileName);
            } catch (\Throwable $exception) {
                report($exception);
                return response()->json(['message' => 'File upload failed. Please try again.'], 500);
            }
            if (!is_file($uploadDirectory . DIRECTORY_SEPARATOR . $fileName)) {
                return response()->json(['message' => 'File upload failed. Please try again.'], 500);
            }
            $messageData['message_type'] = $this->isInlineImageMime($mimeType) ? 'image' : 'file';
            $messageData['file_path'] = 'uploads/' . $fileName;
            $messageData['file_name'] = $file->getClientOriginalName();
        }

        $messageId = DB::table('chat_messages')->insertGetId(array_merge([
            'session_id' => $session->session_id,
            'sender' => 'agent',
            'status' => $status,
            'is_read' => 0,
            'created_at' => now(),
        ], $messageData));

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

    public function toggleBlock(string $sessionId): JsonResponse
    {
        $session = $this->findSessionOrFail($sessionId);
        $blocked = !(bool) $session->is_blocked;

        DB::table('chat_sessions')
            ->where('session_id', $session->session_id)
            ->update([
                'is_blocked' => $blocked ? 1 : 0,
                'last_activity' => now(),
            ]);

        DB::table('chat_messages')->insert([
            'session_id' => $session->session_id,
            'sender' => 'system',
            'message_type' => 'text',
            'message' => $blocked ? 'Chat blocked by support.' : 'Chat unblocked by support.',
            'status' => 'sent',
            'is_read' => 1,
            'created_at' => now(),
        ]);

        return response()->json([
            'session' => $this->sessionQuery()->where('s.session_id', $session->session_id)->first(),
        ]);
    }

    public function toggleClose(string $sessionId): JsonResponse
    {
        $session = $this->findSessionOrFail($sessionId);
        $closed = $session->status !== 'closed';

        DB::table('chat_sessions')
            ->where('session_id', $session->session_id)
            ->update([
                'status' => $closed ? 'closed' : 'open',
                'last_activity' => now(),
            ]);

        DB::table('chat_messages')->insert([
            'session_id' => $session->session_id,
            'sender' => 'system',
            'message_type' => 'text',
            'message' => $closed ? 'Chat closed by support.' : 'Chat reopened by support.',
            'status' => 'sent',
            'is_read' => 1,
            'created_at' => now(),
        ]);

        return response()->json([
            'session' => $this->sessionQuery()->where('s.session_id', $session->session_id)->first(),
        ]);
    }

    public function destroySession(string $sessionId): JsonResponse
    {
        $session = $this->findSessionOrFail($sessionId);

        DB::transaction(function () use ($session) {
            DB::table('chat_messages')->where('session_id', $session->session_id)->delete();
            DB::table('chat_sessions')->where('session_id', $session->session_id)->delete();
        });

        return response()->json(['success' => true]);
    }

    private function sessionQuery()
    {
        return DB::table('chat_sessions as s')
            ->select([
                's.session_id',
                's.visitor_name',
                's.visitor_email',
                's.ip_address',
                's.status',
                's.is_blocked',
                's.is_read',
                's.is_viewing',
                's.is_typing',
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
            ->selectSub(function ($query) {
                $query->from('chat_messages as m')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('m.session_id', 's.session_id');
            }, 'message_count')
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
            ? asset('public/' . ltrim($data['file_path'], '/'))
            : null;

        return $data;
    }

    private function isInlineImageMime(string $mimeType): bool
    {
        return in_array(strtolower($mimeType), [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'image/avif',
            'image/bmp',
            'image/x-ms-bmp',
        ], true);
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

    private function visitorIsOnline($session): bool
    {
        return !empty($session->last_presence)
            && strtotime((string) $session->last_presence) > now()->subSeconds(10)->timestamp;
    }

    private function visitorIsViewing($session): bool
    {
        return (bool) $session->is_viewing && $this->visitorIsOnline($session);
    }

    /**
     * Promote support messages as the visitor comes online or opens the chat.
     * Statuses only move forward: sent -> delivered -> seen.
     */
    private function syncAgentMessageStatuses(string $sessionId): void
    {
        $session = $this->findSession($sessionId);
        if (!$session) {
            return;
        }

        if ($this->visitorIsViewing($session)) {
            DB::table('chat_messages')
                ->where('session_id', $sessionId)
                ->where('sender', 'agent')
                ->where('status', '!=', 'seen')
                ->update(['status' => 'seen', 'is_read' => 1]);

            return;
        }

        if ($this->visitorIsOnline($session)) {
            DB::table('chat_messages')
                ->where('session_id', $sessionId)
                ->where('sender', 'agent')
                ->where('status', 'sent')
                ->update(['status' => 'delivered']);
        }
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
