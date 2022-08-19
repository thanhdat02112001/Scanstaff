<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>StaffScan</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="{{asset('js/app.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    @stack('stylesheet')
</head>
<body>
    <div class="container-fluid" style="padding: 0px">
        <header>
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <div class="logo ps-5">
                        <a class="navbar-brand fs-2" href="/">STAFFSCAN</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse justify-content-end pe-5" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="nav-link fs-5" href="/login"><i class="fa fa-sign-in"></i> Login</a>
                            <a class="nav-link fs-5 " href="/register"><i class="fa fa-user-plus"></i> Register</a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <section>
            @yield('content')
        </section>
    </div>
    @stack('js')
</body>
</html>
