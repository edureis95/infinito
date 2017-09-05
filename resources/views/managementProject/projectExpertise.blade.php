@extends('layouts.app')

@section('content')


<div class="col-xs-12" style="max-width: 98%;">
	@include('managementProject.project_nav')
	@include('managementProject.project_second_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body link-nav" style="padding: 0;">
			<div class="col-xs-12">
				<table class="table phasesSelectTable" style="width: auto; min-width: 50%; float:left;">
					<thead>
						<th></th>
						@foreach($projectPhases as $phase)
							<th>{{$phase->p_sigla}}</th>
						@endforeach
					</thead>	
					<tbody>
						@foreach($projectExpertise as $expert)
						<tr>
							<td>{{$expert->e_sigla}} - {{$expert->e_name}}</td>
							@foreach($projectPhases as $phase)
							<td>
								@if($expert->phases->contains('phase_id', $phase->p_id))
								<input style="float: left;"  checked class="expertCheckbox" content="{{$expert->e_id}}" 2ndContent="{{$phase->p_id}}" type="checkbox">
								@else
								<input style="float: left;"  class="expertCheckbox" content="{{$expert->e_id}}" 2ndContent="{{$phase->p_id}}" type="checkbox">
								@endif
								<input class="form-control input-sm"  style="width: 60px;" type="number" max="100" min="0">
							</td>
							@endforeach
							@foreach($expert->subExpertise as $subExpert)
							<tr class="subExpertise{{$expert->p_e_id}}">
								<td><span style="padding-left: 10%;">{{$subExpert->e_sigla}} - {{$subExpert->e_name}}</span></td>
								@foreach($projectPhases as $phase)
								<td>
									@if($subExpert->phases->contains('phase_id', $phase->p_id))
									<input  checked class="expertCheckbox expertCheckbox{{$phase->p_id}}{{$subExpert->e_parent}}" 2ndContent="{{$phase->p_id}}" content="{{$subExpert->e_id}}" style="float: left;" type="checkbox">
									@else
									<input  class="expertCheckbox expertCheckbox{{$phase->p_id}}{{$subExpert->e_parent}}" 2ndContent="{{$phase->p_id}}" content="{{$subExpert->e_id}}" style="float: left;" type="checkbox">
									@endif
									<input  class="form-control input-sm" style="width: 60px;" type="number" max="100" min="0">
								</td>
								@endforeach
							</tr>
						@endforeach
						</tr>
						@endforeach
						<tr></tr>
						<tr><td style="border: none;"><button type="button" class="btn btn-success saveButton">Guardar</button></td></tr>
					</tbody>
				</table>
				<table class="table table-responsive borderless" style="width: 40%; float: right;">
					<thead>
						<th>Especialidade</th>
						<th>Ações</th>
						<th><button style="padding: 3px 5px;" class="btn btn-primary expertiseHiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
					</thead>
					<tr class="hidden expertiseHiddenForm">
						<form action="/project/expertise/addExpertise/{{$project->id}}" method="POST">
							<td>
								<select class="form-control input-sm" name="expertise">
									@foreach($expertise as $expert)
										<option value="{{$expert->id}}">{{$expert->sigla}} - {{$expert->name}}</option>
									@endforeach
								</select>
							</td>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<td><button type="submit" class="btn btn-primary input-sm">Inserir</button></td>
						</form>
					</tr>
					@foreach($projectExpertise as $expert)
					<tr>
						<td>{{$expert->e_sigla}} - {{$expert->e_name}}</td>
						<td data-editable='false'><button style="padding: 3px 5px;" content='{{$expert->p_e_id}}' class="btn btn-primary hiddenFormSubExpertButton" type="button"><i class="glyphicon glyphicon-plus"></i></button> 
						<button content='{{$expert->p_e_id}}' style="padding: 3px 5px;" class="btn btn-danger removeExpertise" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
						<tr class="subExpertiseForm{{$expert->p_e_id}} hidden">
							<form action="/project/expertise/addExpertise/{{$project->id}}" method="POST">
								<td style="padding-left: 40px;">
									<select class="form-control input-sm" name="expertise">
										@foreach($subExpertise as $subExpert)
										@if($subExpert->parent == $expert->e_id)
											<option value="{{$subExpert->id}}">{{$subExpert->sigla}} - {{$subExpert->name}}</option>
										@endif
										@endforeach
									</select>
								</td>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<td><button type="submit" class="btn btn-primary input-sm">Inserir</button></td>
							</form>
						</tr>
						@foreach($expert->subExpertise as $subExpert)
						<tr class="subExpertise{{$expert->p_e_id}}">
								<td style="padding-left: 40px;">{{$subExpert->e_sigla}} - {{$subExpert->e_name}}</td>
								<td><button content='{{$subExpert->p_e_id}}' style="padding: 3px 5px;" class="btn btn-danger removeExpertise" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
						</tr>
						@endforeach
					</tr>
					@endforeach
				</table>
				<table class="table table-responsive borderless" style="width: 40%; float: right;">
					<thead>
						<th>Fase</th>
						<th>Ação</th>
						<th><button style="padding: 3px 5px;" class="btn btn-primary phasesHiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
					</thead>
					<tr class="hidden phasesHiddenForm">
						<form action="/project/phases/addPhase/{{$project->id}}" method="POST">
							<td>
								<select class="form-control input-sm" name="phase">
									@foreach($phases as $phase)
										<option value="{{$phase->id}}">{{$phase->sigla}} - {{$phase->name}}</option>
									@endforeach
								</select>
							</td>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<td><button type="submit" class="btn btn-primary input-sm">Inserir</button></td>
						</form>
					</tr>
					@foreach($projectPhases as $phase)
					<tr>
						<td>{{$phase->p_sigla}} - {{$phase->p_name}}</td>
						<td data-editable='false'><button content='{{$phase->proj_p_id}}' style="padding: 3px 5px;" class="btn btn-danger removePhase" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
</div>

<script>
$('.expertiseHiddenFormButton').click(function() {
	$('.expertiseHiddenForm').removeClass('hidden');
});

$('.phasesHiddenFormButton').click(function() {
	$('.phasesHiddenForm').removeClass('hidden');
});

$('.hiddenFormSubExpertButton').click(function() {
	var id = $(this).attr('content');
	$('.subExpertiseForm' + id).removeClass('hidden');
})

$('.removeExpertise').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().remove();
	$('.subExpertiseForm' + id).remove();
	$('.subExpertise' + id).remove();
	$.get('/project/deleteExpertise/' + id, function() {
	});
});

$('.removePhase').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().remove();
	$.get('/project/deletePhase/' + id, function() {
	});
});

$('.expertCheckbox').change(function() {
	if($(this).is(":checked")) {
		var content = $(this).attr('content');
		var secondContent = $(this).attr('2ndContent');
		$('.expertCheckbox' + secondContent + content).prop('checked', true);
	}
});

$('.saveButton').click(function() {
	var obj = {};
	$('.phasesSelectTable .expertCheckbox').each(function() {
		if($(this).is(':checked')) {
			if(obj[$(this).attr('content')] == null)
				obj[$(this).attr('content')] = new Array();
			obj[$(this).attr('content')].push($(this).attr('2ndContent'));
		} else {
			if(obj[$(this).attr('content')] == null)
				obj[$(this).attr('content')] = new Array();
			obj[$(this).attr('content')].push('-' + $(this).attr('2ndContent'));
		}
	});

	$.ajax({
	  type: "POST",
	  url: '/project/expertise/editExpertisePhases',
	  data: {
	  	'obj': obj,
	  	'project_id': {{$project->id}}
	  },
	  success: function() {
	  }
	});
});
</script>

@endsection