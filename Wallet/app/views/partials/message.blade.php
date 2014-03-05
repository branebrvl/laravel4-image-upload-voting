@if (Session::has('message'))
    <div>
        {{ Session::get('message') }}
    </div>
@endif
