<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Panel Administrativo para controlar los recursos">
    <meta name="author" content="rodsaseg">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel</title>
    <!-- Favicon -->
    <link rel="icon" href="{{asset('panel/img/brand/favicon.png')}}" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('panel/assets/nucleo/css/nucleo.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('panel/assets/@fortawesome/fontawesome-free/css/all.min.css')}}" type="text/css">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{asset('panel/assets/nucleo/css/main.css?v=1.0.0')}}" type="text/css">
</head>

<body>
    @include('vendor.panel.includes.sidebar')
    <!-- Main content -->
    <div class="main-content" id="panel">
        @include('vendor.panel.includes.navbar')
        @yield('content')
        <div id="bin-delete" class="position-fixed" style="right: 35px; bottom: 20px;display:none;">
            <button class="btn btn-lg btn-icon btn-danger" type="button" style="border-radius:50px;font-size: 35px;padding: 8px 19px;" title="Eliminar">
                <span class="btn-inner--icon">
                    <i class="fa fa-trash"></i>
                </span>
            </button>
        </div>
    </div>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'baseUrl' => url('/'),
            'routes' => collect(\Route::getRoutes())->mapWithKeys(function ($route) { return [$route->getName() => $route->uri()]; })
        ]) !!};
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
    <script src="{{asset('panel/assets/js/main.js?v=1.0.0')}}"></script>
    @stack('js')
</body>

</html>