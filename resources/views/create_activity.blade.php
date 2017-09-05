@extends('layouts.app')

@section('content')

	<div class="col-lg-9" style="padding: 0%;">
		<div class="panel panel-default">
			<input type="hidden" id="user_val" value="{{$users}}" />
			<div class="panel-heading"><h2>Cria atividade</h2></div> 
			<div class="panel-body">
				<form enctype="multipart/form-data" action="/activity/new" method="POST">
					<div class="form-group row">
						<label class="col-md-2 col-form-label" style="text-align: right; padding-top: 5px;">Nome</label>
						<div class="col-md-4">
							<input class="form-control" type="text" value="" name="name">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label" style="text-align: right;">Descrição</label>
						<div class="col-md-4">
							<textarea class="form-control" rows="5" value="" name="description"></textarea>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-2 col-form-label" style="text-align: right;">Projeto</label>
						<div class="col-md-4">
							<select class="form-control js-example-basic-single" type="text" name="parent_project">
								@foreach($projects as $project)
								<option value='{{$project->project_Task_ID}}'> {{$project->name}} </option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-2 col-form-label" style="text-align: right;">Responsável</label>
						<div class="col-md-4">
							<select class="form-control js-example-basic-single" type="text" name="responsible">
								<option> Não existe responsável </option>
								@foreach($companies as $company)
								<optgroup label="{{$company->name}}" id="r{{$company->id}}">
									
								</optgroup>
								@endforeach
							</select>
						</div>
					</div>

					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div class="form-group row">
						<div class="col-md-offset-3 col-md-3">
							<input type="submit" class="btn btn-sm btn-primary">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<script>
@foreach($users as $user)
	$('#r{{$user->company}}').append("<option value = '{{$user->id}}''> {{ $user->name }} </option>");
@endforeach
</script>
@endsection