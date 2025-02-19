/**
 * Need it in the front end part
 * or place directly in the script code
 */

importScripts('https://www.gstatic.com/firebasejs/9.6.1/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.6.1/firebase-messaging-compat.js');

const firebaseConfig = {
    apiKey: "AIzaSyCLdpvX9Pqla0ArSPJDNO92Vhb4YDNnaz4",
    authDomain: "laravel10fcmv1notification.firebaseapp.com",
    projectId: "laravel10fcmv1notification",
    storageBucket: "laravel10fcmv1notification.firebasestorage.app",
    messagingSenderId: "258268975282",
    appId: "1:258268975282:web:5c51cdc8a0e43d539279ab",
    measurementId: "G-BKE42J8185",
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    console.log('Received background message:', payload);
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: '/icon.png', // Optional: Add an icon
    };
    self.registration.showNotification(notificationTitle, notificationOptions);
});