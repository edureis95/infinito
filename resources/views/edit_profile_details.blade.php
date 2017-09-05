@extends('layouts.app')


@section('content')

	@include('layouts.user_profile_nav')
	<div class="col-xs-12 insideContainer" style="padding-left: 0;">
		<div class="panel panel-info borderless">
			</div>
			<div class="panel-body">
				<form action="/profile/editDetails/{{$user->id}}" method="POST">
					<div class="row">
						<div class="col-xs-3">
							<div class="form-group row">
								<label class="col-md-4 col-form-label" style="text-align: right; padding-top: 5px;">NIF</label>
								<div class="col-md-8">
									<input class="form-control" value="{{$user_details != null ? $user_details->nif : ''}}" type="text" name="nif">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-4 col-form-label" style="text-align: right;">NISS</label>
								<div class="col-md-8">
									<input class="form-control" value="{{$user_details != null ? $user_details->niss : ''}}" type="text" name="niss">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-4 col-form-label" style="text-align: right;">IBAN</label>
								<div class="col-md-8">
									<input class="form-control" value="{{$user_details != null ? $user_details->iban : ''}}" type="text" name="iban">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-4 col-form-label" style="text-align: right;">Banco</label>
								<div class="col-md-8">
									<input class="form-control" value="{{$user_details != null ? $user_details->bank : ''}}" type="text" name="bank">
								</div>
							</div>
						</div>
						<div class="col-xs-9">
							<div class="form-group row">
								<label class="col-md-1 col-form-label" style="text-align: right; padding-top: 5px;">Morada</label>
								<div class="col-md-3">
									<textarea class="form-control" type="text" name="address">{{$user_details != null ? $user_details->address : ''}}</textarea>
								</div>
								<label class="col-md-2 col-form-label" style="text-align: right; padding-top: 5px;">Cód. Postal</label>
								<div class="col-md-2">
									<input class="form-control" value="{{$user_details != null ? $user_details->zip_code : ''}}" type="text" name="zip_code">
								</div>
								<label class="col-md-2 col-form-label" style="text-align: right; padding-top: 5px;">Localidade</label>
								<div class="col-md-2">
									<input class="form-control" value="{{$user_details != null ? $user_details->local : ''}}" type="text" name="local">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-1 col-form-label" style="text-align: right;">Seguro</label>
								<div class="col-md-3">
									<input class="form-control" value="{{$user_details != null ? $user_details->insurance : ''}}" type="text" name="insurance">
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="row">
						<div class="col-xs-2">
							<input type="submit" class="btn btn-sm btn-primary">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection