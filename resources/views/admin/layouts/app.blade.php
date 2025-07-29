
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Admin Login')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & jQuery -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        html, body {
            height: 100%;
            background-color: #f5f5f5;
        }
        .login-container {
            margin-top: 8%;
        }
    </style>
</head>
<body>
    @include('admin.layouts.navbar');
    @yield('content')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
