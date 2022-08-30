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
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    @stack('stylesheet')
</head>
<body>
    <div id="main" class="d-flex">
        {{-- AdminSidebar --}}
        <nav class="navbar-default navbar-static-side">
            <ul class="nav-menu" id="side-menu">
                <li class="nav-header">
                    <img src="{{ asset('zinza.png') }}" alt="Zinza Talentscan" class="page-logo img-wrapper">
                    <div class="text">
                        <p class="name">{{ Auth::user()->name }}</p>
                        <p class="role">{{ Auth::user()->isAdmin() ? 'Admin' : 'Interviewer' }}</p>
                    </div>
                </li>
                @if (Auth::user()->isAdmin())
                    @include('partials.menu-admin')
                @else
                       @include('partials.menu-interviewer')
                @endif
                <li>
                    <a href="#" class="menu-link">
                        <i class="fa fa-key" aria-hidden="true"></i>
                        <span>Change password</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div id="page-wrapper">
            {{-- Topbar --}}
            <div class="topbar">
                <div class="goto-home">
                    <a href="{{ route('home') }}">Home</a>
                </div>
                <div class="right">
                    {{-- If admin --}}
                    @if (Auth::user()->isAdmin())
                       @include('partials.admin-topbar')
                    @endif
                    <div class="logout">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i>
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
            {{-- Main content --}}
            <div class="main-page-content @yield('classname', '')">
                @yield('content')
                <div class="toast-container"></div>
            </div>
        </div>
    </div>
</body>
</html>
