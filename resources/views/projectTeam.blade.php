@extends('layouts.app')

@section('content')


<div class="col-xs-12 insideContainer">
	@include('layouts.project_nav')
	@include('layouts.project_second_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body link-nav" style="padding-left: 0;">
			<div class="col-xs-12">
				<table class="table smallFontTable">
					<thead>
						<th class="text-left">Especialidade</th>
						<th class="text-left">Sub-Especialidade</th>
						<th class="text-center">Função</th>
						<th class="text-center">Colaborador</th>
						<th class="text-center">Departamento</th>
						<th class="text-left">Email</th>
						<th class="text-center">Ação</th>
						<th><button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
					</thead>
					<tbody class="text-left">
						<tr class="hidden hiddenForm">
							<form action="/project/team/addMember/{{$project->id}}" method="POST">
								<td>
									<select class="form-control input-sm expertiseSelect" name="expertise">
										@foreach($expertise as $expert)
											<option value="{{$expert->id}}">{{$expert->name}}</option>
										@endforeach
									</select>
								</td>
								<td>
									<select class="form-control input-sm subExpertiseSelect" name="subExpertise">
										<option value="0">Sem sub-especialidade</option>
										@foreach($subExpertise as $expert)
											<option class="hidden expert" content="{{$expert->parent}}" value="{{$expert->id}}">{{$expert->name}}</option>
										@endforeach
									</select>
								</td>
								<td>
									<select class="form-control input-sm functionSelect" name="function">
									@foreach($functions as $function)
										<option value="{{$function->id}}">{{$function->name}}</option>
									@endforeach
									</select>
								</td>
								<td>
									<select class="form-control input-sm teamUserSelect" name="user">
										@foreach($usersList as $user)
										@if($user->id == Auth::user()->id)
											<option selected value="{{$user->id}}">{{$user->sigla}}</option>
										@else
											<option value="{{$user->id}}">{{$user->sigla}}</option>
										@endif
										@endforeach
									</select>
								</td>
								<td class="departmentSpace text-center"></td>
								<td class="emailSpace"></td>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<td><button type="submit" class="btn btn-primary input-sm">Inserir</button></td>
							</form>
						</tr>
						@foreach($team as $member)
						<tr class="text-left memberEdit{{$member->id}} hidden">
							<td>
								<select class="form-control input-sm expertiseSelect" name="expertise">
									@foreach($expertise as $expert)
										@if($expert->id == $member->e_id)
										<option selected value="{{$expert->id}}">{{$expert->name}}</option>
										@else
										<option value="{{$expert->id}}">{{$expert->name}}</option>
										@endif
									@endforeach
								</select>
							</td>
							<td>
								<select class="form-control input-sm subExpertiseSelect" name="subExpertise">
									<option value="0">Sem sub-especialidade</option>
									@foreach($subExpertise as $expert)
										@if($expert->id == $member->subExpertise_id)
										<option selected class="hidden expert" content="{{$expert->parent}}" value="{{$expert->id}}">{{$expert->name}}</option>
										@else
										<option class="hidden expert" content="{{$expert->parent}}" value="{{$expert->id}}">{{$expert->name}}</option>
										@endif
									@endforeach
								</select>
							</td>
							<td>
								<select class="form-control input-sm functionSelect" name="function">
								@foreach($functions as $function)
									@if($function->id == $member->u_function_id)
									<option selected value="{{$function->id}}">{{$function->name}}</option>
									@else
									<option value="{{$function->id}}">{{$function->name}}</option>
									@endif
								@endforeach
								</select>
							</td>
							<td class="text-center">
								{{$member->u_sigla}}
							</td>
							<td class="text-center">
								{{$member->u_department}}
							</td>
							<td>
								{{$member->u_email}}
							</td>
							<td class="text-center" data-editable='false'>
								<button class="btn btn-xs btn-danger cancelEdit" content="{{$member->id}}"><i class="glyphicon glyphicon-edit"></i></button>
								<button content='{{$member->id}}' class="btn btn-success btn-xs saveMember" type="button"><i class="glyphicon glyphicon-check"></i></button>
							</td>
						</tr>
						<tr class="text-left member{{$member->id}}">
							<td>
								{{$member->e_name}}
							</td>
							<td>
								{{$member->subExpert_name}}
							</td>
							<td class="text-center">
								{{$member->u_function}}
							</td>
							<td class="text-center">
								{{$member->u_sigla}}
							</td>
							<td class="text-center">
								{{$member->u_department}}
							</td>
							<td>
								{{$member->u_email}}
							</td>
							<td data-editable='false' class="text-center">
								<button class="btn btn-xs btn-warning editMember" content="{{$member->id}}"><i class="glyphicon glyphicon-edit"></i></button>
								<button content='{{$member->id}}' class="btn btn-danger btn-xs removeMember" type="button"><i class="glyphicon glyphicon-minus"></i></button>
							</td>
						</tr>	
					</tbody>
					@endforeach
				</table>
			</div>
		</div>
	</div>
</div>

<script>
$('.editMember').click(function() {
	var id = $(this).attr('content');
	$('.memberEdit' + id).removeClass('hidden');
	$('.member' + id).addClass('hidden');
})

$('.cancelEdit').click(function() {
	var id = $(this).attr('content');
	$('.memberEdit' + id).addClass('hidden');
	$('.member' + id).removeClass('hidden');
})

$('.saveMember').click(function() {
	var id = $(this).attr('content');
	var function_id = $('.memberEdit' + id + ' .functionSelect').val();
	var expertise_id = $('.memberEdit' + id + ' .expertiseSelect').val();
	var subExpertise_id = $('.memberEdit' + id + ' .subExpertiseSelect').val();
	$.ajax({
		method: 'POST',
		url: '/project/team/editMember',
		data: {
			id: id,
			function_id: function_id,
			expertise_id: expertise_id,
			subExpertise_id: subExpertise_id
		},
		success: function() {
			location.reload();
		}
	})
})

$('.hiddenFormButton').click(function() {
	$('.hiddenForm').removeClass('hidden');
});

$('.removeMember').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().remove();
	$.get('/project/deleteTeamMember/' + id, function() {
	});
});

function showSubExpertise() {
	$('.subExpertiseSelect .expert').each(function() {
		$(this).addClass('hidden');
	});
	var expertise = $('.expertiseSelect').val();
	$('.subExpertiseSelect .expert').each(function() {
		if($(this).attr('content') == expertise)
			$(this).removeClass('hidden');
	});
}

showSubExpertise();

$('.expertiseSelect').change(showSubExpertise());

function getEmailAndDepartment() {
	var user_id = $('.teamUserSelect').val();
	$.get('/emailAndDepartmentFromUser/' + user_id, function(response) {
		$('.emailSpace').text(response.u_email);
		$('.departmentSpace').text(response.d_name);
	})
}

getEmailAndDepartment();

$('.teamUserSelect').change(function() {
	getEmailAndDepartment();
})
</script>

@endsection