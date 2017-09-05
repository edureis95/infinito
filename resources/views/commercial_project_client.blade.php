@extends('layouts.app')

@section('content')
<style>
.editClientTable tr {
	vertical-align: middle !important;
}
.editClientTable td {
	vertical-align: middle !important;
}
</style>
<div class="col-xs-12 insideContainer">
	@include('layouts.commercial_project_nav')
	@include('layouts.commercial_project_secondNav')
	<div class="panel panel-default">
		<div class="panel-heading smallPanelHeading">
			<h5>Detalhes <button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-success editClient pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button><button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-danger cancelEditClient hidden pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button></h5>
		</div>
		<div class="panel-body">
			<table class="table borderless clientTable" style="width: auto;">
				@if($client != null)
				<tr>
					<td><b>Nome do cliente:</b></td>
					<td>{{$client->contact->firstName}} {{$client->contact->lastName}}</td>
				</tr>
				<tr>
					<td><b>Morada:</b></td>
					<td>{{$client->contact->address != null ? $client->contact->address : '-'}}</td>

					<td><b>Cód-Postal:</b></td>
					<td>{{$client->contact->zip_code != null ? $client->contact->zip_code : '-'}}</td>
				</tr>
				<tr>
					<td><b>Localidade:</b></td>
					<td>{{$client->contact->city != null ? $client->contact->city : '-'}}</td>

					<td><b>País:</b></td>
					<td>{{$client->contact->country != null ? $client->contact->country : '-'}}</td>
				</tr>
				<tr>
					<td><b>Pessoa responsável:</b></td>
					<td>{{$client->r_name}}</td>
				</tr>
				@else
				<tr>
					<td>Nome do cliente:</td>
					<td>Sem cliente</td>
				</tr>
				@endif
			</table>

			<table class="table borderless editClientTable hidden" style="width: auto;">
				<tr>
					<td>Nome do cliente:</td>
					<td>
						<select class="form-control input-sm clientSelect">
						@foreach($contacts as $contact)
						<option value="{{$contact->id}}">{{$contact->firstName}} {{$contact->lastName}}</option>
						@endforeach
						</select>
					</td>
				</tr>
				<tr>
					<td>Pessoa Responsável:</td>
					<td>
						<select class="form-control input-sm responsibleSelect">
						@foreach($usersList as $user)
						<option value="{{$user->id}}">{{$user->name}}</option>
						@endforeach
						</select>
					</td>
				</tr>
				<tr></tr>
				<tr>
					<td><button type="button" class="saveClient btn btn-success btn-xs">Guardar</button></td>
				</tr>
			</table>
		</div>
	</div>
</div>

<script>
$('.saveClient').click(function() {
	$.ajax({
		method: 'POST',
		url: '/commercialProject/client/savePersonalClient',
		data: {
			'project_id': '{{$project->id}}',
			'client_id': $('.clientSelect').val(),
			'responsible_id': $('.responsibleSelect').val()
		},
		success: function() {
			location.reload();
		}
	})
})

$('.editClient').click(function() {
	$(this).addClass('hidden');
	$('.editClientTable').removeClass('hidden');
	$('.clientTable').addClass('hidden');
	$('.cancelEditClient').removeClass('hidden');

})
$('.cancelEditClient').click(function() {
	$(this).addClass('hidden');
	$('.editClientTable').addClass('hidden');
	$('.clientTable').removeClass('hidden');
	$('.editClient').removeClass('hidden');
})
</script>

@endsection