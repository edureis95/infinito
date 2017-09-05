@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/datepicker-pt.js"></script>

<div class="col-xs-12 insideContainer">
	@include('layouts.project_nav')
	@include('layouts.project_second_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body link-nav">
			<button class="dropdown-toggle hiddenFormButton btn btn-primary" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px; margin-left: 93%;">
				<span style="font-size: 12px;">Adicionar</span>
			</button>
			<div class="formButtons hidden">
				<button class="dropdown-toggle cancelFunction btn btn-danger pull-right" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px; margin-right: 80px;">
					<span style="font-size: 12px;">Cancelar</span>
				</button>
				<button class="dropdown-toggle saveFunction btn btn-primary pull-right" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px;">
						<span style="font-size: 12px;">Guardar</span>
				</button>
			</div>
			<table class="table table-responsive smallFontTable">
				<thead>
					<th class="text-center">Tipo</th>
					<th class="text-center">Especialidade</th>
					<th class="text-center">Fase</th>
					<th class="text-center">Data</th>
					<th class="text-center">Ação</th>
				</thead>
				<tr class="hidden hiddenForm">
					<form action="/project/{{$project->id}}/planning/addPlanning" method="POST">
						<td>
							<select class="form-control input-sm" name="type">
								@foreach($planningTypes as $type)
									<option value="{{$type->id}}">{{$type->name}}</option>
								@endforeach
							</select>
						</td>
						<td>
							<select class="form-control input-sm" name="expertise">
								@foreach($expertise as $expert)
									<option value="{{$expert->expertise_id}}">{{$expert->name}}</option>
								@endforeach
							</select>
						</td>
						<td>
							<select class="form-control input-sm" name="phase">
								@foreach($phases as $phase)
									<option value="{{$phase->phase_id}}">{{$phase->name}}</option>
								@endforeach
							</select>
						</td>
						<td>
							<input type="text" name="startDate" class="form-control input-sm datepicker">
						</td>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<td><button type="submit" class="btn btn-primary input-sm submitButton hidden">Inserir</button></td>
					</form>
				</tr>
				@foreach($project_planning as $planning)
				<tr class="text-center">
					<td>
						{{$planning->pl_name}}
					</td>
					<td>
						{{$planning->e_name}}
					</td>
					<td>
						{{$planning->ph_name}}
					</td>
					<td>{{$planning->startDate}}</td>						
					<td data-editable='false'><button content='{{$planning->id}}' style="padding: 3px 5px;" class="btn btn-danger removePlanning" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
				</tr>	
				@endforeach
			</table>
		</div>
	</div>
</div>

<script>
$('.hiddenFormButton').click(function() {
	$(this).addClass('hidden');
	$('.formButtons').removeClass('hidden');
	$('.hiddenForm').removeClass('hidden');
});

$('.cancelFunction').click(function() {
	$('.formButtons').addClass('hidden');
	$('.hiddenFormButton').removeClass('hidden');
	$('.hiddenForm').addClass('hidden');
})

$('.saveFunction').click(function() {
	$('.submitButton').click();
})

$('.milestoneCheckbox').change(function() {
	console.log($(this).is(":checked"));
	if($(this).is(":checked") == true) {
		$('.endDate').addClass('hidden');
	} else {
		$('.endDate').removeClass('hidden');
	}
});

$('.removePlanning').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().remove();
	$.get('/project/deletePlanning/' + id, function() {
	});
});
</script>

@endsection