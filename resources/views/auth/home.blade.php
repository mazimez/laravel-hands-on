<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }

        .container {
            padding: 100px;
        }

        h1 {
            font-size: 24px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ $user->name }} is logged in</h1>

        <p id='firebase-token'></p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</body>

<script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-messaging.js"></script>
<script>
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
    function IntitalizeFireBaseMessaging() {
        messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken();
            })
            .then(function (token) {
                document.getElementById('firebase-token').innerHTML   = "<b>Your firebase token is:</b> "+token
            })
            .catch(function (reason) {
                console.log(reason);
            });
    }

    IntitalizeFireBaseMessaging();
</script>
</html>
