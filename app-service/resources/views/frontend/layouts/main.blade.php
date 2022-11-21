<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>zcheck</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    @stack('stylesheet')
</head>
<body>
    <div class="container-fluid p-0">
        <section>
            @yield('content')
        </section>
    </div>

        {{-- <header>
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <div class="logo ps-5">
                        <a class="navbar-brand fs-2" href="/">
                            <img src="{{asset('/images/logo.png')}}" alt="">
                        </a>
                    </div>
                    <div class="collapse navbar-collapse justify-content-end pe-5" id="navbarNavAltMarkup">
                        <div class="navbar-nav action">
                            <a class="nav-link fs-5" href="/login"><i class="fa fa-sign-in"></i> Login</a>
                            <a class="nav-link fs-5 " href="/register"><i class="fa fa-user-plus"></i> Register</a>
                        </div>
                    </div>
                </div>
            </nav>
        </header> --}}
    </div>
    <script src="{{mix('js/app.js')}}"></script>
    <script src="{{mix('js/pad.js')}}"></script>
    @stack('js')
</body>
</html>
