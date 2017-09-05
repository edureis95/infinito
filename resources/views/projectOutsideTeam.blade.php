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
						<th class="text-left">Empresa</th>
						<th class="text-left">Função</th>
						<th class="text-left">Nome</th>
						<th class="text-left">Email</th>
						<th class="text-left">Telefone</th>
						<th class="text-left">Ação</th>
						<th><button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
					</thead>
					<tbody class="text-center">
						<tr class="hidden hiddenForm">
							<form action="/project/team/addOutsideMember/{{$project->id}}" method="POST">
								<td>
									<select class="form-control input-sm expertiseSelect" name="expertise">
										@foreach($expertise as $expert)
											<option value="{{$expert->id}}">{{$expert->name}}</option>
										@endforeach
									</select>
								</td>
								<td>
									<select class="form-control input-sm companySelect" name="company">
										<option value="0">Sem empresa</option>
										@foreach($companyContacts as $contact)
											<option value="{{$contact->id}}">{{$contact->name}}</option>
										@endforeach
									</select>
								</td>
								<td>
									<select class="form-control input-sm" name="function">
										@foreach($functions as $function)
											<option value="{{$function->id}}">{{$function->name}}</option>
										@endforeach
									</select>
								</td>
								<td>
									<select class="form-control input-sm coordinatorSelect" name="coordinator">
										<option value="0">Sem contacto pessoal</option>
										@foreach($contacts as $contact)
											<option class="company{{$contact->company != null ? $contact->company : 0}} coordinator" value="{{$contact->id}}">{{$contact->firstName}} {{$contact->lastName}}</option>
										@endforeach
									</select>
								</td>
								<td class="emailSpace"></td>
								<td class="phoneSpace"></td>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<td><button type="submit" class="btn btn-primary input-sm">Inserir</button></td>
							</form>
						</tr>
						@foreach($team as $member)
						<tr class="text-left">
							<td>
								{{$member->e_name}}
							</td>
							<td>
								{{$member->c_name}}
							</td>
							<td>
								{{$member->u_function}}
							</td>
							<td>
								{{$member->u_firstName}} {{$member->u_lastName}}
							</td>
							<td>
								{{$member->u_email}}
							</td>
							<td>
								{{$member->u_phone}}
							</td>
							<td data-editable='false'><button content='{{$member->id}}' style="padding: 3px 5px;" class="btn btn-danger removeMember" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
							<td></td>
						</tr>	
					</tbody>
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
	$.get('/project/deleteOutsideTeamMember/' + id, function() {
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

$('.expertiseSelect').change(function() {
	showSubExpertise();
});

var initialCoordinatorSelect = $('.coordinatorSelect').html();
function updateContacts() {
	$('.coordinatorSelect').empty();
	$('.coordinatorSelect').append(initialCoordinatorSelect);
	var company = $('.companySelect').val();
	var toAppend = "";
	toAppend += $('.coordinatorSelect option[value="0"]')[0].outerHTML;
	$('.coordinatorSelect .company' + company).each(function() {
		toAppend += $(this)[0].outerHTML;
	})
	$('.coordinatorSelect').empty();
	$('.coordinatorSelect').append(toAppend);
	$('.coordinatorSelect option[value="0"]').prop('selected', true);
	
}

$('.companySelect').change(function() {
	updateContacts();
});

updateContacts();

function getEmailAndPhone() {
	var user_id = $('.coordinatorSelect').val();
	if(user_id != 0) {
		$.get('/emailAndPhoneFromContact/' + user_id, function(response) {
			$('.emailSpace').text(response.email);
			$('.phoneSpace').text(response.phoneNumber);
		})
	}
}

getEmailAndPhone();

$('.coordinatorSelect').change(function() {
	console.log('oi');
	getEmailAndPhone();
})
</script>

@endsection