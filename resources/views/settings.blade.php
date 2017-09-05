@extends('layouts.app')

@section('content')


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
            Tens a certeza que queres eliminar este user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-danger btn-ok">Apagar</a>
            </div>
        </div>
    </div>
</div>

<div class="col-xs-12" style="max-width: 100%;">
	@include('layouts.settings_nav')
	@include('layouts.user_settings_2nd_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body" style="padding:0;">
		<table class="table smallFontTable">
		<tbody>
		@foreach($users as $user)
		<tr>
			<td><a href="/profile/{{$user->id}}">{{$user->name}}</a></td>
			<td>{{$user->email}}</td>
			<td> <button type="button" style="padding: 0; padding-right: 2%; padding-left: 2%;" class="btn btn-sm btn-primary resetPassword"> Reset Password </button></td>
			<td class="hidden changePasswordForm">
				
				<form enctype="multipart/form-data" action="/resetPassword" method="POST">
					<div class="form-group row">
						<label class="col-md-4 col-form-label vcenter" style="text-align: right;">Password</label>
						<div class="col-md-6 vcenter">
							<input class="form-control" type="password" required value="" name="password">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 col-form-label vcenter" style="text-align: right;">Confirma Password</label>
						<div class="col-md-6 vcenter">
							<input class="form-control" type="password" required value="" name="confirmPassword">
						</div>
					</div>

					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="userID" value="{{$user->id}}">

					<div class="form-group row">
						<div class="col-md-offset-4 col-md-3">
							<button type="submit" class="btn btn-sm btn-primary">Submeter</button>
						</div>
					</div>
				</form>
			</td>
			<td> 
				<select class="selectType form-control input-sm" id="{{$user->id}}" type="text" name="typeUser">
					<option value="0">Sem perfil</option>
					@foreach($permissions as $permission)
					@if($permission->id == $user->profile)
						<option selected value='{{$permission->id}}'> {{$permission->name}} </option>
					@else
						<option value='{{$permission->id}}'> {{$permission->name}} </option>
					@endif
					@endforeach
				</select>
			</td>
			<td>
			<a href="/deleteUser/{{$user->id}}"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
			</td>
		</tr>
		<tr>

		</tr>
		@endforeach
		</tbody>
		</table>

		<form action="/addCollaborator" method="POST">
			<div class="col-xs-6">
				<input type="email" required  class="form-control" name="email" aria-describedby="emailHelp" placeholder="Introduz o email que queres registar...">
			</div>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<button type="submit" class="btn btn-primary">Registar Colaborador</button>
		</form>
		</div>
	</div>
</div>


<script>
$('.resetPassword').click(function() {
	$(this).parent().parent().find('.changePasswordForm').removeClass('hidden');
});

function currentSelected() {

}

$('.selectType').change(function() {
	var id = $(this).attr('id');
	var select = $(this).find(':selected').val();
	$.ajax({
	  type: "POST",
	  url: '/settings/users/changeUserPermission',
	  data: {
	  	'user_id' : id,
	  	'permission' : select
	  },
	  success: function() {
	  }
	});
});

</script>

@endsection