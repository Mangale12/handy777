<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Services\ChatPushService;

class ChatController extends Controller
{
    private const RATE_LIMIT = 30;
    private const RATE_DECAY = 60;
    private const INACTIVITY_GREETING_HOURS = 2;

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
            case 'delete_message':
                return $this->deleteMessage($request);
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
            'chat_code' => ['required', 'string', 'max:64'],
            'fp' => ['required', 'string', 'max:128'],
        ]);

        $chatCode = Str::upper(trim($data['chat_code']));
        $chatEmail = $this->chatEmailForCode($chatCode);

        if (!$chatEmail) {
            return response()->json([
                'error' => 'This chat code is invalid or chat is disabled.',
            ], 422);
        }

        $email = Str::lower(trim($chatEmail->email));
        // The chat_emails table controls access. A matching form is optional
        // and is used only to enrich the visitor profile in the chat UI.
        $form = $this->formForEmail($email);

        $name = trim((string) ($form->full_name ?? $chatEmail->display_name ?? $email));
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
            $this->touchChatEmail($email);

            return response()->json([
                'session_id' => $session->session_id,
                'new' => false,
                'user' => $form ? $this->formPayload($form) : ['full_name' => $name, 'email' => $email],
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
        $this->touchChatEmail($email);

        return response()->json([
            'session_id' => $sessionId,
            'new' => true,
            'user' => $form ? $this->formPayload($form) : ['full_name' => $name, 'email' => $email],
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
            'reply_to_id' => ['nullable', 'integer'],
        ]);
        $messageText = trim((string) ($data['message'] ?? ''));
        $replyToId = isset($data['reply_to_id']) ? (int) $data['reply_to_id'] : null;

        if ($replyToId !== null && !DB::table('chat_messages')
            ->where('id', $replyToId)
            ->where('session_id', $session->session_id)
            ->exists()) {
            return response()->json(['error' => 'The message you are replying to no longer exists.'], 422);
        }

        $file = $request->file('file') ?: $request->file('image');

        if (!$file && $messageText === '') {
            return response()->json(['error' => 'Write a message or attach a file.'], 422);
        }

        $message = [
            'message_type' => 'text',
            'message' => $messageText !== '' ? $messageText : null,
            'reply_to_id' => $replyToId,
        ];

        if ($file) {
            $fileField = $request->hasFile('file') ? 'file' : 'image';
            $allowedChatTypes = 'jpg,jpeg,png,gif,webp,avif,bmp,heic,heif,tif,tiff,pdf,doc,docx,xls,xlsx,csv,txt,zip';
            $fileRules = [
                'file' => ['file', 'max:10240', 'mimes:' . $allowedChatTypes],
                // Keep the legacy `image` field working, while allowing the
                // HEIC/HEIF files produced by iPhones.
                'image' => ['file', 'max:10240', 'mimes:jpg,jpeg,png,gif,webp,avif,bmp,heic,heif,tif,tiff'],
            ];
            $request->validate([$fileField => $fileRules[$fileField]]);

            $uploadDirectory = public_path('uploads');
            if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0755, true)) {
                return response()->json(['error' => 'File upload failed: upload folder is not writable.'], 500);
            }

            $fileName = Str::random(32) . '.' . strtolower($file->getClientOriginalExtension());
            // Read the MIME type while the uploaded temporary file still exists.
            $mimeType = (string) $file->getMimeType();
            try {
                $file->move($uploadDirectory, $fileName);
            } catch (\Throwable $exception) {
                report($exception);
                return response()->json(['error' => 'File upload failed. Please try again.'], 500);
            }
            if (!is_file($uploadDirectory . DIRECTORY_SEPARATOR . $fileName)) {
                return response()->json(['error' => 'File upload failed. Please try again.'], 500);
            }
            $message['message_type'] = $this->isInlineImageMime($mimeType)
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

        // Send the inactivity greeting only after the visitor has sent a real
        // message, never merely because the chat screen was opened.
        $this->sendInactivityGreeting($session, $messageId);

        $storedMessage = $this->messageQuery()->where('m.id', $messageId)->first();
        $pushSessionId = $session->session_id;
        $pushVisitorName = (string) ($session->visitor_name ?: $session->visitor_email ?: 'Visitor');
        $pushMessageType = $message['message_type'];
        // Keep push-provider latency out of the visitor's send response. The
        // callback runs during Laravel's termination phase after the response
        // has been sent to the browser.
        app()->terminating(function () use ($pushSessionId, $pushVisitorName, $messageText, $pushMessageType) {
            app(ChatPushService::class)->notifyAdmins(
                $pushSessionId,
                $pushVisitorName,
                $messageText,
                $pushMessageType
            );
        });
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

        // A message can be sent while support is offline and become delivered
        // later. Keep the persisted status in sync before returning the poll
        // response so the visitor's ticks reflect the recipient's presence.
        $this->syncVisitorMessageStatuses($session->session_id);

        DB::table('chat_messages')
            ->where('session_id', $session->session_id)
            ->where('sender', 'agent')
            ->where('status', '!=', 'seen')
            ->update(['status' => 'seen']);

        DB::table('chat_sessions')
            ->where('session_id', $session->session_id)
            ->update(['last_presence' => now()]);

        $messagesQuery = $this->messageQuery()
            ->where('m.session_id', $session->session_id)
            ->when($since > 0, function ($query) use ($since) {
                $query->where('m.id', '>', $since);
            })
            ->when($beforeId > 0, function ($query) use ($beforeId) {
                $query->where('m.id', '<', $beforeId);
            });

        if ($since > 0) {
            $messagesQuery->orderBy('m.created_at')->orderBy('m.id');
        } else {
            $messagesQuery->orderByDesc('m.created_at')->orderByDesc('m.id');
        }

        if ($limit > 0) {
            $messagesQuery->limit(min($limit, 100));
        }

        $messages = $messagesQuery->get();
        if ($since === 0) {
            $messages = $messages->reverse()->values();
        }
        $messages = $messages->map(fn ($message) => $this->formatMessage($message));

        // Status changes do not change a message's id, so they must be sent
        // separately when the client is polling with `since`.
        $statusUpdates = DB::table('chat_messages')
            ->select(['id', 'status'])
            ->where('session_id', $session->session_id)
            ->where('sender', 'visitor')
            ->orderBy('id')
            ->get();

        $freshSession = DB::table('chat_sessions')
            ->where('session_id', $session->session_id)
            ->first();

        return response()->json([
            'messages' => $messages,
            'status_updates' => $statusUpdates,
            'session' => $freshSession,
            'agent' => [
                'online' => $this->adminIsOnline(),
                'typing' => false,
                'viewing' => $this->visitorIsBeingViewed($session->session_id),
            ],
        ]);
    }

    private function deleteMessage(Request $request): JsonResponse
    {
        $session = $this->visitorSession($request);
        $messageId = max(0, (int) $request->input('message_id', 0));
        $message = DB::table('chat_messages')
            ->where('id', $messageId)
            ->where('session_id', $session->session_id)
            ->where('sender', 'visitor')
            ->first();

        if (!$message) {
            return response()->json(['error' => 'Only your messages can be deleted.'], 404);
        }

        DB::table('chat_messages')
            ->where('id', $messageId)
            ->where('session_id', $session->session_id)
            ->where('sender', 'visitor')
            ->delete();

        DB::table('chat_sessions')
            ->where('session_id', $session->session_id)
            ->update(['last_activity' => now()]);

        return response()->json([
            'success' => true,
            'message_id' => $messageId,
        ]);
    }

    private function sendInactivityGreeting($session, int $triggerMessageId): void
    {
        if ($session->status !== 'open'
            || (bool) $session->is_blocked
            || !$this->chatEmailAllowed((string) $session->visitor_email)) {
            return;
        }

        DB::transaction(function () use ($session, $triggerMessageId): void {
            $lockedSession = DB::table('chat_sessions')
                ->where('session_id', $session->session_id)
                ->lockForUpdate()
                ->first();

            if (!$lockedSession
                || $lockedSession->status !== 'open'
                || (bool) $lockedSession->is_blocked
                || !$this->chatEmailAllowed((string) $lockedSession->visitor_email)) {
                return;
            }

            $lastMessage = DB::table('chat_messages')
                ->where('session_id', $lockedSession->session_id)
                ->where('id', '<', $triggerMessageId)
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->first();

            if ($lastMessage
                && $lastMessage->sender === 'system'
                && $lastMessage->message === 'How can I help you?') {
                return;
            }

            if ($lastMessage
                && Carbon::parse($lastMessage->created_at)->gt(now()->subHours(self::INACTIVITY_GREETING_HOURS))) {
                return;
            }

            DB::table('chat_messages')->insert([
                'session_id' => $lockedSession->session_id,
                'sender' => 'system',
                'message_type' => 'text',
                'message' => 'How can I help you?',
                'status' => 'sent',
                'is_read' => 0,
                'created_at' => now(),
            ]);

            DB::table('chat_sessions')
                ->where('session_id', $lockedSession->session_id)
                ->update(['last_activity' => now()]);
        });
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

        $this->syncVisitorMessageStatuses($session->session_id);

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

    private function chatEmailForCode(string $chatCode)
    {
        if (!Schema::hasTable('chat_emails')) {
            return null;
        }

        return DB::table('chat_emails')
            ->whereRaw('UPPER(TRIM(chat_code)) = ?', [$chatCode])
            ->where('allow_chat', true)
            ->first();
    }

    private function chatEmailAllowed(string $email): bool
    {
        if (!$email || !Schema::hasTable('chat_emails')) {
            return false;
        }

        return DB::table('chat_emails')
            ->whereRaw('LOWER(TRIM(email)) = ?', [strtolower(trim($email))])
            ->where('allow_chat', true)
            ->exists();
    }

    private function touchChatEmail(string $email): void
    {
        if (!Schema::hasTable('chat_emails')) {
            return;
        }

        DB::table('chat_emails')
            ->whereRaw('LOWER(TRIM(email)) = ?', [$email])
            ->update(['last_chat_at' => now(), 'updated_at' => now()]);
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

        $data['reply_to'] = !empty($data['reply_to_id']) && array_key_exists('reply_to_sender', $data)
            && $data['reply_to_sender'] !== null
            ? [
                'id' => (int) $data['reply_to_id'],
                'sender' => $data['reply_to_sender'],
                'user_id' => null,
                'user_name' => null,
                'message' => $data['reply_to_message'],
                'message_type' => $data['reply_to_type'],
                'file_name' => $data['reply_to_file_name'],
            ]
            : null;

        unset($data['user_id'], $data['user_name'], $data['reply_to_sender'], $data['reply_to_user_id'], $data['reply_to_user_name'], $data['reply_to_message'], $data['reply_to_type'], $data['reply_to_file_name']);

        return $data;
    }

    private function messageQuery()
    {
        return DB::table('chat_messages as m')
            ->leftJoin('chat_messages as r', 'r.id', '=', 'm.reply_to_id')
            ->select([
                'm.id',
                'm.sender',
                'm.message',
                'm.message_type',
                'm.file_path',
                'm.file_name',
                'm.status',
                'm.reply_to_id',
                'm.created_at',
                'r.sender as reply_to_sender',
                'r.message as reply_to_message',
                'r.message_type as reply_to_type',
                'r.file_name as reply_to_file_name',
            ]);
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

    /**
     * Promote visitor messages as support comes online or opens the session.
     * Statuses only move forward: sent -> delivered -> seen.
     */
    private function syncVisitorMessageStatuses(string $sessionId): void
    {
        if ($this->visitorIsBeingViewed($sessionId)) {
            DB::table('chat_messages')
                ->where('session_id', $sessionId)
                ->where('sender', 'visitor')
                ->where('status', '!=', 'seen')
                ->update(['status' => 'seen', 'is_read' => 1]);

            return;
        }

        if ($this->adminIsOnline()) {
            DB::table('chat_messages')
                ->where('session_id', $sessionId)
                ->where('sender', 'visitor')
                ->where('status', 'sent')
                ->update(['status' => 'delivered']);
        }
    }
}
