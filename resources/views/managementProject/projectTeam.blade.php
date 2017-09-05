@extends('layouts.app')

@section('content')


<div class="col-xs-12" style="max-width: 100%;">
	@include('managementProject.project_nav')
	@include('managementProject.project_second_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body link-nav" style="padding: 0;">
			<div class="col-xs-12">
				<table class="table table-responsive borderless" style="width: auto;">
					<thead>
						<th>Especialidade</th>
						<th>Colaborador</th>
						<th>Ação</th>
						<th><button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
					</thead>
					<tr class="hidden hiddenForm">
						<form action="/project/team/addMember/{{$project->id}}" method="POST">
							<td>
								<select class="form-control input-sm" name="expertise">
									@foreach($expertise as $expert)
										<option value="{{$expert->id}}">{{$expert->name}}</option>
									@endforeach
								</select>
							</td>
							<td>
								<select class="form-control input-sm" name="user">
									@foreach($usersList as $user)
										<option value="{{$user->id}}">{{$user->sigla}}</option>
									@endforeach
								</select>
							</td>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<td><button type="submit" class="btn btn-primary input-sm">Inserir</button></td>
						</form>
					</tr>
					@foreach($team as $member)
					<tr>
						<td>
							{{$member->e_name}}
						</td>
						<td>
							{{$member->u_sigla}}
						</td>
						<td data-editable='false'><button content='{{$member->id}}' style="padding: 3px 5px;" class="btn btn-danger removeMember" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
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

$('.removeMember').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().remove();
	$.get('/project/deleteTeamMember/' + id, function() {
	});
});
</script>

@endsection