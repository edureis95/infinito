@extends('layouts.app')

@section('content')

<div class="col-xs-12 insideContainer">
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
			            	<table class="table borderless filterTable" style="width: 75%;">
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
									<td>Projeto</td>
									<td>
										<select class="form-control projectFilter">
											<option value="0">Sem filtro</option>
											@foreach($projectsList as $project) 
											<option value="{{$project->id}}">{{sprintf('%05d', $project->number)}} - {{$project->name}}</option>
											@endforeach
										</select>
									</td>
								</tr>
								<tr>
									<td>Fase</td>
									<td>
										<select class="form-control phaseFilter">
											<option value="0">Sem filtro</option>
											@foreach($phases as $phase)
											<option value="{{$phase->id}}">{{$phase->name}}</option>
											@endforeach
										</select>
									</td>
								</tr>
								<tr>
									<td>Especialidade</td>
									<td>
										<select class="form-control expertiseFilter">
											<option value="0">Sem filtro</option>
											@foreach($expertise as $expert)
											<option value="{{$expert->id}}">{{$expert->name}}</option>
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
									<td>Ocultar horas aprovadas</td>
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
			<table class="table approvalTable smallFontTable" style="margin-top: -1px;">
				<thead>
					<th class="text-center"><input type="checkbox" class="overallCheckbox"></th>
					<th class="text-center">Data</th>
					<th class="text-center">Co</th>
					<th class="text-center">Área</th>
					<th class="text-center">Projeto</th>
					<th class="text-center">Fase</th>
					<th class="text-center">Esp</th>
					<th class="text-center" style="width: 50%;">Descrição</th>
					<th class="text-center">Tempo</th>
					<th class="text-center">%</th>
				</thead>
				<tbody>
				@foreach($tasks as $task)
					<tr class="text-center">
						<td><input content="{{$task->t_id}}" class="approvalCheckbox" type="checkbox"></td>
						<td>{{$task->date}}</td>
						<td>{{$task->u_sigla}}</td>
						<td>Área</td>
						<td>{{sprintf('%05d', $task->p_number)}} - {{$task->p_name}}</td>
						<td>{{$task->ph_sigla}}</td>
						<td>{{$task->e_sigla}}</td>
						<td class="text-left">{{$task->t_name}}</td>
						<td>{{sprintf('%02d', $task->t_hours)}}:{{sprintf('%02d', $task->t_min)}}</td>
						@if($task->done < 25)
						<td style="background-color: red; color:white;">{{$task->done}}</td>
						@elseif($task->done < 75)
						<td style="background-color: orange; color:white;">{{$task->done}}</td>
						@elseif($task->done < 100)
						<td style="background-color: green; color:white;">{{$task->done}}</td>
						@else
						<td style="background-color: #39B1F0; color:white;">{{$task->done}}</td>
						@endif	
					</tr>
				@endforeach
				</tbody>
			</table>
			</div>
			<span class="savedBox hidden" style="color: green;"><i class="glyphicon glyphicon-check"></i> As permissões foram guardadas</span>
		</div>
	</div>
</div>

<script>

$('.overallCheckbox').change(function() {
	if($(this).is(':checked')) {
		$('.approvalCheckbox').each(function() {
			$(this).prop('checked', true);
		})
	} else {
		$('.approvalCheckbox').each(function() {
			$(this).prop('checked', false);
		})
	}
})

$('.approvalTable').on('change', '.approvalCheckbox', function() {
	/*if($(this).is(":checked")) {
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
	}*/
});

$('.approvalTable').on('change', '.rejectCheckbox', function() {
	/*if($(this).is(":checked")) {
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
	}*/
});

$('.saveApproval').click(function() {
	var obj = {};
	var ids = [];
	$('.approvalTable .approvalCheckbox').each(function() {
		obj[$(this).attr('content')] = $(this).is(":checked");
		ids.push($(this).attr('content'));
	});
	obj['ids'] = ids;

	$.ajax({
	  type: "POST",
	  url: '/management/hoursApproval/saveApproval',
	  data: {
	  	'obj' : obj
	  },
	  success: function() {
	  	location.reload();
	  }
	});
});

$('.saveReject').click(function() {
	var obj = {};
	var ids = [];
	$('.approvalTable .approvalCheckbox').each(function() {
		obj[$(this).attr('content')] = $(this).is(":checked");
		ids.push($(this).attr('content'));
	});
	obj['ids'] = ids;

	$.ajax({
	  type: "POST",
	  url: '/management/hoursApproval/saveReject',
	  data: {
	  	'obj' : obj
	  },
	  success: function() {
	  	location.reload();
	  }
	});
});

var expertise = $('.expertiseFilter').html();
var phases = $('.phaseFilter').html();

$('.projectFilter').change(function() {
	/*var id = this.value;
	if(id == 0) {
		$('.phaseFilter').empty();
		$('.phaseFilter').append(phases);
	} else {
		$('.phaseFilter').empty();
		$('.phaseFilter').append('<option value="0">Sem Filtro</option>');
		$('.expertiseFilter').empty();
		$('.expertiseFilter').append('<option value="0">Sem Filtro</option>');
		$.ajax({
          type: "POST",
          url: '/getDetailsFromProject',
          data: {
            'project_id' : id
          },
          success: function(response) {

            for(var i = 0; i < response[0].length; i++) {
                var id = response[0][i].id;
                var name = response[0][i].name;
                $('.phaseFilter').append('<option value="' + id + '">' + name + '</option>' );
            }
            for(var i = 0; i < response[1].length; i++) {
                var id = response[1][i].id;
                var name = response[1][i].name;
                if(response[1][i].parent == 0) {
                    $('.expertiseFilter').append('<option value="' + id + '">' + name + '</option>' );
                }
            }
          }
        });
	}*/
});

