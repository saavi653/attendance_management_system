@if($msg=Session::get('success') )
    <h3>{{ $msg }}</h3>
    @elseif($msg=Session::get('error'))
        <h3>{{ $msg }}</h3>
@endif
