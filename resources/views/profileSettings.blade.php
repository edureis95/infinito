@extends('layouts.app')

@section('content')

<div class="col-xs-12" style="max-width: 100%;">
	@include('layouts.settings_nav')
	@include('layouts.user_settings_2nd_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body" style="padding: 0;">
			<table class="table smallFontTable">
				<thead>
					<th> Perfis </th>
				</thead>
				@foreach($permissionProfiles as $profile)
				<tr>
					<td> 
						{{$profile->name}}
						<button content='{{$profile->id}}' style="padding: 3px 5px; margin-bottom: 5px;" class="btn btn-danger removeProfile" type="button"><i class="glyphicon glyphicon-minus"></i></button>
					</td>
				</tr>
				@endforeach
			</table>
			<form action="/settings/users/profiles/addProfile" method="POST">
				<div class="col-xs-6">
					<input type="text" required  class="form-control" name="profile" placeholder="Introduz o nome do perfil que queres adicionar">
				</div>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<button type="submit" class="btn btn-primary">Adicionar Perfil</button>
			</form>
		</div>
	</div>
</div>

<script>
$('.removeProfile').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().find('td').remove();
	$.get('/settings/users/profiles/removeProfile/' + id, function() {
	});
});	
</script>


@endsection