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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
