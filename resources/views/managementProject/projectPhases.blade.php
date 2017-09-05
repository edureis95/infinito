@extends('layouts.app')

@section('content')


<div class="col-xs-11" style="max-width: 100%;">
	@include('managementProject.project_nav')
	@include('managementProject.project_second_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body link-nav" style="padding: 0;">
			<div class="col-xs-12">
				<table class="table table-responsive borderless" style="width: auto;">
					<thead>
						<th>Fase</th>
						<th>Ação</th>
						<th><button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
					</thead>
					<tr class="hidden hiddenForm">
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
					@foreach($projectPhase as $phase)
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
$('.hiddenFormButton').click(function() {
	$('.hiddenForm').removeClass('hidden');
});

$('.removePhase').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().remove();
	$.get('/project/deletePhase/' + id, function() {
	});
});
</script>

@endsection