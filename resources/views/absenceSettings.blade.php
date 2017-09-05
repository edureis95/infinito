@extends('layouts.app')

@section('content')

<div class="col-xs-12 insideContainer">
	@include('layouts.settings_nav')
	@include('layouts.company_settings_2nd_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body">
			@if(count($absenceReasons))
			<table class="table smallFontTable">
				<thead>
					<th>Código</th>
					<th>Motivo de ausência </th>
					<th>Ação
					<th><button style="padding: 3px 5px;" class="btn btn-primary addReason" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
				</thead>
				<tr class="hiddenForm hidden">
					<form action="/settings/company/absence/addReason" method="POST">
						<td style="max-width: 100px;"><input type="number" class="form-control" name="code"></td>
						<td><input type="text" class="form-control" name="reason"></td>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<td><button type="submit" class="btn btn-primary">Inserir</button></td>
					</form>
				</tr>
				@foreach($absenceReasons as $reason)
				<tr>
					<td>{{$reason->code}}</td>
					<td>{{$reason->name}}</td>
					<td><button content='{{$reason->id}}' style="padding: 3px 5px; margin-bottom: 5px;" class="btn btn-danger removeReason" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
				</tr>
				@endforeach
			</table>
			@endif
		</div>
	</div>
</div>

<script>

$('.addReason').click(function() {
	$('.hiddenForm').removeClass('hidden');
});

$('.removeReason').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().find('td').remove();
	$.get('/settings/company/absence/removeReason/' + id, function() {
	});
});	
</script>


@endsection