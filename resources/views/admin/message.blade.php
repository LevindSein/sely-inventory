@if ($message = Session::get('pass'))
<div class="alert alert-success alert-block" id="pass-alert">
        <strong>Success! </strong>{{ $message }}
</div>
@endif