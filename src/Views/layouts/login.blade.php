<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Panel Administrativo para controlar los recursos">
        <meta name="author" content="Locker Agencia">
        <title>Panel</title>
        <!-- Favicon -->
        <link rel="icon" href="{{asset('panel/assets/img/brand/favicon.png')}}" type="image/png">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
        <!-- Icons -->
        <link rel="stylesheet" href="{{asset('panel/assets/nucleo/css/nucleo.css')}}" type="text/css">
        <link rel="stylesheet" href="{{asset('panel/assets/@fortawesome/fontawesome-free/css/all.min.css')}}" type="text/css">
        <!-- Argon CSS -->
        <link rel="stylesheet" href="{{asset('panel/assets/nucleo/css/main.css?v=1.2.0')}}" type="text/css">
    </head>

<body style="background: linear-gradient(87deg,#dadada 0,#ffffff 100%)!important;">
<!-- Main content -->
<div class="main-content">
    @yield('content')
</div>
</body>

</html>