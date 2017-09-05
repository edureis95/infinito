@extends('layouts.app')

@section('content')

<div class="col-xs-12" style="max-width: 100%;">
	@include('layouts.settings_nav')
	@include('layouts.user_settings_2nd_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body" style="padding: 0;">
			<table class="table borderless permissionTable text-center">
				<thead>
					<th class="text-center"> Permissões </th>
					@foreach($permissionProfiles as $profile)
					<th class="text-center"> {{$profile->name}} </th>
					@endforeach
				</thead>
				<tr>
					<td> Calendário </td>
					@foreach($permissionProfiles as $profile)
					@if($profile->calendar == 1)
						<td><input id="calendar{{$profile->id}}" checked type="checkbox"></td>
					@else
						<td><input id="calendar{{$profile->id}}" type="checkbox"></td>
					@endif
					@endforeach
					
				</tr>
				<tr>
					<td> Contactos </td>
					@foreach($permissionProfiles as $profile)
					@if($profile->contacts == 1)
						<td><input id="contacts{{$profile->id}}" checked type="checkbox"></td>
					@else
						<td><input id="contacts{{$profile->id}}" type="checkbox"></td>
					@endif
					@endforeach
				</tr>
				<tr>
					<td> Email </td>
					@foreach($permissionProfiles as $profile)
					@if($profile->email == 1)
						<td><input id="email{{$profile->id}}" checked type="checkbox"></td>
					@else
						<td><input id="email{{$profile->id}}" type="checkbox"></td>
					@endif
					@endforeach
				</tr>
				<tr>
					<td> Área Pessoal </td>
					@foreach($permissionProfiles as $profile)
					@if($profile->personalArea == 1)
						<td><input id="personalArea{{$profile->id}}" checked type="checkbox"></td>
					@else
						<td><input id="personalArea{{$profile->id}}" type="checkbox"></td>
					@endif
					@endforeach
				</tr>
				<tr>
					<td> Empresa </td>
					@foreach($permissionProfiles as $profile)
					@if($profile->company == 1)
						<td><input id="company{{$profile->id}}" checked type="checkbox"></td>
					@else
						<td><input id="company{{$profile->id}}" type="checkbox"></td>
					@endif
					@endforeach
				</tr>
				<tr>
					<td> Projetos </td>
					@foreach($permissionProfiles as $profile)
					@if($profile->projects == 1)
						<td><input id="projects{{$profile->id}}" checked type="checkbox"></td>
					@else
						<td><input id="projects{{$profile->id}}" type="checkbox"></td>
					@endif
					@endforeach
				</tr>
				<tr>
					<td> Definições </td>
					@foreach($permissionProfiles as $profile)
					@if($profile->settings == 1)
						<td><input id="settings{{$profile->id}}" checked type="checkbox"></td>
					@else
						<td><input id="settings{{$profile->id}}" type="checkbox"></td>
					@endif
					@endforeach
				</tr>
				<tr>
					<td> Gestão </td>
					@foreach($permissionProfiles as $profile)
					@if($profile->management == 1)
						<td><input id="management{{$profile->id}}" checked type="checkbox"></td>
					@else
						<td><input id="management{{$profile->id}}" type="checkbox"></td>
					@endif
					@endforeach
				</tr>
				<tr>
					<td> Finanças </td>
					@foreach($permissionProfiles as $profile)
					@if($profile->finances == 1)
						<td><input id="finances{{$profile->id}}" checked type="checkbox"></td>
					@else
						<td><input id="finances{{$profile->id}}" type="checkbox"></td>
					@endif
					@endforeach
				</tr>
			</table>
			<button type="button" class="btn btn-success" id="savePermissions">Guardar</button>
			<span class="savedBox hidden" style="color: green;"><i class="glyphicon glyphicon-check"></i> As permissões foram guardadas</span>
		</div>
	</div>
</div>

<script>

$('.permissionTable input').change(function() {
	$('.savedBox').addClass('hidden');
});

$('#savePermissions').click(function() {
	var obj = {};
	$('.permissionTable input').each(function() {
		obj[$(this).attr('id')] = $(this).is(":checked");
	});

	$.ajax({
	  type: "POST",
	  url: '/settings/users/permissions/savePermissions',
	  data: obj,
	  success: function() {
	  	$('.savedBox').removeClass('hidden');
	  }
	});
});
</script>


@endsection