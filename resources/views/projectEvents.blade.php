@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/datepicker-pt.js"></script>

<div class="col-xs-12" style="max-width: 100%;">
	@include('layouts.project_nav')
	@include('layouts.project_management_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body" style="padding-left: 0;">
			<table class="table">
				<thead>
					<th class="text-center">Data</th>
					<th class="text-center">Colaborador</th>
					<th class="text-center">Tipo</th>
					<th class="text-center">Sub-Tipo</th>
					<th class="text-center">Observações</th>
					<th class="text-center"><button style="padding: 3px 5px;" class="btn btn-primary addType" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
				</thead>
				<tbody class="text-center">
					<tr class="hiddenForm hidden">
						<form action="/project/events/addEvent/{{$project->id}}" method="POST">
							<td>
								<input class="form-control datepicker" required name="date">
							</td>
							<td>
								<select class="form-control" name="user">
								@foreach($usersList as $user)
								@if($user->id == Auth::user()->id)
									<option selected value="{{$user->id}}">{{$user->sigla}}</option>
								@else
									<option value="{{$user->id}}">{{$user->sigla}}</option>
								@endif
								@endforeach
								</select>
							</td>
							<td>
								<select class="form-control typeSelect" name="type">
								@foreach($eventTypes as $type)
									<option value="{{$type->id}}">{{$type->name}}</option>
								@endforeach
								</select>
							</td>
							<td>
								<select class="form-control subTypeSelect" name="subType">
									<option value="0">Sem sub-tipo</option>
									@foreach($states as $state)
										<option class="hidden subTypeOption" value="{{$state->id}}">{{$state->name}}</option>
									@endforeach
									</div>
								</select>
							</td>
							<td>
								<input type="text" class="form-control" name="observations">
							</td>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<td><button type="submit" class="btn btn-primary">Inserir</button></td>
						</form>
					</tr>
					@foreach($events as $event)
					<tr>
						<td>{{$event->date}}</td>
						<td>{{$event->u_sigla}}</td>
						<td>{{$event->t_name}}</td>
						<td>{{$event->s_name}}</td>
						<td>{{$event->observations}}</td>
						<td><button content='{{$event->id}}' style="padding: 3px 5px; margin-bottom: 5px;" class="btn btn-danger removeEvent" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>

$( function() {
	$( ".datepicker" ).datepicker();
    $( ".datepicker" ).datepicker("option", "dateFormat",'yy-mm-dd');
});

function showStates() {
	$('.subTypeSelect .subTypeOption').each(function() {
		$(this).addClass('hidden');
	});
	var id = $('.typeSelect').val();
	var type = $('.typeSelect option[value="' + id + '"]').text();
	if(type.toUpperCase() == 'ESTADO') {
		$('.subTypeSelect .subTypeOption').each(function() {
			$(this).removeClass('hidden');
		});
	}
}

showStates();

$('.typeSelect').change(function() {
	showStates();
});

$('.addType').click(function() {
	$('.hiddenForm').removeClass('hidden');
});

$('.removeEvent').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().find('td').remove();
	$.get('/project/events/removeEvent/' + id, function(response) {
	});
});	
</script>


@endsection