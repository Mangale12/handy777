<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    private const RATE_LIMIT = 30;
    private const RATE_DECAY = 60;

    /**
     * The public chat endpoint. The legacy PHP switchboard used the same
     * action names, so the browser can keep one small JSON client while all
     * persistence and validation now goes through Laravel.
     */
    public function handle(Request $request): JsonResponse
    {
        switch ($request->input('action')) {
            case 'start_session':
                return $this->startSession($request);
            case 'send_message':
                return $this->sendMessage($request);
            case 'get_messages':
                return $this->getMessages($request);
            case 'heartbeat':
                return $this->heartbeat($request);
            case 'check_rate_limit':
                return $this->checkRateLimit($request);
            case 'reopen_session':
                return $this->reopenSession($request);
            case 'get_settings':
                return response()->json([
                    'settings' => [
                        'support_name' => config('app.name', 'AB Gaming Support'),
                    ],
                ]);
            default:
                return response()->json(['error' => 'Unknown chat action.'], 400);
        }
    }

    private function startSession(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:150'],
            'fp' => ['required', 'string', 'max:128'],
        ]);

        $email = Str::lower(trim($data['email']));
        $form = $this->formForEmail($email);

        if (!$form) {
            return response()->json([
                'error' => 'No account was found with this email address.',
            ], 422);
        }

        $name = trim((string) ($form->full_name ?: $email));
        $session = DB::table('chat_sessions')
            ->where('status', 'open')
            ->where(function ($query) use ($email, $data) {
                $query->where('visitor_email', $email)
                    ->orWhere(function ($fingerprint) use ($data) {
                        $fingerprint->where('browser_fp', $data['fp'])
                            ->whereNull('visitor_email');
                    });
            })
            ->orderByDesc('created_at')
            ->first();

        if ($session) {
            DB::table('chat_sessions')
                ->where('session_id', $session->session_id)
                ->update([
                    'visitor_name' => $name,
                    'visitor_email' => $email,
                    'browser_fp' => $data['fp'],
                    'ip_address' => $request->ip(),
                    'last_presence' => now(),
                    'last_activity' => now(),
                ]);

            return response()->json([
                'session_id' => $session->session_id,
                'new' => false,
                'user' => $this->formPayload($form),
            ]);
        }

        $sessionId = Str::random(40);
        DB::table('chat_sessions')->insert([
            'session_id' => $sessionId,
            'visitor_name' => $name,
            'visitor_email' => $email,
            'browser_fp' => $data['fp'],
            'ip_address' => $request->ip(),
            'status' => 'open',
            'is_read' => 0,
            'is_blocked' => 0,
            'is_viewing' => 1,
            'is_typing' => 0,
            'last_activity' => now(),
            'last_presence' => now(),
            'created_at' => now(),
        ]);

        return response()->json([
            'session_id' => $sessionId,
            'new' => true,
            'user' => $this->formPayload($form),
        ]);
    }

    private function sendMessage(Request $request): JsonResponse
    {
        $session = $this->visitorSession($request);

        if ($session->status === 'closed') {
            return response()->json(['error' => 'This chat is closed.'], 403);
        }

        if ($session->is_blocked) {
            return response()->json(['error' => 'Message sending is disabled for this chat.'], 403);
        }

        $rateKey = 'chat-messages:' . $session->session_id;
        if (RateLimiter::tooManyAttempts($rateKey, self::RATE_LIMIT)) {
            $retryAfter = RateLimiter::availableIn($rateKey);

            return response()->json([
                'error' => 'You have sent too many messages. Please try again shortly.',
                'rate_blocked' => true,
                'retry_after' => $retryAfter,
            ], 429);
        }

        $adminOnline = $this->adminIsOnline();
        $status = $this->visitorIsBeingViewed($session->session_id)
            ? 'seen'
            : ($adminOnline ? 'delivered' : 'sent');

        $data = $request->validate([
            'message' => ['nullable', 'string', 'max:5000'],
        ]);
        $messageText = trim((string) ($data['message'] ?? ''));
        $file = $request->file('file') ?: $request->file('image');

        if (!$file && $messageText === '') {
            return response()->json(['error' => 'Write a message or attach a file.'], 422);
        }

        $message = [
            'message_type' => 'text',
            'message' => $messageText !== '' ? $messageText : null,
        ];

        if ($file) {
            $fileField = $request->hasFile('file') ? 'file' : 'image';
            $fileRules = [
                'file' => ['file', 'max:10240', 'mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx,csv,txt,zip'],
                'image' => ['image', 'mimes:jpg,jpeg,png,gif,webp', 'max:10240'],
            ];
            $request->validate([$fileField => $fileRules[$fileField]]);

            $uploadDirectory = public_path('uploads');
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }

            $fileName = Str::random(32) . '.' . strtolower($file->getClientOriginalExtension());
            // Read the MIME type while the uploaded temporary file still exists.
            $mimeType = (string) $file->getMimeType();
            $file->move($uploadDirectory, $fileName);
            $message['message_type'] = strpos($mimeType, 'image/') === 0
                ? 'image'
                : 'file';
            $message['file_path'] = 'uploads/' . $fileName;
            $message['file_name'] = $file->getClientOriginalName();
        }

        RateLimiter::hit($rateKey, self::RATE_DECAY);

        $messageId = DB::table('chat_messages')->insertGetId(array_merge([
            'session_id' => $session->session_id,
            'sender' => 'visitor',
            'status' => $status,
            'is_read' => 0,
            'created_at' => now(),
        ], $message));

        DB::table('chat_sessions')
            ->where('session_id', $session->session_id)
            ->update([
                'last_activity' => now(),
                'last_presence' => now(),
                'is_read' => 0,
            ]);

        $storedMessage = DB::table('chat_messages')->where('id', $messageId)->first();
        $response = [
            'success' => true,
            'id' => $messageId,
            'status' => $status,
            'message' => $this->formatMessage($storedMessage),
        ];

        if (RateLimiter::attempts($rateKey) >= self::RATE_LIMIT - 5) {
            $response['rate_warn'] = true;
            $response['rate_warn_msg'] = 'You are sending messages quickly. Please slow down.';
        }

        return response()->json($response);
    }

    private function getMessages(Request $request): JsonResponse
    {
        $session = $this->visitorSession($request);
        $since = max(0, (int) $request->input('since', 0));
        $beforeId = max(0, (int) $request->input('before_id', 0));
        $limit = max(0, (int) $request->input('limit', 0));

        DB::table('chat_messages')
            ->where('session_id', $session->session_id)
            ->where('sender', 'agent')
            ->where('status', '!=', 'seen')
            ->update(['status' => 'seen']);

        DB::table('chat_sessions')
            ->where('session_id', $session->session_id)
            ->update(['last_presence' => now()]);

        $messagesQuery = DB::table('chat_messages')
            ->select(['id', 'sender', 'message', 'message_type', 'file_path', 'file_name', 'status', 'created_at'])
            ->where('session_id', $session->session_id)
            ->when($since > 0, function ($query) use ($since) {
                $query->where('id', '>', $since);
            })
            ->when($beforeId > 0, function ($query) use ($beforeId) {
                $query->where('id', '<', $beforeId);
            });

        if ($since > 0) {
            $messagesQuery->orderBy('created_at')->orderBy('id');
        } else {
            $messagesQuery->orderByDesc('created_at')->orderByDesc('id');
        }

        if ($limit > 0) {
            $messagesQuery->limit(min($limit, 100));
        }

        $messages = $messagesQuery->get();
        if ($since === 0) {
            $messages = $messages->reverse()->values();
        }
        $messages = $messages->map(fn ($message) => $this->formatMessage($message));

        $freshSession = DB::table('chat_sessions')
            ->where('session_id', $session->session_id)
            ->first();

        return response()->json([
            'messages' => $messages,
            'session' => $freshSession,
            'agent' => [
                'online' => $this->adminIsOnline(),
                'typing' => false,
                'viewing' => $this->visitorIsBeingViewed($session->session_id),
            ],
        ]);
    }

    private function heartbeat(Request $request): JsonResponse
    {
        $session = $this->visitorSession($request);
        $leaving = $request->boolean('is_leaving');
        $viewing = !$leaving && $request->boolean('is_viewing');
        $typing = !$leaving && $request->boolean('is_typing');

        DB::table('chat_sessions')
            ->where('session_id', $session->session_id)
            ->update([
                'last_presence' => $leaving ? now()->subMinute() : now(),
                'is_viewing' => $viewing,
                'is_typing' => $typing,
            ]);

        if ($viewing) {
            DB::table('chat_messages')
                ->where('session_id', $session->session_id)
                ->where('sender', 'agent')
                ->where('status', '!=', 'seen')
                ->update(['status' => 'seen']);
        }

        return response()->json(['success' => true]);
    }

    private function checkRateLimit(Request $request): JsonResponse
    {
        $session = $this->visitorSession($request, false);
        if (!$session) {
            return response()->json(['blocked' => false, 'warn' => false, 'retry_after' => 0]);
        }

        $key = 'chat-messages:' . $session->session_id;
        return response()->json([
            'blocked' => RateLimiter::tooManyAttempts($key, self::RATE_LIMIT),
            'warn' => RateLimiter::attempts($key) >= self::RATE_LIMIT - 5,
            'retry_after' => RateLimiter::availableIn($key),
        ]);
    }

    private function reopenSession(Request $request): JsonResponse
    {
        $session = $this->visitorSession($request);
        DB::table('chat_sessions')->where('session_id', $session->session_id)->update(['status' => 'open']);
        DB::table('chat_messages')->insert([
            'session_id' => $session->session_id,
            'sender' => 'system',
            'message_type' => 'text',
            'message' => 'Chat has been reopened.',
            'status' => 'sent',
            'is_read' => 0,
            'created_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    private function visitorSession(Request $request, bool $required = true)
    {
        $sessionId = (string) ($request->header('X-Session-ID') ?: $request->input('session_id'));
        $session = $sessionId
            ? DB::table('chat_sessions')->where('session_id', $sessionId)->first()
            : null;

        if (!$session && $required) {
            abort(response()->json(['error' => 'Session not found.'], 404));
        }

        if ($session && $request->header('X-Chat-Fingerprint')
            && hash_equals((string) $session->browser_fp, (string) $request->header('X-Chat-Fingerprint'))) {
            return $session;
        }

        if ($session && $request->header('X-Chat-Fingerprint')
            && !hash_equals((string) $session->browser_fp, (string) $request->header('X-Chat-Fingerprint'))) {
            abort(response()->json(['error' => 'Session not found.'], 404));
        }

        return $session;
    }

    private function formForEmail(string $email): ?Form
    {
        return Form::query()
            ->whereRaw('LOWER(TRIM(email)) = ?', [$email])
            ->first();
    }

    private function formPayload(Form $form): array
    {
        return [
            'id' => $form->id,
            'full_name' => $form->full_name,
            'email' => $form->email,
            'number' => $form->number,
            'game_id' => $form->game_id,
            'facebook_name' => $form->facebook_name,
            'mail' => $form->mail,
            'status_id' => $form->status_id,
            'balance' => $form->balance,
        ];
    }

    private function formatMessage($message): array
    {
        $data = (array) $message;
        $data['file_url'] = !empty($data['file_path'])
            ? asset('public/' . ltrim($data['file_path'], '/'))
            : null;

        return $data;
    }

    private function adminIsOnline(): bool
    {
        if (!Schema::hasTable('admin_users')) {
            return false;
        }

        return DB::table('admin_users')
            ->where('last_activity', '>', now()->subSeconds(10))
            ->exists();
    }

    private function visitorIsBeingViewed(string $sessionId): bool
    {
        if (!Schema::hasTable('admin_users')) {
            return false;
        }

        return DB::table('admin_users')
            ->where('last_activity', '>', now()->subSeconds(10))
            ->where('is_viewing', 1)
            ->where(function ($query) use ($sessionId) {
                $query->where('viewing_session_id', $sessionId)
                    ->orWhereNull('viewing_session_id');
            })
            ->exists();
    }
}
