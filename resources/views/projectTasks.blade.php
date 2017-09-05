@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/datepicker-pt.js"></script>

<div id="myNav" class="overlay">

  <!-- Button to close the overlay navigation -->
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <div class="panel panel-default" style="margin-top: 8%;">
  	<div class="panel-info">
  		<div class="panel-heading smallPanelHeading">
  			<h5>
  				<span class="overlayTaskName"></span>
  				<button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-success editDescriptionButton pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button><button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-danger cancelEditDescription hidden pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button>
  			</h5>
  		</div>
  		<div class="panel-body">
  			<div class="summernoteOverlay">

  			</div>
  			<table class="table borderless descriptionTable" style="width: auto;">
  				<tr>
  					<td class="text-right"><b>Colaborador: </b></td>
  					<td class="overlayUser"></td>
  				</tr>
  				<tr>
  					<td class="text-right"> <b>Início: </b> </td>
  					<td class="overlayStartDate">-</td>
  					<td class="text-right"> <b>Fim: </b></td>
  					<td class="overlayEndDate">-</td>
  				</tr>
  				<tr>
  					<td class="text-right"> <b>Tipo: </b> </td>
  					<td class="overlayType">-</td>
  				</tr>
  				<tr>
	  				<td class="text-right"> <b>Especialidade: </b></td>
	  				<td class="overlayExpertise">-</td>
	  				<td class="text-right"> <b>Sub-Especialidade: </b></td>
	  				<td class="overlaySubExpertise">-</td>
	  				<td class="text-right"> <b>Fase: </b></td>
	  				<td class="overlayPhase">-</td>
  				</tr>
  			</table>
  			<div class="editTable hidden">
	  			<table class="table borderless" style="width: auto;">
					<tr>
	  					<td class="text-right"><b>Colaborador: </b></td>
	  					<td class="">
	  						<select class="form-control input-sm userSelect">
							@foreach($usersList as $user)
								<option value="{{$user->id}}">{{$user->sigla}}</option>
							@endforeach
	  						</select>
	  					</td>
	  				</tr>
	  				<tr>
	  					<td class="text-right"> <b>Início: </b> </td>
	  					<td><input type="text" required class="input-sm form-control datepicker overlayStartDatePicker" name="start_date"></td>
	  					<td class="text-right"> <b>Fim: </b> </td>
	  					<td><input type="text" required class="input-sm form-control datepicker overlayEndDatePicker" name="start_date"></td>
	  				</tr>
	  				<tr>
	  					<td class="text-right"> <b>Tipo: </b> </td>
	  					<td>
	  						<select name="type" disabled class="typeSelect input-sm form-control">
								@foreach($eventTypes as $type)
									<option value="{{$type->id}}">{{$type->name}}</option>
								@endforeach	
							</select>
	  					</td>
	  				</tr>
	  				<tr>
		  				<td class="text-right"> <b>Especialidade: </b></td>
		  				<td class="">
		  					<select name="expertise" class="input-sm form-control expertiseSelect">
								<option value="0">Sem Especialidade</option>
								@foreach($expertise as $expert)
									<option content="{{$expert->proj_e_id}}" value="{{$expert->id}}">{{$expert->name}}</option>
								@endforeach
							</select>
		  				</td>
		  				<td class="text-right"> <b>Sub-Especialidade: </b></td>
		  				<td class="">
		  					<select name="subExpertise" class="input-sm form-control subExpertiseSelect">
								<option value="0">Sem Sub-especialidade</option>
								@foreach($subExpertise as $expert)
									<option class="hidden parent parent{{$expert->parent}}" value="{{$expert->id}}">{{$expert->name}}</option>
								@endforeach
							</select>
		  				</td>
		  				<td class="text-right"> <b>Fase: </b></td>
		  				<td class="">
		  					<select name="phase" class="input-sm form-control phaseOptions">
								<option value="0">Sem Fase</option>
							</select>
		  				</td>
	  				</tr>
				</table>
				<button type="button" class="saveTask btn btn-success pull-right">Guardar</button>
			</div>
  		</div>
  	</div>
  </div>

</div>

