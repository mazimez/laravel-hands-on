importScripts('https://www.gstatic.com/firebasejs/7.14.6/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.14.6/firebase-messaging.js');

var firebaseConfig = {
    apiKey: `{{ config('services.firebase.api_key') }}`,
    authDomain: `{{ config('services.firebase.auth_domain') }}`,
    projectId: `{{ config('services.firebase.project_id') }}`,
    storageBucket: `{{ config('services.firebase.storage_bucket') }}`,
    messagingSenderId: `{{ config('services.firebase.sender_id') }}`,
    appId: `{{ config('services.firebase.app_id') }}`,
    measurementId: `{{ config('services.firebase.measurement_id') }}`
};

firebase.initializeApp(firebaseConfig);
const messaging=firebase.messaging();

messaging.setBackgroundMessageHandler(function (payload) {
    const notification=JSON.parse(payload);
    const notificationOption={
        body:notification.body,
        icon:notification.icon
    };
    return self.registration.showNotification(payload.notification.title,notificationOption);
});
