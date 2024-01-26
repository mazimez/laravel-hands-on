<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #0f0f1a;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .title {
            text-align: center;
            font-size: 36px;
            margin-bottom: 30px;
        }

        .card {
            width: 500px;
            max-width: 90%;
            background-color: #1e213a;
            padding: 40px;
            border-radius: 10px;
            border-top: 4px solid #19d4ca;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        input {
            padding: 15px;
            border: none;
            background-color: transparent;
            border-bottom: 1px solid #ccc;
            color: #fff;
            transition: box-shadow 0.3s;
        }

        input:focus {
            box-shadow: 0 0 10px #19d4ca;
        }

        .buttons {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 15px;
        }

        .login-button,
        .register-link {
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s, color 0.3s;
            text-decoration: none;
        }

        .login-button {
            background-color: #19d4ca;
            color: #fff;
        }

        .login-button:hover {
            background-color: #1ad4c0;
            box-shadow: none;
        }

        .login-button:active {
            box-shadow: 0 0 10px #19d4ca;
        }

        .register-link {
            color: #ccc;
            background-color: transparent;
        }

        .register-link:hover {
            color: #fff;
        }

        .register-link:active {
            box-shadow: 0 0 10px #ccc;
        }

        .alert {
            background-color: #ff6b6b;
            /* Background color for alerts */
            color: #fff;
            /* Text color for alerts */
            padding: 5px;
            /* Padding around the alert content */
            border-radius: 5px;
            /* Rounded corners */
        }

        .alert-danger {
            background-color: #ff0000;
            /* Background color for danger alerts */
        }

        @media (max-width: 768px) {
            .card {
                width: 90%;
                max-width: 400px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="title">{{ config('app.name') }}</h1>
        <div class="card">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="email" placeholder="Username" name="email" required>
                <input type="password" placeholder="Password" name="password" required>
                <div class="buttons">
                    <button type="submit" class="login-button">Login</button>
                </div>
            </form>
            @if ($errors->any())
                <div class="alert alert-danger" style="font-weight: bold;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</body>

</html>
