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
    <link rel="stylesheet" href="{{mix('css/admin.css')}}">
    <link rel="stylesheet" href="{{mix('css/user.css')}}">
    @stack('stylesheet')
</head>
<body>
    <div class="vertical-menu">
        <div class="navbar-brand-box">
            <a href="#" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="{{asset('/images/logo.png')}}" alt="logo" height="200">
                </span>
            </a>
        </div>
        <div class="sidebar-item">
            <ul>
                @if (Auth::user()->isAdmin())
                    @include('partials.menu-admin')
                @else
                    @include('partials.menu-interviewer')
                @endif
                <li>
                    <a href="/password-change" class="">
                        <i class="fa fa-key me-1"></i> Change password
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidebar-background"></div>
    </div>
    <header id="page-topbar">
        <div class="navbar-header">
            <div>
                <nav class="fs-5" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/user-home">Userhome</a>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex align-item-center">
                @if (Auth::user()->isAdmin())
                    @include('partials.admin-topbar')
                @endif
                <form action="{{route('logout')}}" method="POST">
                    @csrf
                    <button class="logout" type="submit">
                        <i class="fa fa-sign-out ms-3" aria-hidden="true"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </header>
    <div class="content">
        @yield('content')
    </div>
    <script src="{{mix('js/app.js')}}"></script>
    <script src="{{mix('js/bootstrap.js')}}"></script>
    <script src="{{mix('js/admin.js')}}"></script>
</body>
</html>
