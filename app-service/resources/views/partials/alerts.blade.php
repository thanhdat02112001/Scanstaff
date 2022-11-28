@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="btn btn-close" data-dismiss="alert" aria-label="close"></button>
        {{ session('success') }}
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <button type="button" class="btn btn-close" data-dismiss="alert" aria-label="close"></button>
        {{ session('warning') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="btn btn-close" data-dismiss="alert" aria-label="close"></button>
        {{ session('error') }}
    </div>
@endif
