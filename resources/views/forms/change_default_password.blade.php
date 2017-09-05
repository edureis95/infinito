@extends('layouts.app')

@section('content')

<div class="col-md-10">
<div class="panel panel-default">
<div class="panel-heading">
	<b>Muda a tua password para teres acesso ao resto do site</b>
</div>
<div class="panel-body">
<form enctype="multipart/form-data" action="/postChangeDefaultPassword" method="POST">
	<div class="form-group row">
		<label class="col-md-4 col-form-label vcenter" style="text-align: right;">Password</label>
		<div class="col-md-6 vcenter">
			<input class="form-control" type="password" required value="" name="password">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label vcenter" style="text-align: right;">Confirma Password</label>
		<div class="col-md-6 vcenter">
			<input class="form-control" type="password" required value="" name="confirmPassword">
		</div>
	</div>

	<input type="hidden" name="_token" value="{{ csrf_token() }}">

	<div class="form-group row">
		<div class="col-md-offset-4 col-md-3">
			<button type="submit" class="btn btn-sm btn-primary">Submeter</button>
		</div>
	</div>
</form>
</div>
</div>
</div>

@endsection