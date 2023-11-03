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
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</body>
</html>
