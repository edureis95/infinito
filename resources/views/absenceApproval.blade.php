@extends('layouts.app')

@section('content')

<div class="col-xs-12" style="max-width: 98%;">
	@include('layouts.personal_nav')
	@include('layouts.personal_approval_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body" style="padding-left: 0;">
			<button class="dropdown-toggle saveApproval btn btn-success" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px; margin-left: 85%;">
					<span style="font-size: 12px;">Aprovar</span>
			</button>
			<button class="dropdown-toggle saveReject btn btn-danger" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px; margin-left: 75%;">
					<span style="font-size: 12px;">Rejeitar</span>
			</button>
			<div class="dropdown" style="margin-left: 95%;">
				<button class="dropdown-toggle btn btn-primary" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px;">
					<span style="font-size: 12px;">Filtro</span>
				</button>
				<ul class="dropdown-menu dropdown-form pull-right">
		            <li>
		            	<div class="col-xs-12">
							<table class="table borderless" style="width: 75%;">
								<tr>
									<td>Colaborador</td>
									<td>
										<select class="userFilter form-control" class="form-control">
											<option value="0">Sem filtro</option>
											@foreach($users as $user)
											<option value="{{$user->id}}">{{$user->sigla}}</option>
											@endforeach
										</select>
									</td>
								</tr>
								<tr>
									<td>Desde</td>
									<td><input class="form-control startDateFilter" type="date"></td>
								</tr>
								<tr>
									<td>Até</td>
									<td>
										<input  class="form-control endDateFilter" type="date">
									</td>
								</tr>
								<tr>
									<td>Ocultar férias aprovadas</td>
									<td>
										<input class="approvedFilter" checked type="checkbox">
									</td>
								</tr>
								<tr>
								<td></td>
								</tr>
							</table>
						</div>
					</li>
				</ul>
			</div>

			<table class="table approvalTable smallFontTable">
				<thead>
					<th class="text-center">Início</th>
					<th class="text-center">Fim<br>Horas</th>
					<th class="text-center">Co</th>
					<th class="text-center">Departamento</th>
					<th class="text-center">Motivo</th>
					<th class="text-center" style="width: 50%;">Descrição</th>	
					<th class="text-center">Aprovar</th>
					<th class="text-center">Rejeitar</th>
				</thead>
				<tbody class="text-center">
				@foreach($absences as $absence)
					<tr>
						<td>{{$absence->start_date}}</td>
						<td>{{$absence->end_date}}</td>
						<td>{{$absence->u_sigla}}</td>
						<td>Departamento</td>
						<td>{{$absence->a_name}}</td>
						<td class="text-left">{{$absence->text}}</td>
						<td class="taskNotApproved"><input content="{{$absence->a_id}}" class="approvalCheckbox" type="checkbox"></td>
						<td class="taskNotApproved"><input content="{{$absence->a_id}}" class="rejectCheckbox" type="checkbox"></td>
					</tr>
				@endforeach
				</tbody>
			</table>
			</div>
			<button type="button" class="btn btn-success" id="saveApproval">Guardar</button>
			<span class="savedBox hidden" style="color: green;"><i class="glyphicon glyphicon-check"></i> As permissões foram guardadas</span>
		</div>
	</div>
</div>

<script>

$('.dropdown-form select').click(function(e) {
	e.stopPropagation();
});

$('.approvalTable').on('change', '.approvalCheckbox', function() {
	if($(this).is(":checked")) {
		$(this).parent().addClass('taskApproved');
		$(this).parent().removeClass('taskNotApproved');
		var id = $(this).attr('content');
		$('.rejectCheckbox[content="' + id +'"]').parent().removeClass('taskNotApproved');
		$('.rejectCheckbox[content="' + id +'"]').parent().addClass('taskApproved');
		$('.rejectCheckbox[content="' + id +'"]').prop('checked', false);
	}
	else {
		$(this).parent().addClass('taskNotApproved');
		$(this).parent().removeClass('taskApproved');
		var id = $(this).attr('content');
		$('.rejectCheckbox[content="' + id +'"]').parent().removeClass('taskApproved');
		$('.rejectCheckbox[content="' + id +'"]').parent().addClass('taskNotApproved');
		$('.rejectCheckbox[content="' + id +'"]').prop('checked', false);
	}
});

$('.approvalTable').on('change', '.rejectCheckbox', function() {
	if($(this).is(":checked")) {
		$(this).parent().addClass('taskNotApproved');
		$(this).parent().removeClass('taskApproved');
		var id = $(this).attr('content');
		$('.approvalCheckbox[content="' + id +'"]').parent().removeClass('taskApproved');
		$('.approvalCheckbox[content="' + id +'"]').parent().addClass('taskNotApproved');
		$('.approvalCheckbox[content="' + id +'"]').prop('checked', false);
	}
	else {
		var id = $(this).attr('content');
		$(this).parent().addClass('taskNotApproved');
		$(this).parent().removeClass('taskApproved');
		$('.approvalCheckbox[content="' + id +'"]').prop('checked', false);
	}
});
$('#saveApproval').click(function() {
	var obj = {};
	var ids = [];
	$('.approvalTable .approvalCheckbox').each(function() {
		obj[$(this).attr('content')] = $(this).is(":checked");
		ids.push($(this).attr('content'));
	});
	obj['ids'] = ids;

	var rejected = {};
	var rejectedids = [];
	$('.approvalTable .rejectCheckbox').each(function() {
		rejected[$(this).attr('content')] = $(this).is(":checked");
		rejectedids.push($(this).attr('content'));
	});
	rejected['ids'] = rejectedids;

	$.ajax({
	  type: "POST",
	  url: '/management/absenceApproval/saveApproval',
	  data: {
	  	'obj' : obj,
	  	'rejected' : rejected
	  },
	  success: function(response) {
	  	$('.savedBox').removeClass('hidden');
	  }
	});
});

$('.userFilter').change(function() {
	refreshFilter();
})

$('.startDateFilter').change(function() {
	refreshFilter();
})

$('.endDateFilter').change(function() {
	refreshFilter();
})

$('.approvedFilter').change(function() {
	refreshFilter();
})

function refreshFilter() {
	var user = $('.userFilter').val();
	var startDateFilter = $('.startDateFilter').val();
	var endDateFilter = $('.endDateFilter').val();
	var approvedFilter = $('.approvedFilter').is(":checked");

	$.ajax({
	      type: "POST",
	      url: '/management/absenceApproval/filter',
	      data: {
	        'user' : user,
	        'startDateFilter' : startDateFilter,
	        'endDateFilter' : endDateFilter,
	        'approvedFilter' : approvedFilter
          },
          success: function(response) {
          	$('.approvalTable tbody').empty();
          	for(var i = 0; i < response.length; i++) {
          		if(response[i].a_ap == 0) {
          			$('.approvalTable tbody').append('<tr>' +
													'<td> ' + response[i].start_date + '</td>' +
													'<td>'+ response[i].end_date + '</td>' +
													'<td>'+ response[i].u_sigla + '</td>' +
													'<td>'+ response[i].a_name +'</td>' +
													'<td class="text-left">'+ response[i].text +'</td>' +
													'<td class="taskNotApproved"><input content="'+ response[i].a_id +'"class="approvalCheckbox" type="checkbox"></td>' +
													'<td class="taskNotApproved"><input content="'+ response[i].a_id +'"class="rejectCheckbox" type="checkbox"></td>' +
												'</tr>');
          		} else if(response[i].a_ap > 0){
          			$('.approvalTable tbody').append('<tr>' +
													'<td> ' + response[i].start_date + '</td>' +
													'<td>'+ response[i].end_date + '</td>' +
													'<td>'+ response[i].u_sigla + '</td>' +
													'<td>'+ response[i].a_name +'</td>' +
													'<td class="text-left">'+ response[i].text +'</td>' +
													'<td class="taskApproved"><input content="'+ response[i].a_id +'"class="approvalCheckbox" checked type="checkbox"></td>' +
													'<td class="taskApproved"><input content="'+ response[i].a_id +'"class="rejectCheckbox" type="checkbox"></td>' +
												'</tr>');
          		} else {
          			$('.approvalTable tbody').append('<tr>' +
													'<td> ' + response[i].start_date + '</td>' +
													'<td>'+ response[i].end_date + '</td>' +
													'<td>'+ response[i].u_sigla + '</td>' +
													'<td>'+ response[i].a_name +'</td>' +
													'<td class="text-left">'+ response[i].text +'</td>' +
													'<td class="taskNotApproved"><input content="'+ response[i].a_id +'"class="approvalCheckbox" type="checkbox"></td>' +
													'<td class="taskNotApproved"><input content="'+ response[i].a_id +'"class="rejectCheckbox" checked type="checkbox"></td>' +
												'</tr>');
          		}
          		
          	}
          }
      });

}

</script>


@endsection