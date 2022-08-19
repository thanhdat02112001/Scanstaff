<div class="go-to-user mt-3">
    <select class="form-control form-control-sm" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="{{ route('home') }}" {{Request::segment(1) == 'admin' ? 'selected' : ''}}>Admin</option>
        <option value="#" {{Request::segment(1) == 'interviewer' ? 'selected' : ''}}> Interviewer</option>
    </select>
</div>

{{-- <div class="dropdown">
    <a class="dropdown-toggle count-info" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-bell"></i>
        <span class="label label-primary">{{ $count_noti }}</span>
    </a>
    <div class="dropdown-menu dropdown-noti">
        <div class="mark-read">
            <a href="#">Mark all as read</a>
        </div>
        <div class="noti-list" data-all="{{ $all_noti_count }}" data-cur="{{ ($all_noti_count > 3) ? 3 : $all_noti_count }}">
            @foreach ($new_noti as $noti)
                <div class="{{ $noti->read === 0 ? 'unseen' : '' }}">
                    <a href="{{ route('noti.seen', $noti->id) }}">{{ $noti->description }}</a>
                </div>
            @endforeach
        </div>
        @if ($all_noti_count > 3)
            <a href="#" class="see-more">See more</a>
        @endif
    </div>
</div> --}}
