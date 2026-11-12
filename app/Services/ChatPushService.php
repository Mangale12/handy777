<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class ChatPushService
{
    public static function isConfigured(): bool
    {
        return (bool) (config('services.webpush.public_key')
            && config('services.webpush.private_key')
            && config('services.webpush.subject'));
    }

    /**
     * Send a push notification to every subscribed support inbox.
     *
     * Push is intentionally best-effort. A push provider outage must never
     * make the visitor's chat message fail after it has been stored.
     */
    public function notifyAdmins(string $sessionId, string $visitorName, ?string $message, string $messageType = 'text'): void
    {
        if (!self::isConfigured()) {
            return;
        }

        try {
            $subscriptions = DB::table('chat_push_subscriptions')->get();
            if ($subscriptions->isEmpty()) {
                return;
            }

            $webPush = new WebPush([
                'VAPID' => [
                    'subject' => config('services.webpush.subject'),
                    'publicKey' => config('services.webpush.public_key'),
                    'privateKey' => config('services.webpush.private_key'),
                ],
            ], [
                'TTL' => 60,
                'urgency' => 'high',
            ], 10);

            $body = trim((string) $message);
            if ($body === '') {
                $body = $messageType === 'image' ? 'Sent a photo' : 'Sent an attachment';
            }

            $payload = json_encode([
                'title' => 'New chat message',
                'body' => $visitorName . ': ' . $body,
                'icon' => rtrim(request()->getBaseUrl(), '/') . '/images/abgaming.jpeg',
                // Keep the notification click on the current host and app
                // subdirectory, even when APP_URL still points at production.
                'url' => rtrim(request()->getBaseUrl(), '/') . '/admin/chat?session=' . rawurlencode($sessionId),
                'session_id' => $sessionId,
            ], JSON_UNESCAPED_SLASHES);

            foreach ($subscriptions as $storedSubscription) {
                $webPush->queueNotification(
                    Subscription::create([
                        'endpoint' => $storedSubscription->endpoint,
                        'publicKey' => $storedSubscription->public_key,
                        'authToken' => $storedSubscription->auth_token,
                        'contentEncoding' => $storedSubscription->content_encoding ?: 'aes128gcm',
                    ]),
                    $payload
                );
            }

            foreach ($webPush->flush() as $report) {
                if ($report->isSubscriptionExpired()) {
                    DB::table('chat_push_subscriptions')
                        ->where('endpoint', $report->getEndpoint())
                        ->delete();
                }
            }
        } catch (\Throwable $exception) {
            Log::warning('Chat web push notification failed.', [
                'session_id' => $sessionId,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
