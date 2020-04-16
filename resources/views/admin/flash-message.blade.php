@if ($message = Session::get('success'))
<div class="alert alert-success alert-block" id="success-alert">
        <strong>Success! </strong>{{ $message }}
</div>
@endif


@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block" id="error-alert">
        <strong>Oops! </strong>{{ $message }} 
</div>
@endif


@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block" id="warning-alert">
	<strong>Warning! </strong> {{ $message }}
</div>
@endif


@if ($message = Session::get('info'))
<div class="alert alert-info alert-block" id="warning-alert">	
	<strong>Info! </strong>{{ $message }}
</div>
@endif


@if ($errors->any())
<div class="alert alert-danger">	
	Please check the form below for errors
</div>
@endif
