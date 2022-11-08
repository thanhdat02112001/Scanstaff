<div class="dropdown">
    <button class="btn header-item noti-icon" data-toggle="dropdown">
        <i class="fa fa-bell-o"></i>
        <span class="badge bg-danger rounded-pill">{{$count_noti}}</span>
    </button>
    <div class="dropdown-menu dropdown-noti">
        <div class="mark-read">
            <a href="#">Mark all as read</a>
        </div>
        <div class="noti-list" data-all="{{ $all_noti_count }}" data-cur="{{ ($all_noti_count > 3) ? 3 : $all_noti_count }}">
            @foreach ($new_noti as $noti)
                <div class="{{ $noti->read === 0 ? 'unseen' : '' }}">
                    {{-- <a href="{{ route('noti.seen', $noti->id) }}">{{ $noti->description }}</a> --}}
                    <a href="#">{{ $noti->description }}</a>
                </div>
            @endforeach
        </div>
        @if ($all_noti_count > 3)
            <a href="#" class="see-more">See more</a>
        @endif
    </div>
</div>
<form action="" class="ms-3">
    <select name="" id="" class="form-select-sm form-select">
        <option value="">Admin</option>
        <option value="">Interviewer</option>
    </select>
</form>
