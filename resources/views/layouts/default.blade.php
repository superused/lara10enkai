<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text.html; charset=utf-8" />
    @yield('metaIcon')
    <title>@yield('title')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <!-- <link rel="stylesheet" href="{{asset('css/style.css')}}"> -->
    @yield("css")
    <!-- <script src="{{asset('js/app.js')}}"></script> -->
</head>
<body>
    @yield('menu')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-sm-10 main mx-auto">
                @yield('content')
            </div>
        </div>
    </div>
    @yield('script')
</body>
</html>