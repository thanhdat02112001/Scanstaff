<li class="{{Request::segment(2) == 'home' ? 'active-nav' : ''}}">
    <a href="/home" class="menu-link">
        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
        <span>Pads</span>
    </a>
</li>
<li class="{{Request::segment(2) == 'questions' ? 'active-nav' : ''}}">
    <a href="/interviewer/questions" class="menu-link">
        <i class="fa fa-question-circle-o" aria-hidden="true"></i>
        <span>Questions</span>
    </a>
</li>
<li class="{{Request::segment(2) == 'interviewees' ? 'active-nav' : ''}}">
    <a href="/interviewer/interviewees" class="menu-link">
        <i class="fa fa-users" aria-hidden="true"></i>
        <span>Interviewees</span>
    </a>
</li>
