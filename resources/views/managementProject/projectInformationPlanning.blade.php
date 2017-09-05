@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/datepicker-pt.js"></script>

<div class="col-xs-12" style="max-width: 98%;">
	@include('managementProject.project_nav')
	@include('managementProject.project_second_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body link-nav" style="padding: 0;">
			<div class="col-xs-12">
				<table class="table table-responsive smallFontTable">
					<thead>
						<th class="text-center">Tipo</th>
						<th class="text-center">Fase</th>
						<th class="text-center">Especialidade</th>
						<th class="text-center">Data</th>
						<th class="text-center">Ação</th>
						<th class="text-center"><button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
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
								<select class="form-control input-sm" name="phase">
									@foreach($phases as $phase)
										<option value="{{$phase->phase_id}}">{{$phase->name}}</option>
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
								<input type="text" name="startDate" class="form-control input-sm datepicker">
							</td>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<td><button type="submit" class="btn btn-primary input-sm">Inserir</button></td>
						</form>
					</tr>
					@foreach($project_planning as $planning)
					<tr>
						<td>
							<select class="form-control input-sm" name="type">
								@foreach($planningTypes as $type)
								@if($type->id == $planning->type)
									<option selected value="{{$type->id}}">{{$type->name}}</option>
								@else
									<option value="{{$type->id}}">{{$type->name}}</option>
								@endif
								@endforeach
							</select>
						</td>
						<td>
							<select class="form-control input-sm" name="phase">
								@foreach($phases as $phase)
								@if($phase->phase_id == $planning->phase)
									<option selected value="{{$phase->phase_id}}">{{$phase->name}}</option>
								@else
									<option value="{{$phase->phase_id}}">{{$phase->name}}</option>
								@endif
								@endforeach
							</select>
						</td>
						<td>
							<select class="form-control input-sm" name="expertise">
								@foreach($expertise as $expert)
								@if($expert->expertise_id == $planning->expertise)
									<option selected value="{{$expert->expertise_id}}">{{$expert->name}}</option>
								@else
									<option value="{{$expert->expertise_id}}">{{$expert->name}}</option>
								@endif
								@endforeach
							</select>
						</td>
						<td>{{$planning->startDate}}</td>						
						<td data-editable='false'><button content='{{$planning->id}}' style="padding: 3px 5px;" class="btn btn-danger removePlanning" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
					</tr>	
					@endforeach
				</table>
			</div>
		</div>
	</div>
</div>

<script>
$('.hiddenFormButton').click(function() {
	$('.hiddenForm').removeClass('hidden');
});

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