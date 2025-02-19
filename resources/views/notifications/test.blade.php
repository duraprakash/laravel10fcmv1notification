<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test FCM Notification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Firebase SDK -->
    <!-- <script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-messaging.js"></script> -->
    <!-- With these -->
    <script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-messaging-compat.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Test FCM Notification</h1>
        <div id="tokenSection" class="mb-4">
            <p>Your FCM Token: <strong id="fcmToken"></strong></p>
            <button id="copyToken" class="btn btn-secondary">Copy Token</button>
        </div>
        <form id="notificationForm">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="body" class="form-label">Body</label>
                <input type="text" class="form-control" id="body" name="body" required>
            </div>
            <div class="mb-3">
                <label for="data" class="form-label">Data (JSON)</label>
                <textarea class="form-control" id="data" name="data" rows="3"
                    placeholder='{"key1":"value1","key2":"value2"}'></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Notification</button>
        </form>
        <div id="response" class="mt-4"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Firebase configuration
        const firebaseConfig = {
            apiKey: "AIzaSyCLdpvX9Pqla0ArSPJDNO92Vhb4YDNnaz4",
            authDomain: "laravel10fcmv1notification.firebaseapp.com",
            projectId: "laravel10fcmv1notification",
            storageBucket: "laravel10fcmv1notification.firebasestorage.app",
            messagingSenderId: "258268975282",
            appId: "1:258268975282:web:5c51cdc8a0e43d539279ab",
        };

        // Initialize Firebase
        const app = firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        // Request permission and get FCM token
        function requestPermissionAndGetToken() {
            Notification.requestPermission().then((permission) => {
                if (permission === 'granted') {
                    console.log('Notification permission granted.');
                    messaging.getToken({ vapidKey: 'BJizXB8BE4vXedNzso88WyM08yf4Ka4a3TQ-phueun6oWgVvxPhPkeEgQDsWygRlz1WGerO59YNCwuRXgpIDPR8' }).then((currentToken) => {
                        if (currentToken) {
                            console.log('FCM Token:', currentToken);
                            $('#fcmToken').text(currentToken);
                            $('#copyToken').on('click', () => {
                                navigator.clipboard.writeText(currentToken);
                                alert('Token copied to clipboard!');
                            });
                            // Send the token to your Laravel backend
                            $.post('/store-token', { token: currentToken }, function (response) {
                                console.log('Token stored successfully:', response);
                            });
                        } else {
                            console.log('No registration token available.');
                        }
                    }).catch((err) => {
                        console.log('An error occurred while retrieving token.', err);
                    });
                } else {
                    console.log('Unable to get permission to notify.');
                }
            });
        }

        // Call the function to request permission and get the token
        requestPermissionAndGetToken();

        // Handle form submission
        $(document).ready(function () {
            $('#notificationForm').on('submit', function (e) {
                e.preventDefault();

                const formData = {
                    token: $('#fcmToken').text(),
                    title: $('#title').val(),
                    body: $('#body').val(),
                    data: $('#data').val() ? JSON.parse($('#data').val()) : {},
                };

                $.ajax({
                    url: '/api/send-notification',
                    method: 'POST',
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    success: function (response) {
                        $('#response').html(`<div class="alert alert-success">${response.message}</div>`);
                    },
                    error: function (xhr) {
                        const errorMessage = xhr.responseJSON?.message || 'An error occurred.';
                        $('#response').html(`<div class="alert alert-danger">${errorMessage}</div>`);
                    }
                });
            });
        });

        /**
         * Registering the service worker
         */
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/firebase-messaging-sw.js')
                .then((registration) => {
                    console.log('Service Worker registered:', registration);
                })
                .catch((error) => {
                    console.log('Service Worker registration failed:', error);
                });
        } // end of registering the service worker
    </script>
</body>

</html>