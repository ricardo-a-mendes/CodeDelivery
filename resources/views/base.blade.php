<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Code Delivery</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Latest compiled and minified jQuery -->
    <script src="http://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <style type="text/css">
        /* In order to fixed top menu */
        body { padding-top: 70px; }
    </style>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <a href="{{route('userList')}}" class="btn btn-default navbar-btn">Users</a>
        <a href="{{route('clientList')}}" class="btn btn-default navbar-btn">Clients</a>
        <a href="{{route('orderList')}}" class="btn btn-default navbar-btn">Orders</a>
    </div>
</nav>
<div class="container">

    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            <strong>Well done \o/</strong> {{ Session::get('success') }}
        </div>
    @endif
        @if (Session::has('error'))
            <div class="alert alert-danger" role="alert">
                <strong>Oh snap :(</strong> {{ Session::get('error') }}
            </div>
        @endif
    @yield('content')
</div>
</body>
</html>