<div class="col-xs-12 insideContainer">
	@include('layouts.project_nav')
	@include('layouts.project_management_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body">
			<div>
				<button class="btn btn-primary addType pull-right" type="button" style="padding-top: 2; padding-bottom: 2; margin-top: -30px;"><i class="glyphicon glyphicon-plus"></i></button>
				<button type="button" class="btn btn-primary pull-right hidden insertForm" style="padding-top: 2; padding-bottom: 2; margin-top: -30px;">Inserir</button>
				<button type="button" class="btn btn-danger pull-right cancelForm hidden" style="padding-top: 2; padding-bottom: 2; margin-top: -30px; margin-right: 80px;">Cancelar</button>
			</div>
			<table class="table smallFontTable" id='test-table'>
				<thead>
					<th class="text-center">Tipo</th>
					<th class="text-center">Início</th>
					<th class="text-center">Fim<br>Horas</th>
					<th class="text-center">Co</th>
					<th class="text-center">Esp</th>
					<th class="text-center">SE</th>
					<th class="text-center">Fase</th>
					<th class="text-center">Descrição</th>
					<th class="text-center">%</th>
					<th class="text-center">Obs</th>
				</thead>
				<tbody class="text-center">
					<tr class="hiddenForm hidden">
						<form action="/project/tasks/addTask/{{$project->id}}" id="addPlannedTask" method="POST">
							<td>
								<select name="type" class="form-control input-sm formTypeSelect">
									@foreach($eventTypes as $type)
										@if($type->id != 1)
										<option value="{{$type->id}}">{{$type->name}}</option>
										@endif
									@endforeach	
								</select>
							</td>
							<td><input type="text" required class="form-control datepicker input-sm startDateSelect" name="start_date"></td>
							<td><input type="text" required class="form-control datepicker input-sm endDateSelect" name="end_date"></td>
							<td>
								<select name="user" class="form-control input-sm">
									@foreach($usersList as $user)
									@if(Auth::user()->id == $user->id)
										<option selected value="{{$user->id}}">{{$user->sigla}}</option>
									@else
										<option value="{{$user->id}}">{{$user->sigla}}</option>
									@endif
									@endforeach
								</select>	
							</td>
							<td>
								<select name="expertise" class="form-control expertiseSelect input-sm">
									<option value="0">Sem Especialidade</option>
									@foreach($expertise as $expert)
										<option value="{{$expert->id}}" content="{{$expert->proj_e_id}}">{{$expert->name}}</option>
									@endforeach
								</select>
							</td>
							<td>
								<select name="subExpertise" class="form-control subExpertiseSelect input-sm">
									<option value="0">Sem Sub-especialidade</option>
									@foreach($subExpertise as $expert)
										<option class="hidden parent parent{{$expert->parent}}" value="{{$expert->id}}">{{$expert->name}}</option>
									@endforeach
								</select>
							</td>
							<td>
								<select name="phase" class="form-control phaseOptions input-sm">
									<option value="0">Sem Fase</option>
								</select>
							</td>
							<td>
								<input required class="form-control input-sm" type="text" name="name">
							</td>
							<td></td>
							<td><button type="button" class="openTextEditor btn btn-warning btn-xs" content="form">N</button></td>
							<input class="inputNotes" type="hidden" name="notes">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<td></td>
						</form>
					</tr>
					@foreach($tasks as $task)
					<tr>
						<td class="taskId hidden">{{$task->t_id}}</td>
						<td class="taskType">{{$task->ev_sigla}}</td>
						<td>{{$task->start_date}}</td>
						<td>{{$task->end_date}}</td>
						<td>{{$task->u_sigla}}</td>
						<td>{{$task->e_sigla}}</td>
						<td>{{$task->se_sigla}}</td>
						<td>{{$task->p_sigla}}</td>
						<td class="text-left openTaskLayer buttonCursor" style="width: 50%;">{{$task->t_name}}</td>
						@if($task->state < 25)
						<td style="background-color: red; color:white;">{{$task->state}}</td>
						@elseif($task->state < 75)
						<td style="background-color: orange; color:white;">{{$task->state}}</td>
						@elseif($task->state < 100)
						<td style="background-color: green; color:white;">{{$task->state}}</td>
						@else
						<td style="background-color: #39B1F0; color:white;">{{$task->state}}</td>
						@endif	
						<td>
							@if($task->notes != "")
							<button type="button" class="btn btn-warning openTextEditor btn-xs" style="color:black;" content="{{$task->t_id}}">
							@else
							<button type="button" class="btn btn-warning openTextEditor btn-xs" content="{{$task->t_id}}">
							@endif
								N
								<div class="noteContent noteContent{{$task->t_id}} hidden">
									{{$task->notes}}
								</div>
							</button>
						</td>
					</tr>
					<tr class="notesPlace{{$task->t_id}} notesPlace hidden">
						<td class="text-left" style="border: none;" colspan="10">
							<div id="summernote{{$task->t_id}}">	
							</div>
							<div class="editor hidden">
								<div class="pull-right">
									<button type="button" class="btn btn-danger cancelEditor">Cancelar</button>
									<button type="button" class="btn btn-success saveEditor">Guardar</button>
								</div>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>

checkTypes();

$('.formTypeSelect').change(function() {
	checkTypes();
})

function checkTypes() {
	if($('.formTypeSelect').val() == 2)
		$('.endDateSelect').addClass('hidden');
	else {
		$('.endDateSelect').removeClass('hidden');
	}
}

var idClicked = 0;
var taskType = 0;

$('.summernoteOverlay').summernote({
	height: 100,
	maximumImageFileSize: 65536
});
$('.note-editor').css('font-family', 'Arial');
$('.summernoteOverlay').summernote('disable');

$('.note-toolbar').addClass('hidden');

$('.openTaskLayer').click(function() {
	$('.overlayTaskName').text('-');
	$('.overlayStartDate').text('-');
	$('.overlayEndDate').text('-');
	$('.overlayUser').text('-');
	$('.overlayExpertise').text('-');
	$('.overlayPhase').text('-');
	$('.overlaySubExpertise').text('-');
	$('.overlayType').text('-');
	idClicked = $(this).closest('tr').find('.taskId').text();
	taskType = $(this).closest('tr').find('.taskType').text();
	$.ajax({
      type: "POST",
      url: '/project/plannedTasks/getTaskDetails',
      data: {
        'id' : idClicked,
        'task': taskType
      },
      success: function(response) {
      		$('#myNav').css('width', 'calc(96% - 200px)');
      		$('.overlayTaskName').text(response.name);
			$('.overlayStartDate').text(response.start_date);
			$('.overlayEndDate').text(response.end_date);
			$('.overlayUser').text(response.userName);
			$('.overlayExpertise').text(response.expertiseSigla);
			$('.overlayPhase').text(response.phaseSigla);
			if(response.subExpertiseSigla != null)
				$('.overlaySubExpertise').text(response.subExpertiseSigla);
			$('.overlayType').text(response.type);
			$('.overlayStartDatePicker').val(response.start_date);
			$('.overlayEndDatePicker').val(response.end_date);
			$('.summernoteOverlay').summernote('code', response.notes);

			$('.editTable .expertiseSelect option[value="0"]').prop('selected', true);
			$('.editTable .subExpertiseSelect option[value="0"]').prop('selected', true);
			$('.editTable .phaseOptions option[value="0"]').prop('selected', true);

			$('.editTable .userSelect option[value="' + response.user_id + '"]').prop('selected', true);
			$('.editTable .typeSelect option[value="' + response.type_id + '"]').prop('selected', true);
			$('.editTable .expertiseSelect option[value="' + response.expertise_id + '"]').prop('selected', true);
			appendPhaseToLayer(response.phase_id);
			$('.editTable .subExpertiseSelect option[value="' + response.subexpertise_id + '"]').prop('selected', true);
      	}
      });
});

$('.editDescriptionButton').click(function() {
	$(this).addClass('hidden');
	$('.cancelEditDescription').removeClass('hidden');
	$('.editTable').removeClass('hidden');
	$('.descriptionTable').addClass('hidden');
	$('.summernoteOverlay').summernote('enable');
});

$('.cancelEditDescription').click(function() {
	$(this).addClass('hidden');
	$('.editDescriptionButton').removeClass('hidden');
	$('.editTable').addClass('hidden');
	$('.descriptionTable').removeClass('hidden');
	$('.summernoteOverlay').summernote('disable');
});

$('.saveTask').click(function() {
	var user = $('.editTable .userSelect').val();
	var phase = $('.editTable .phaseOptions').val();
	var expertise = $('.editTable .expertiseSelect').val();
	var subExpertise = $('.editTable .subExpertiseSelect').val();
	var start_date = $('.editTable .overlayStartDatePicker').val();
	var end_date = $('.editTable .overlayEndDatePicker').val();
	var notes = $('.summernoteOverlay').summernote('code');
	var id = idClicked;
	$.ajax({
      type: "POST",
      url: '/project/plannedTasks/editTask',
      data: {
        'id' : id,
        'project_id': '{{$project->id}}',
        'user': user,
        'taskType': taskType,
        'phase': phase,
        'expertise': expertise,
        'subExpertise': subExpertise,
        'start_date': start_date,
        'end_date': end_date,
        'notes': notes
      },
      success: function() {
        location.reload();
      }
    });
});

var openedEditor = null;

$('.openTextEditor').click(function() {
	$('.notesPlace').each(function() {
		$(this).addClass('hidden');
	});
	$('.editor').addClass('hidden');
	openedEditor = $(this).attr('content');
	isTask = $(this).attr('2ndContent');
	$('#summernoteTask' + openedEditor ).summernote({
		focus: true,
		height: 100,
		maximumImageFileSize: 65536
	});
	$('.notesPlace' + openedEditor).find('.editor').removeClass('hidden');
	$('.notesPlace' + openedEditor).removeClass('hidden');
	
	if($(this).attr('content') == 'form') {
		if($('.inputNotes').val() != "")
			$('#summernote').summernote('code', $('.inputNotes').val());
	} else {
		if(isTask == 'task')
			$('#summernoteTask' + openedEditor).summernote('code', $(this).find('.noteContent').text());
		else
			$('#summernote' + openedEditor).summernote('code', $(this).find('.noteContent').text());
	}
});

$('.saveEditor').click(function() {
	if(openedEditor == 'form') {
		$('.inputNotes').val(notes);
	} else {
		var notes = $('#summernote' + openedEditor).summernote('code');
		$.ajax({
		  type: "POST",
		  url: '/project/plannedTasks/editNote',
		  data: {
		  	"id": openedEditor,
		  	"notes": notes,
		  },
		  success: function() {
		  }
		});
	}

	if(openedEditor != 'form') {
		$('.noteContent' + openedEditor).text(notes);
	}
	$(this).closest('.notesPlace').addClass('hidden');
	$('.editor').addClass('hidden');
});

$('.cancelEditor').click(function() {
	$(this).closest('.notesPlace').addClass('hidden');
});

$('.cancelEditor').click(function() {
	$('#summernote').summernote('destroy');
	$('#summernote').empty();
	$('.editor').addClass('hidden');
});

$( function() {
	$( ".datepicker" ).datepicker();
    $( ".datepicker" ).datepicker("option", "dateFormat",'yy-mm-dd');
});

$('.addType').click(function() {
	$('.hiddenForm').removeClass('hidden');
	$('.insertForm').removeClass('hidden');
	$('.cancelForm').removeClass('hidden');
	$('.addType').addClass('hidden');
});

$('.cancelForm').click(function() {
	$('.hiddenForm').addClass('hidden');
	$('.insertForm').addClass('hidden');
	$('.cancelForm').addClass('hidden');
	$('.addType').removeClass('hidden');
});

$('.insertForm').click(function() {
	$('#addPlannedTask').submit();
})

$('.hiddenForm .expertiseSelect').change(function() {
	var content = $('.hiddenForm .expertiseSelect').find(":selected").attr('content');
	var value = $('.hiddenForm .expertiseSelect').val();
	$('.hiddenForm .subExpertiseSelect .parent').each(function() {
		$(this).addClass('hidden');
		if($(this).hasClass('parent' + value)) {
			$(this).removeClass('hidden');
		}
	});
    $.ajax({
      type: "POST",
      url: '/getExpertisePhasesFromProject',
      data: {
        'project_expertise_id' : content
      },
      success: function(response) {
        $('.hiddenForm .phaseOptions').empty();
        $('.hiddenForm .phaseOptions').append('<option value="0">Sem Fase</option>');
        for(var i = 0; i < response.length; i++) {
            $('.hiddenForm .phaseOptions').append('<option value="' + response[i].id + '">' + response[i].name + '</option>' );
        }
      }
    });
});

$('.editTable .expertiseSelect').change(function() {
	$('.editTable .subExpertiseSelect option[value="0"]').prop('selected', true);
	$('.editTable .phaseSelect').empty();
    $('.editTable .phaseSelect').append('<option value="0">Sem Fase</option>');
	appendPhaseToLayer(null);
});

function appendPhaseToLayer(phase_id) {
	var content = $('.editTable .expertiseSelect').find(":selected").attr('content');
	var value = $('.editTable .expertiseSelect').val();
	$('.editTable .subExpertiseSelect .parent').each(function() {
		$(this).addClass('hidden');
		if($(this).hasClass('parent' + value)) {
			$(this).removeClass('hidden');
		}
	});
	if(content != undefined) {
		$.ajax({
	      type: "POST",
	      url: '/getExpertisePhasesFromProject',
	      data: {
	        'project_expertise_id' : content
	      },
	      success: function(response) {
	        $('.editTable .phaseOptions').empty();
	        $('.editTable .phaseOptions').append('<option value="0">Sem Fase</option>');
	        for(var i = 0; i < response.length; i++) {
	            $('.editTable .phaseOptions').append('<option value="' + response[i].id + '">' + response[i].name + '</option>' );
	        }
	        if(phase_id != null)
	        	$('.editTable .phaseOptions option[value="' + phase_id + '"]').prop('selected', true);
	      }
	    });
	}
}

$('.removeTask').click(function() {
	var id = $(this).attr('content');
	var r = confirm("Quer mesmo eliminar esta tarefa?");
	if(r == true) {
		$(this).parent().parent().find('td').remove();
		$.get('/project/tasks/removeTask/' + id, function() {
		});
	} else {

	}
});	

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
    document.getElementById("myNav").style.width = "0%";
}
</script>


@endsection