importScripts("https://www.gstatic.com/firebasejs/8.2.10/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.2.10/firebase-analytics.js");
importScripts("https://www.gstatic.com/firebasejs/8.2.10/firebase-messaging.js");

// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
firebase.initializeApp({
    messagingSenderId: process.env.MIX_FIREBASE_MESSAGING_SENDER_ID,
    apiKey: process.env.MIX_FIREBASE_API_KEY,
    projectId: process.env.MIX_FIREBASE_PROJECT_ID,
    appId: process.env.MIX_FIREBASE_APP_ID,
});

if (firebase.messaging.isSupported()) {
    // Retrieve an instance of Firebase Messaging so that it can handle background
    // messages.
    const messaging = firebase.messaging();

    messaging.setBackgroundMessageHandler(function(payload) {
        // console.log(
        //     "[firebase-messaging-sw.js] Received background message ",
        //     payload
        // );

        // Customize notification here
        const notificationTitle = payload.data.title;
        const notificationOptions = {
            body: payload.data.body,
            icon: "/zinza.png",
            data: {
                url: payload.data.url
            }
        };

        return self.registration.showNotification(
            notificationTitle,
            notificationOptions
        );
    });
}

self.onnotificationclick = function(event) {
    let noti = event.notification,
        url = noti.data.url;
    noti.close();

    // Get all the Window clients
    event.waitUntil(
        clients
            .matchAll({ includeUncontrolled: true, type: "window" })
            .then(clientsArr => {
                // If a Window tab matching the targeted URL already exists, focus that;
                const hadWindowToFocus = clientsArr.some(windowClient =>
                    windowClient.url === url
                        ? (windowClient.focus(), true)
                        : false
                );
                // Otherwise, open a new tab to the applicable URL and focus it.
                if (!hadWindowToFocus)
                    clients
                        .openWindow(url)
                        .then(windowClient =>
                            windowClient ? windowClient.focus() : null
                        );
            })
    );
};
