/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************************!*\
  !*** ./resources/js/firebase-messaging-sw.js ***!
  \***********************************************/
importScripts("https://www.gstatic.com/firebasejs/8.2.10/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.2.10/firebase-analytics.js");
importScripts("https://www.gstatic.com/firebasejs/8.2.10/firebase-messaging.js");

// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
firebase.initializeApp({
  messagingSenderId: "242098786484",
  apiKey: "AIzaSyD5hjy4ytizT1opKVMyYY6yTjt9wLEehAU",
  projectId: "zinza-checkhang",
  appId: "1:242098786484:web:ad82ace57cbd2242b347e1"
});
if (firebase.messaging.isSupported()) {
  // Retrieve an instance of Firebase Messaging so that it can handle background
  // messages.
  var messaging = firebase.messaging();
  messaging.setBackgroundMessageHandler(function (payload) {
    // console.log(
    //     "[firebase-messaging-sw.js] Received background message ",
    //     payload
    // );

    // Customize notification here
    var notificationTitle = payload.data.title;
    var notificationOptions = {
      body: payload.data.body,
      icon: "/zinza.png",
      data: {
        url: payload.data.url
      }
    };
    return self.registration.showNotification(notificationTitle, notificationOptions);
  });
}
self.onnotificationclick = function (event) {
  var noti = event.notification,
    url = noti.data.url;
  noti.close();

  // Get all the Window clients
  event.waitUntil(clients.matchAll({
    includeUncontrolled: true,
    type: "window"
  }).then(function (clientsArr) {
    // If a Window tab matching the targeted URL already exists, focus that;
    var hadWindowToFocus = clientsArr.some(function (windowClient) {
      return windowClient.url === url ? (windowClient.focus(), true) : false;
    });
    // Otherwise, open a new tab to the applicable URL and focus it.
    if (!hadWindowToFocus) clients.openWindow(url).then(function (windowClient) {
      return windowClient ? windowClient.focus() : null;
    });
  }));
};
/******/ })()
;