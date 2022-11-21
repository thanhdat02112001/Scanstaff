<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="pad_id" content="{{ $pad->id }}">
    <meta name="sid" content="{{ Session::getId() }}">

    <title>{{ $pad->lg . ' | zcheck' }}</title>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{mix('css/codemirror.css')}}">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body class="page-pad">
    <div class="workspace">
        <div class="CodePanel">
            <div class="action-bar">
                <button class="btn btn-primary run">Run</button>
                    @guest
                        <div class="dropdown message-dropdown">
                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Message</button>
                            <div class="dropdown-menu messageDropdown">
                                <form action="{{ route('pad.send-noti', $pad->id) }}" method="POST" class="push-noti">
                                    <input type="text" name="message" required class="push-noti-body" placeholder="Enter message">
                                    <input type="submit" class="btn btn-send-noti" value="Send">
                                </form>
                                <div class="alert alert-secondary alert-dismissible fade show sending" role="alert">
                                    Sending...
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="alert alert-success alert-dismissible fade show sent" role="alert">
                                    Notification sent
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="alert alert-danger alert-dismissible fade show fail" role="alert">
                                    sending failed
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <p>Example:</p>
                                <div class="suggestion">
                                    <p>Xin dừng bài test</p>
                                    <p>Cần giúp đỡ</p>
                                    <p>Đã hoàn thành</p>
                                </div>
                            </div>
                        </div>
                    @endguest
                <div>
                    <select name="language_id" id="select_lg">
                        @foreach ($langs as $lang)
                            <option value="{{ $lang->id }}" data-mode="{{ $lang->mode }}"
                                {{ $lang->id === $pad->language_id ? 'selected' : '' }}>{{ $lang->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="code">
                <textarea name="content" id="pad-content"></textarea>
            </div>
        </div>
        <div class="resizer"></div>
        <div class="RightPanel">
            <div class="topbar">
                @if (Auth::check())
                    <ul class="tabs">
                        <li class="output active">Program Output</li>
                        <li class="notes">Interviewers Notes</li>
                    </ul>
                @endif
                <button class="btn reset">Reset</button>
            </div>
            <div class="right-wrapper">
                <div class="console" id="console"></div>
                <textarea class="d-none op">{{ $pad->output }}</textarea>
                @if (Auth::check())
                    <div class="notes">
                        <textarea name="note" id="note" placeholder="Enter your note here">{{ $pad->note }}</textarea>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="footer-left">
            <div class="dropup invite-dropup">
                <button class="btn invite dropup dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button">Invite</button>
                <div class="dropdown-menu inviteDropdown">
                    <div class="email">
                        <h4 class="header">Send Email Invite:</h4>
                        <p>We’ll email the recipient directly with a link, so you don’t have to give away your email address.</p>
                        <form action="{{ route('email-invite') }}" method="POST" class="emailInvite">
                            <input type="email" name="email" required class="email-invite" placeholder="Recipient’s email address">
                            <input type="submit" class="btn btn-send" value="Send">
                        </form>
                        <div class="alert alert-secondary alert-dismissible fade show sending" role="alert">
                            Sending...
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="alert alert-success alert-dismissible fade show sent" role="alert">
                            Email sent
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="alert alert-danger alert-dismissible fade show fail" role="alert">
                            sending failed
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="separator">
                        <span>or</span>
                    </div>
                    <div class="link">
                        <h4 class="header">Permanent Link</h4>
                        <p>If you need a permanent link to email for a future interview, use this full URL.</p>
                        <input type="text" class="url" value="{{ Request::url() }}">
                    </div>
                    <span class="caret"></span>
                </div>
            </div>
            <ul class="user-list">
                @foreach ($participants as $item)
                    @php
                       $user = json_decode($item);
                    @endphp
                    <li class="user" data-sid="{{ $user->session_id }}" data-name="{{ $user->name }}">
                        <span class="colorIndicator"></span>
                        <span class="username">{{ $user->name }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
        @auth
            <div class="footer-right">
                <input type="text" class="title-ft" value="{{ $pad->title }}">
                @if ($pad->status !== App\Models\Pad::STATUS_ENDED)
                    <button class="btn red-btn" data-toggle="modal" data-target="#modalEnd">End Interview</button>
                @else
                    <a href="{{ route('interviewer.pad.index') }}" class="btn btn-light">Return to pads</a>
                @endif
            </div>
        @endauth
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalEnd" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">End Interview?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Ending the interview will prevent interviewees from accessing this pad. Only
                        you and your organization can see it.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <form action="{{ route('interviewer.pad.end', $pad->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-danger">End</button>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="full-screen-overlay">
        <div class="enter-content">
            <h3>Joining as a interviewee?</h3>
            <p>Enter your name here:</p>
            <div class="form-input">
                <input type="text" id="candidate_name" @auth
                    value="{{ Auth::user()->name }}"
                @endauth>
                <button class="btn btn-primary btn-go">Go!</button>
            </div>
            <div class="form-confirm">
                <p>Some one used this name before. Was that you? If not, please enter a new name, you can
                    use more info like your birth year, join date, ...</p>
                <div>
                    <button class="btn btn-primary btn-confirm">Yes. That was me</button>
                    <button class="btn btn-secondary btn-no">Enter again</button>
                </div>
            </div>
        </div>
    </div>
     <script src="{{ mix('js/codemirror.js') }}"></script>
     <script src="{{ asset('js/xterm.js') }}"></script>
    <!-- Scripts -->
    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/7.21.0/firebase-app.js"></script>

    <!-- TODO: Add SDKs for Firebase products that you want to use
        https://firebase.google.com/docs/web/setup#available-libraries -->
    <script src="https://www.gstatic.com/firebasejs/7.21.0/firebase-messaging.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.21.0/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.21.0/firebase-database.js"></script>

    <script src="{{mix('js/app.js')}}"></script>
    <script src="{{ mix('js/pad.js') }}" defer></script>
    @guest
        <script src="{{ mix('js/guest.js') }}" defer></script>
    @endguest

    @auth
        <script src="{{ mix('js/user.js') }}" defer></script>
    @endauth

</body>

</html>

