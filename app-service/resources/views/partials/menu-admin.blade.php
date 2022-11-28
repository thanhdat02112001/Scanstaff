<li class="{{Request::segment(2) == 'home' ? 'active-nav' : ''}}" >
    <a href="/home">
        <i class="fa fa-home" aria-hidden="true"></i>
        <span>Home</span>
    </a>
</li>
<li class="{{Request::segment(2) == 'interviewers' ? 'active-nav' : ''}}" >
    <a href="/admin/interviewers">
        <i class="fa fa-users" aria-hidden="true"></i>
        <span>Interviewers</span>
    </a>
</li>
<li class="{{Request::segment(2) == 'interviewees' ? 'active-nav' : ''}}" >
    <a href="/admin/interviewees" class="">
        <i class="fa fa-graduation-cap" aria-hidden="true"></i>
        <span>Interviewees</span>
    </a>
</li>
