@extends('layouts.app')


@section('content')

	@include('layouts.user_profile_nav')
	<div class="col-xs-12 insideContainer" style="padding-left: 0;">

		<div class="panel panel-default borderless">
			<div class="panel-body">
				<form enctype="multipart/form-data" action="/profile/{{ $user->id }}/edit " method="POST">
					<div class="row">
						<div class="col-xs-8">
							<div class="form-group row">
								<label class="col-md-4 col-form-label" style="text-align: right; padding-top: 5px;">Nome</label>
								<div class="col-md-8">
									<input class="form-control" type="text" value="{{ $user->name }}" name="name">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-4 col-form-label" style="text-align: right;">Sigla</label>
								<div class="col-md-8">
									<input class="form-control" type="text" value="{{ $user->sigla }}" name="sigla">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-4 col-form-label" style="text-align: right;">Telemóvel</label>
								<div class="col-md-8">
									<input class="form-control" type="text" value="{{ $user->cell_phone }}" name="cell_phone">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-4 col-form-label" style="text-align: right;">Telefone</label>
								<div class="col-md-8">
									<input class="form-control" type="text" value="{{ $user->desk_phone }}" name="desk_phone">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-4 col-form-label" style="text-align: right;">Skype</label>
								<div class="col-md-8">
									<input class="form-control" type="text" value="{{ $user->skype }}" name="skype">
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<img class="img img-thumbnail" style="margin-bottom: 4%; width: 82%;" src="/uploads/avatars/{{$user->avatar}}">
							<div class="form-group row">
								<div class="col-xs-10">
									<input id="input" name="avatar" type="file" class="file" data-show-upload="false" data-show-caption="true">
									<script>
										$("#input").fileinput({
											language: "pt",
											allowedFileExtensions: ["jpg", "png", "gif"]
										});
									</script>
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