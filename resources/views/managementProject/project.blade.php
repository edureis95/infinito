@extends('layouts.app')

@section('content')


<div class="col-xs-12" style="max-width: 98%;">
	@include('managementProject.project_nav')
	@include('managementProject.project_second_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body link-nav" style="padding: 0;">
			<div class="col-xs-12">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h5>Descrição <button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-success editDescriptionButton pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button><button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-danger cancelEditDescription hidden pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button></h5>
					</div>
					<div class="panel-body">
						<table class="table borderless descriptionTable" style="width: auto;">
							<tr> 
								<td><b>Código:</b> {{str_pad($project->number, 5, '0', STR_PAD_LEFT)}}<b style="padding-left: 10px;">Nome:</b> {{$project->name}}</td>
							</tr>
							<tr>
								@if($project->title == "")
									<td><b>Designação do Projeto: </b>Sem designação</td>
								@else
									<td><b>Designação do Projeto:</b> {{$project->title}}</td>
								@endif
							</tr>
							<tr>
								<td><b>Localização do Projeto: </b>{{$project->address == "" ? "Sem localização": $project->address}}<b style="padding-left: 10px;">Código Postal: </b> {{$project->zip_code == "" ? "XXXX-XXX": $project->zip_code}} <b style="padding-left: 10px;">Localidade: </b>{{$project->local == "" ? "Sem localidade": $project->local}}</td>
							</tr>
						</table>
						<div class="editableDescription hidden">
							<table class="table borderless editTableDescription" style="width: auto;">
								<tr> 
									<td data-editable='false'><b>Código:</b></td> 
									<td class="code">{{str_pad($project->number, 5, '0', STR_PAD_LEFT)}}</td>
									<td data-editable='false'><b style="padding-left: 10px;"> Nome:</b></td>
									<td class="name">{{$project->name}}</td>
								</tr>
								<tr>
									<td data-editable='false'><b>Designação do Projeto:</b></td>
									<td class="title">{{$project->title == "" ? "Sem designação": $project->title}}</td>
								</tr>
								<tr>
									<td data-editable='false'><b>Localização do Projeto: </b></td>
									<td class="address">{{$project->address == "" ? "Sem localização": $project->address}}</td>
									<td data-editable='false'><b style="padding-left: 10px;">Código Postal: </b></td>
									<td class="zip_code">{{$project->zip_code == "" ? "XXXX-XXX": $project->zip_code}}</td>
									<td data-editable='false'><b style="padding-left: 10px;">Localidade: </b></td>
									<td class="local">{{$project->local == "" ? "Sem localidade": $project->local}}</td>
								</tr>
							</table>
							<button type="button" class="btn btn-success saveDescription pull-right">Guardar</button>
						</div>
					</div>
				</div>
				<div class="panel panel-info">
					<div class="panel-heading">
						<h5>Caracterização <button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-success editButton pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button><button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-danger cancelEditButton hidden pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button></h5>
					</div>
					<div class="panel-body">
						<table class="table borderless caracterizationTable" style="width: auto;">
							<tr>
								<td><b>Tipo de Projeto:</b> {{$project->typeName}}</td>
							</tr>
							@if($project->projectDetails != null)
							<tr>
								<td><b>Tipo de Construção:</b> {{$project->projectDetails->constructionTypeName}}<b style="padding-left: 10px;">Tipo de Utilização:</b> {{$project->projectDetails->utilizationTypeName}}</td>
							</tr>
							<tr>
								<td><b>Nº Total de Pisos:</b> {{$project->projectDetails->totalNumberFloors}}<b style="padding-left: 10px;">Nº de Pisos Enterrados:</b> {{$project->projectDetails->numberBuriedFloors}}</td>
							</tr>
							@endif
							<tr>
								<td><b>Área de Construção:</b> {{$project->constructionArea}} m<sup>2</sup></td>
							</tr>
							<tr>
								<td><b>Área Total de Projeto:</b> {{$project->totalArea}} m<sup>2</sup></td>
							</tr>
							<tr>
								<td><b>Estimado da contrução:</b> {{$project->value}} €</td>
							</tr>
						</table>

						<div class="editTable hidden">
							<table class="table borderless editTable " style="width: auto;">
								<tr>
									<td data-editable='false' style="padding-top: 10px;"><b>Tipo de Projeto: </b></td>
									<td data-editable='false'>
										<select class="form-control input-sm projectTypeSelect">
											<option value="0">Sem tipo</option>
											@foreach($projectTypes as $type)
												@if($project->type == $type->id)
													<option selected value="{{$type->id}}">{{$type->name}}</option>
												@else
													<option value="{{$type->id}}">{{$type->name}}</option>
												@endif
											@endforeach
										</select>
									</td>
								</tr>
								<tr>
									<td data-editable='false' style="padding-top: 10px;"><b>Tipo de Construção: </b></td>
									<td data-editable='false'>
										<select class="form-control input-sm constructionTypeSelect">
											<option value="0">Sem tipo</option>
											@foreach($constructionTypes as $type)
												@if($project->projectDetails != null and $project->projectDetails->constructionType == $type->id)
													<option selected value="{{$type->id}}">{{$type->name}}</option>
												@else
													<option value="{{$type->id}}">{{$type->name}}</option>
												@endif
											@endforeach
										</select>
									</td>

									<td data-editable='false' style="padding-top: 10px;"><b>Tipo de Utilização: </b></td>
									<td data-editable='false'>
										<select class="form-control input-sm utilizationTypeSelect">
											<option value="0">Sem tipo</option>
											@foreach($utilizationTypes as $type)
												@if($project->projectDetails != null and $project->projectDetails->utilizationType == $type->id)
													<option selected value="{{$type->id}}">{{$type->name}}</option>
												@else
													<option value="{{$type->id}}">{{$type->name}}</option>
												@endif
											@endforeach
										</select>
									</td>
								</tr>
								<tr>
								@if($project->projectDetails != null)
									<td data-editable='false'><b>Nº Total de Pisos:</b> <td class="totalNumberFloors">{{$project->projectDetails->totalNumberFloors}}</td>
									<td data-editable='false'><b>Nº de Pisos Enterrados:</b> <td class="numberBuriedFloors">{{$project->projectDetails->numberBuriedFloors}}</td></td>
								@else
									<td data-editable='false'><b>Nº Total de Pisos:</b> <td class="totalNumberFloors">0</td>
									<td data-editable='false'><b>Nº de Pisos Enterrados:</b class="numberBuriedFloors"> <td>0</td></td>
								@endif
								</tr>
								<tr>
									<td data-editable='false'><b>Área de Construção (m<sup>2</sup>):</b> <td class="constructionArea">{{$project->constructionArea}}</td></td>
								</tr>
								<tr>
									<td data-editable='false'><b>Área Total de Projeto (m<sup>2</sup>):</b> <td class="totalArea">{{$project->totalArea}}</td></td>
								</tr>
								<tr>
									<td data-editable='false'><b>Estimado da contrução (€):</b> <td class="value">{{$project->value}}</td></td>
								</tr>
							</table>
							<button type="button" class="btn btn-success saveButton pull-right">Guardar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$('.editButton').click(function() {
	$(this).addClass('hidden');
	$('.cancelEditButton').removeClass('hidden');
	$('.editTable').removeClass('hidden');
	$('.caracterizationTable').addClass('hidden');
});

$('.cancelEditButton').click(function() {
	$(this).addClass('hidden');
	$('.editButton').removeClass('hidden');
	$('.editTable').addClass('hidden');
	$('.caracterizationTable').removeClass('hidden');
});

$('.editDescriptionButton').click(function() {
	$(this).addClass('hidden');
	$('.cancelEditDescription').removeClass('hidden');
	$('.editableDescription').removeClass('hidden');
	$('.descriptionTable').addClass('hidden');
});

$('.cancelEditDescription').click(function() {
	$(this).addClass('hidden');
	$('.editDescriptionButton').removeClass('hidden');
	$('.editableDescription').addClass('hidden');
	$('.descriptionTable').removeClass('hidden');
});

$('.editTable').editableTableWidget();

$('.editTableDescription').editableTableWidget();

$('.saveButton').click(function() {
	var id = {{$project->id}};
	var projectType = $('.projectTypeSelect').val();
	var constructionType = $('.constructionTypeSelect').val();
	var utilizationType = $('.utilizationTypeSelect').val();
	var totalNumberFloors = $('.totalNumberFloors').text();
	var numberBuriedFloors = $('.numberBuriedFloors').text();
	var constructionArea = $('.constructionArea').text();
	var totalArea = $('.totalArea').text();
	var value = $('.value').text();

	$.ajax({
		type: 'POST',
		url: '/project/editCaracterization',
		data: {
			'id': id,
			'projectType': projectType,
			'constructionType': constructionType,
			'utilizationType': utilizationType,
			'totalNumberFloors': totalNumberFloors,
			'numberBuriedFloors': numberBuriedFloors,
			'constructionArea': constructionArea,
			'totalArea': totalArea,
			'value': value
		},
		success: function() {
			location.reload();
		},
		error: function() {
			location.reload();
		}
	});
});

$('.saveDescription').click(function() {
	var id = {{$project->id}};
	var code = $('.code').text();
	var name = $('.name').text();
	var address = $('.address').text();
	var title = $('.title').text();
	var zip_code = $('.zip_code').text();
	var local = $('.local').text();

	$.ajax({
		type: 'POST',
		url: '/project/editDescription',
		data: {
			'id': id,
			'code': code,
			'name': name,
			'address': address,
			'title': title,
			'zip_code': zip_code,
			'local': local
		},
		success: function() {
			location.reload();
		},
		error: function() {
			location.reload();
		}
	});

});
</script>

@endsection