@extends('layouts.app')

@section('content')

	<div class="col-lg-9" style="padding: 0%;">
		<div class="panel panel-default">

			<!-- Modal -->
			<div id="myModal" class="modal fade" role="dialog">
				<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Modal Header</h4>
						</div>
						<div class="modal-body">

							@include('forms.create_client')

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>

				</div>
			</div>

			<input type="hidden" id="user_val" value="{{$users}}" />
			<div class="panel-heading"><h2></h2></div> 
			<div class="panel-body">
				<form enctype="multipart/form-data" action="/projects/new" method="POST">
					<div class="form-group row">
						<label class="col-md-2 col-form-label vcenter" style="text-align: right;">Nome</label>
						<div class="col-md-4 vcenter">
							<input class="form-control" type="text" value="" name="name">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label vcenter" style="text-align: right;">Número</label>
						<div class="col-md-4 vcenter">
							<input class="form-control" type="text" value="" name="number">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label vcenter" style="text-align: right;">Descrição</label>
						<div class="col-md-4 vcenter">
							<textarea class="form-control" rows="5" value="" name="description"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 control-label vcenter" style="text-align: right;">Adicione foto</label>
						<div class="col-md-4 vcenter">
							<input id="input" name="picture" type="file" class="file" data-show-upload="false" data-show-caption="true">
							<script>
								$("#input").fileinput({
									language: "pt",
									allowedFileExtensions: ["jpg", "png", "gif"]
								});
							</script>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label vcenter" style="text-align: right;">Morada</label>
						<div class="col-md-4 vcenter">
							<input class="form-control" type="text" value="" name="address">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label vcenter" style="text-align: right;">Cidade</label>
						<div class="col-md-4 vcenter">
							<input class="form-control" type="text" value="" name="city">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label vcenter" style="text-align: right;">País</label>
						<div class="col-md-4 vcenter">
							<input class="form-control" type="text" value="" name="country">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-2 col-form-label vcenter" style="text-align: right;">Cliente</label>
						<div class="col-md-4 vcenter">
							<select class="form-control js-example-basic-single" type="text" name="client">
								<option value="0"> Não existe cliente </option>
								@foreach($clients as $client)
								<option value="{{$client->id}}"> {{ $client->name }} </option>
								@endforeach

							</select>
						</div>
						<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Adicionar Cliente</button>
					</div>

					<div class="form-group row">
						<label class="col-md-2 col-form-label vcenter" style="text-align: right;">Responsável</label>
						<div class="col-md-4 vcenter">
							<select class="form-control js-example-basic-single" type="text" name="responsible">
								<option> Não existe responsável </option>
								@foreach($companies as $company)
								<optgroup label="{{$company->name}}" id="r{{$company->id}}">
									
								</optgroup>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-2 col-form-label vcenter" style="text-align: right;">Membros</label>
						<div class="col-md-4 vcenter">
							<select multiple="true" class="form-control js-example-tags" type="text" name="members[]">
								<option> Não existe responsável </option>
								@foreach($companies as $company)
								<optgroup label="{{$company->name}}" id="m{{$company->id}}">
									
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
	$('#m{{$user->company}}').append("<option value='{{$user->id}}'> {{ $user->name }} </option>");
@endforeach

@foreach($companies as $company)
	var count = $('#r{{$company->id}}').children().length;
	if(count == 0) {
		$('#r{{$company->id}}').remove();
		$('#m{{$company->id}}').remove();
	}
@endforeach

</script>

@endsection