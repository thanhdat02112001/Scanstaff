<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @auth
    <meta name="username" content="{{ Auth::user()->name }}">
    @endauth
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>zcheck</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <link rel="stylesheet" href="{{mix('css/admin.css')}}">
    <link rel="stylesheet" href="{{mix('css/user.css')}}">
    <link rel="stylesheet" href="{{mix('css/codemirror.css')}}">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
                <li class="{{Request::segment(1) == 'password-change' ? 'active-nav' : ''}}">
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
        <div class="toast-container"></div>
    </div>

    <template id="push-notify">
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
            <div class="toast-header">
                <strong class="mr-auto">New user</strong>
                <small class="text-muted">Just now</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                <a href=""></a>
            </div>
        </div>
    </template>
    <script src="{{mix('js/app.js')}}"></script>
    <script src="{{mix('js/bootstrap.js')}}"></script>
    @if (Auth::user()->isAdmin())
        <script src="{{mix('js/admin.js')}}"></script>
    @endif
    <script src="{{ mix('js/codemirror.js') }}"></script>
    <script src="{{mix('js/user.js')}}" defer></script>
</body>
</html>