function refreshFilter() {
	var user = $('.userFilter').val();
	var project = $('.projectFilter').val();
	var phase = $('.phaseFilter').val();
	var expertise = $('.expertiseFilter').val();
	var startDateFilter = $('.startDateFilter').val();
	var endDateFilter = $('.endDateFilter').val();
	var approvedFilter = $('.approvedFilter').is(":checked");

	$.ajax({
	      type: "POST",
	      url: '/management/hoursApproval/filter',
	      data: {
	        'user' : user,
	        'project' : project,
	        'phase' : phase,
	        'expertise' : expertise,
	        'startDateFilter' : startDateFilter,
	        'endDateFilter' : endDateFilter,
	        'approvedFilter' : approvedFilter
          },
          success: function(response) {
          	console.log(response);
          	$('.approvalTable tbody').empty();
          	for(var i = 0; i < response.length; i++) {
          		if(response[i].t_ap == 0) {
          			var conclusion = response[i].done;
          			var conclusionLine = null;
          			if(conclusion < 25) {
          				conclusionLine = '<td style="background-color: red; color: white";>' + conclusion + '</td>';
          			} else if(conclusion < 75) {
          				conclusionLine = '<td style="background-color: orange; color: white";>' + conclusion + '</td>';
          			} else if(conclusion < 100)
          				conclusionLine = '<td style="background-color: green; color: white";>' + conclusion + '</td>';
          			else
          				conclusionLine = '<td style="background-color: #39B1F0; color: white";>' + conclusion + '</td>';

          			$('.approvalTable tbody').append('<tr class="text-center">' +
          											'<td class=""><input content="'+ response[i].t_id +'"class="approvalCheckbox" type="checkbox"></td>' +
													'<td> ' + response[i].date + '</td>' +
													'<td>'+ response[i].u_sigla + '</td>' +
													'<td>' + '</td>' +
													'<td>'+ ("0" + response[i].p_number).slice(-5) + ' - ' + response[i].p_name +'</td>' +
													'<td>'+ response[i].ph_sigla +'</td>' +
													'<td>'+ response[i].e_sigla +'</td>' +
													'<td class="text-left">'+ response[i].t_name +'</td>' +
													'<td>'+ ("0" + response[i].t_hours).slice(-2) +':'+ ("0" + response[i].t_min).slice(-2) +'</td>' +
													conclusionLine +
												'</tr>');
          		} else if(response[i].t_ap > 0){
          			var conclusion = response[i].done;
          			var conclusionLine = null;
          			if(conclusion < 25) {
          				conclusionLine = '<td style="background-color: red; color: white";>' + conclusion + '</td>';
          			} else if(conclusion < 75) {
          				conclusionLine = '<td style="background-color: orange; color: white";>' + conclusion + '</td>';
          			} else if(conclusion < 100)
          				conclusionLine = '<td style="background-color: green; color: white";>' + conclusion + '</td>';
          			else
          				conclusionLine = '<td style="background-color: #39B1F0; color: white";>' + conclusion + '</td>';
          			$('.approvalTable tbody').append('<tr class="text-center">' +
          											'<td class="taskApproved"><input content="'+ response[i].t_id +'"class="approvalCheckbox" type="checkbox"></td>' +
													'<td> ' + response[i].date + '</td>' +
													'<td>'+ response[i].u_sigla + '</td>' +
													'<td>' + '</td>' +
													'<td>'+ ("0" + response[i].p_number).slice(-5) + ' - ' + response[i].p_name +'</td>' +
													'<td>'+ response[i].ph_sigla +'</td>' +
													'<td>'+ response[i].e_sigla +'</td>' +
													'<td class="text-left">'+ response[i].t_name +'</td>' +
													'<td>'+ ("0" + response[i].t_hours).slice(-2) +':'+ ("0" + response[i].t_min).slice(-2) +'</td>' +
													conclusionLine +
												'</tr>');
          		} else {
          			var conclusion = response[i].done;
          			var conclusionLine = null;
          			if(conclusion < 25) {
          				conclusionLine = '<td style="background-color: red; color: white";>' + conclusion + '</td>';
          			} else if(conclusion < 75) {
          				conclusionLine = '<td style="background-color: orange; color: white";>' + conclusion + '</td>';
          			} else if(conclusion < 100)
          				conclusionLine = '<td style="background-color: green; color: white";>' + conclusion + '</td>';
          			else
          				conclusionLine = '<td style="background-color: #39B1F0; color: white";>' + conclusion + '</td>';
          			$('.approvalTable tbody').append('<tr class="text-center">' +
          											'<td class="taskNotApproved"><input content="'+ response[i].t_id +'"class="approvalCheckbox" type="checkbox"></td>' +
													'<td> ' + response[i].date + '</td>' +
													'<td>'+ response[i].u_sigla + '</td>' +
													'<td>' + '</td>' +
													'<td>'+ ("0" + response[i].p_number).slice(-5) + ' - ' + response[i].p_name +'</td>' +
													'<td>'+ response[i].ph_sigla +'</td>' +
													'<td>'+ response[i].e_sigla +'</td>' +
													'<td class="text-left">'+ response[i].t_name +'</td>' +
													'<td>'+ ("0" + response[i].t_hours).slice(-2) +':'+ ("0" + response[i].t_min).slice(-2) +'</td>' +
													conclusionLine +
												'</tr>');
          		}
          		
          	}
          }
      });

}

$('.dropdown-form select').click(function(e) {
	e.stopPropagation();
});

$('.userFilter').change(function() {
	refreshFilter();
})

$('.projectFilter').change(function() {
	refreshFilter();
})

$('.phaseFilter').change(function() {
	refreshFilter();
})

$('.expertiseFilter').change(function() {
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

</script>


@endsection