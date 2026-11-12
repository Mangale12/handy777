/* Chat inbox Web Push service worker. Keep this file at the application root
 * so its default scope covers the admin chat page. */
self.addEventListener('push', function (event) {
    var data = {};

    try {
        data = event.data ? event.data.json() : {};
    } catch (error) {
        data = { body: event.data ? event.data.text() : 'New chat message' };
    }

    var title = data.title || 'New chat message';
    var options = {
        body: data.body || 'A visitor sent a new message.',
        icon: data.icon || undefined,
        badge: data.icon || undefined,
        tag: data.session_id ? 'chat-' + data.session_id : 'chat-message',
        renotify: true,
        silent: false,
        requireInteraction: true,
        vibrate: [100, 50, 100],
        data: {
            url: data.url || '/',
            session_id: data.session_id || null
        }
    };

    event.waitUntil(
        self.clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (clientList) {
            var hasVisibleChat = clientList.some(function (client) {
                return client.visibilityState === 'visible';
            });

            // The open admin page plays the sound itself. Avoid duplicating
            // that alert with an OS notification while the inbox is visible.
            if (hasVisibleChat) return undefined;
            return self.registration.showNotification(title, options);
        })
    );
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();

    var targetUrl = event.notification.data && event.notification.data.url
        ? event.notification.data.url
        : '/';

    event.waitUntil(
        self.clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (clientList) {
            for (var i = 0; i < clientList.length; i += 1) {
                var client = clientList[i];
                if ('focus' in client) {
                    return client.navigate(targetUrl).then(function (navigatedClient) {
                        return navigatedClient.focus();
                    });
                }
            }

            if (self.clients.openWindow) {
                return self.clients.openWindow(targetUrl);
            }

            return undefined;
        })
    );
});
