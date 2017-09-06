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
  			<div class="descriptionTable">
  			<table class="table borderless descriptionTable" style="width: auto;">
  				<tr>
  					<td><b>Colaborador: </b></td>
  					<td class="overlayUser"></td>
  				</tr>
  				<tr>
  					<td> <b>Data: </b> </td>
  					<td class="overlayDate">-</td>
  				</tr>
  				<tr>
  					<td> <b>Tipo: </b> </td>
  					<td class="overlayType">-</td>
  				</tr>
  				<tr>
	  				<td> <b>Especialidade: </b></td>
	  				<td class="overlayExpertise">-</td>
	  				<td> <b>Sub-Especialidade: </b></td>
	  				<td class="overlaySubExpertise">-</td>
	  				<td> <b>Fase: </b></td>
	  				<td class="overlayPhase">-</td>
  				</tr>
  			</table>
  			<button type="button" class="btn btn-danger pull-left">Eliminar Registo</button>
  			</div>
  			<div class="editTable hidden">
	  			<table class="table borderless" style="width: auto;">
					<tr>
	  					<td><b>Colaborador: </b></td>
	  					<td class="">
	  						<select class="form-control input-sm userSelect">
							@foreach($usersList as $user)
								<option value="{{$user->id}}">{{$user->sigla}}</option>
							@endforeach
	  						</select>
	  					</td>
	  				</tr>
	  				<tr>
	  					<td> <b>Data: </b> </td>
	  					<td><input type="text" required class="input-sm form-control datepicker overlayDatePicker" name="start_date"></td>
	  				</tr>
	  				<tr>
	  					<td> <b>Tipo: </b> </td>
	  					<td>
	  						<select name="type" disabled class="typeSelect input-sm form-control">
								@foreach($eventTypes as $type)
									<option value="{{$type->id}}">{{$type->name}}</option>
								@endforeach	
							</select>
	  					</td>
	  				</tr>
	  				<tr>
		  				<td> <b>Especialidade: </b></td>
		  				<td class="">
		  					<select name="expertise" class="input-sm form-control expertiseSelect">
								<option value="0">Sem Especialidade</option>
								@foreach($expertise as $expert)
									<option content="{{$expert->proj_e_id}}" value="{{$expert->id}}">{{$expert->name}}</option>
								@endforeach
							</select>
		  				</td>
		  				<td> <b>Sub-Especialidade: </b></td>
		  				<td class="">
		  					<select name="subExpertise" class="input-sm form-control subExpertiseSelect">
								<option value="0">Sem Sub-especialidade</option>
								@foreach($subExpertise as $expert)
									<option class="hidden parent parent{{$expert->parent}}" value="{{$expert->id}}">{{$expert->name}}</option>
								@endforeach
							</select>
		  				</td>
		  				<td> <b>Fase: </b></td>
		  				<td class="">
		  					<select name="phase" class="input-sm form-control phaseSelect">
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
	@include('layouts.commercial_project_nav')
	@include('layouts.commercial_project_secondNav')
	<div class="panel panel-default borderless">
		<div class="panel-body">
			<div>
				<button class="btn btn-primary addType pull-right" type="button" style="padding-top: 2; padding-bottom: 2; margin-top: -30px;"><i class="glyphicon glyphicon-plus"></i></button>
				<button type="button" class="btn btn-primary pull-right hidden insertForm" style="padding-top: 2; padding-bottom: 2; margin-top: -30px;">Inserir</button>
				<button type="button" class="btn btn-danger pull-right cancelForm hidden" style="padding-top: 2; padding-bottom: 2; margin-top: -30px; margin-right: 80px;">Cancelar</button>
			</div>
			<table class="table smallFontTable" style="margin: 0;">
				<thead>
					<th class="text-center">Data</th>
					<th class="text-center">Tipo</th>
					<th class="text-center">Co</th>
					<th class="text-center">Esp</th>
					<th class="text-center">SE</th>
					<th class="text-center">Fase</th>
					<th class="text-center">Descrição</th>
					<th class="text-center">Tempo</th>
					<th class="text-center">%</th>
					<th class="text-center">Obs</th>
					<th></th>
				</thead>
				<tbody class="text-center">
					<tr class="hiddenForm hidden">
						<form action="/commercialProject/addExecutedTask/{{$project->id}}" id="addExecutedTask" method="POST">
							<td><input type="text" required class="input-sm form-control datepicker" name="start_date"></td>
							<td>
								<select name="type" class="typeSelect input-sm form-control">
									@foreach($eventTypes as $type)
										<option value="{{$type->id}}">{{$type->name}}</option>
									@endforeach	
								</select>
							</td>
							<td>
								<select name="user" class="input-sm form-control">
									@foreach($usersList as $user)
									@if(Auth::user()->id == $user->id)
										<option selected value="{{$user->id}}">{{$user->sigla}}</option>
									@else
										<option value="{{$user->id}}">{{$user->sigla}}</option>
									@endif
									@endforeach
								</select>	
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td>
								<select class="form-control input-sm hidden nameInput" name="name">
									<option hidden disabled selected value> ---Escolhe um evento planeado--- </option>
									@foreach($plannedEvents as $event)
									<option class="eventType{{$event->type}}" value="{{$event->id}}">{{$event->name}}</option>
									@endforeach
								</select>
								<select name="task" class="input-sm form-control hidden plannedTasks">
									@foreach($plannedTasks as $task)
									<option value="{{$task->id}}">{{$task->name}}</option>
									@endforeach
								</select>
								<select name="state" class="input-sm form-control hidden stateTypes">
									@foreach($states as $state)
									<option value="{{$state->id}}">{{$state->name}}</option>
									@endforeach
								</select>	
							</td>
							<td>
								<div class="inputTime hidden">
									<input type="number" class="input-sm form-control" name="hours" placeholder="horas" style="float:left; width: 50%;">
									<input type="number" class="input-sm form-control" placeholder="minutos" name="minutes" style="width: 50%; float: left;">
								</div>
							</td>
							<td><input class="form-control input-sm statePercentage hidden" type="number" max="100" min="0" name="statePercentage"></td>
							<td><button type="button" class="input-sm openTextEditor btn btn-xs btn-warning" content="form">N</button></td>
							<input class="inputNotes" type="hidden" name="notes">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
						</form>
					</tr>
					@foreach($executedTasks as $task)
					<tr>	
						<td class="taskId hidden">{{$task->t_id}}</td>
						<td class="taskStartDate">{{$task->start_date}}</td>
						<td class="taskType">{{$task->ev_sigla}}</td>
						<td class="userSigla">{{$task->u_sigla}}</td>
						<td class="expertiseSigla">{{$task->e_sigla}}</td>
						<td class="subExpertiseSigla">{{$task->se_sigla}}</td>
						<td class="phaseSigla">{{$task->p_sigla}}</td>
						<td class="text-left taskName openTaskLayer buttonCursor" style="width: 50%;">{{$task->t_name}}</td>
						<td>
							@if($task->hours != "" || $task->minutes != "")
								{{sprintf('%02d', $task->hours)}}:{{sprintf('%02d', $task->minutes)}}
							@else
								-
							@endif
						</td>
						@if($task->state == '-')
						<td>{{$task->state}}</td>
						@elseif($task->outdated == 1)
						<td>{{$task->state}}</td>
						@elseif($task->state < 25)
						<td style="background-color: red; color:white;">{{$task->state}}</td>
						@elseif($task->state < 75)
						<td style="background-color: orange; color:white;">{{$task->state}}</td>
						@elseif($task->state < 100)
						<td style="background-color: green; color:white;">{{$task->state}}</td>
						@else
						<td style="background-color: #39B1F0; color:white;">{{$task->state}}</td>
						@endif	
						@if($task->ev_sigla == 'TF')
						<td>
							<button type="button" class="btn btn-warning openTextEditor btn-xs" 2ndContent="task" content="{{$task->t_id}}">
								N
								<div class="noteContent noteContent{{$task->t_id}} hidden">
									{{$task->notes}}
								</div>
							</button>
						</td>
						@else
						<td>
							@if($task->notes != "")
							<button type="button" class="btn btn-warning openTextEditor btn-xs" style="color: black;" content="{{$task->t_id}}">
							@else
							<button type="button" class="btn btn-warning openTextEditor btn-xs" content="{{$task->t_id}}">
							@endif
								N
								<div class="noteContent noteContentExecuted{{$task->t_id}} hidden">
									{{$task->notes}}
								</div>
							</button>
						</td>
						@endif
						<td></td>
					</tr>
					@if($task->ev_sigla == 'TF')
					<tr class="notesPlaceTask{{$task->t_id}} notesPlace hidden">
						<td class="text-left" style="border: none;" colspan="10">
							<div id="summernoteTask{{$task->t_id}}">	
							</div>
							<div class="editor hidden">
								<div class="pull-right">
									<button type="button" class="btn btn-danger cancelEditor">Cancelar</button>
									<button type="button" class="btn btn-success saveEditor">Guardar</button>
								</div>
							</div>
						</td>
					</tr>
					@else
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
					@endif
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>

</style>
<script>

var idClicked = 0;
var taskType = 0;

$('.summernoteOverlay').summernote({
	height: 100,
	maximumImageFileSize: 65536
});
$('.note-editor').css('font-family', 'Arial');
$('.summernoteOverlay').summernote('disable');

$('.openTaskLayer').click(function() {
	$('.overlayTaskName').text('-');
	$('.overlayDate').text('-');
	$('.overlayUser').text('-');
	$('.overlayExpertise').text('-');
	$('.overlayPhase').text('-');
	$('.overlaySubExpertise').text('-');
	$('.overlayType').text('-');
	idClicked = $(this).closest('tr').find('.taskId').text();
	taskType = $(this).closest('tr').find('.taskType').text();
	$.ajax({
      type: "POST",
      url: '/project/executedTasks/getTaskDetails',
      data: {
        'id' : idClicked,
        'task': taskType
      },
      success: function(response) {
      		$('#myNav').css('width', 'calc(96% - 200px)');
      		$('.overlayTaskName').text(response.name);
			$('.overlayDate').text(response.start_date);
			$('.overlayUser').text(response.userName);
			$('.overlayExpertise').text(response.expertiseSigla);
			$('.overlayPhase').text(response.phaseSigla);
			if(response.subExpertiseSigla != null)
				$('.overlaySubExpertise').text(response.subExpertiseSigla);
			$('.overlayType').text(response.type);
			$('.overlayDatePicker').val(response.start_date);
			$('.summernoteOverlay').summernote('code', response.notes);

			$('.editTable .expertiseSelect option[value="0"]').prop('selected', true);
			$('.editTable .subExpertiseSelect option[value="0"]').prop('selected', true);
			$('.editTable .phaseSelect option[value="0"]').prop('selected', true);

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
})

$('.saveTask').click(function() {
	var user = $('.editTable .userSelect').val();
	var phase = $('.editTable .phaseSelect').val();
	var expertise = $('.editTable .expertiseSelect').val();
	var subExpertise = $('.editTable .subExpertiseSelect').val();
	var date = $('.editTable .overlayDatePicker').val();
	var notes = $('.summernoteOverlay').summernote('code');
	var id = idClicked;
	$.ajax({
      type: "POST",
      url: '/project/executedTasks/editTask',
      data: {
        'id' : id,
        'project_id': '{{$project->id}}',
        'user': user,
        'taskType': taskType,
        'phase': phase,
        'expertise': expertise,
        'subExpertise': subExpertise,
        'date': date,
        'notes': notes
      },
      success: function() {
        location.reload();
      }
    });
});


$( function() {
	$( ".datepicker" ).datepicker();
    $( ".datepicker" ).datepicker("option", "dateFormat",'yy-mm-dd');
});

var openedEditor = null;
var isTask = null;

$('.openTextEditor').click(function() {
	$('.notesPlace').each(function() {
		$(this).addClass('hidden');
	});
	$('.editor').addClass('hidden');
	openedEditor = $(this).attr('content');
	isTask = $(this).attr('2ndContent');
	if(isTask == 'task') {
		$('#summernoteTask' + openedEditor ).summernote({
			focus: true,
			height: 100,
			maximumImageFileSize: 65536
		});
		$('.notesPlaceTask' + openedEditor).find('.editor').removeClass('hidden');
		$('.notesPlaceTask' + openedEditor).removeClass('hidden');
	} else {
		$('#summernote' + openedEditor ).summernote({
			focus: true,
			height: 100,
			maximumImageFileSize: 65536
		});
		$('.notesPlace' + openedEditor).find('.editor').removeClass('hidden');
		$('.notesPlace' + openedEditor).removeClass('hidden');
	}
	
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
	} else if(isTask == 'task'){
		var notes = $('#summernoteTask' + openedEditor).summernote('code');
		$.ajax({
		  type: "POST",
		  url: '/project/task_timer/editNote',
		  data: {
		  	"id": openedEditor,
		  	"notes": notes,
		  },
		  success: function() {
		  	console.log();
		  }
		});
	} else {
		var notes = $('#summernote' + openedEditor).summernote('code');
		$.ajax({
		  type: "POST",
		  url: '/project/executedTasks/editNote',
		  data: {
		  	"id": openedEditor,
		  	"notes": notes,
		  },
		  success: function() {
		  }
		});
	}
	if(openedEditor != 'form') {
		if(isTask == 'task')
			$('.noteContent' + openedEditor).text(notes);
		else
			$('.noteContentExecuted' + openedEditor).text(notes);
	}
	$(this).closest('.notesPlace').addClass('hidden');
	$('.editor').addClass('hidden');
});

$('.cancelEditor').click(function() {
	$(this).closest('.notesPlace').addClass('hidden');
});

$('.addType').click(function() {
	$('.hiddenForm').removeClass('hidden');
	$('.insertForm').removeClass('hidden');
	$('.cancelForm').removeClass('hidden');
	$('.addType').addClass('hidden');
});

$('.insertForm').click(function() {
	$('#addExecutedTask').submit();
});	

$('.cancelForm').click(function() {
	$('.hiddenForm').addClass('hidden');
	$('.insertForm').addClass('hidden');
	$('.cancelForm').addClass('hidden');
	$('.addType').removeClass('hidden');
});

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

function checkType() {
	if($('.hiddenForm .typeSelect').val() == 6 || $('.hiddenForm .typeSelect').val() == 3) {
		$('.hiddenForm .inputTime').removeClass('hidden');
		if($('.hiddenForm .typeSelect').val() == 6) {
			$('.hiddenForm .phaseSelect').addClass('hidden');
			$('.hiddenForm .expertiseSelect').addClass('hidden');
			$('.hiddenForm .subExpertiseSelect').addClass('hidden');
			$('.hiddenForm .plannedTasks').removeClass('hidden');
			$('.hiddenForm .nameInput').addClass('hidden');
			$('.hiddenForm .statePercentage').removeClass('hidden');
			$('.hiddenForm .stateTypes').addClass('hidden');
		} else {
			$('.hiddenForm .plannedTasks').addClass('hidden');
			$('.hiddenForm .nameInput').removeClass('hidden');
			$('.hiddenForm .nameInput option').each(function() {
				$(this).addClass('hidden');
			});
			$('.hiddenForm .nameInput .eventType' + $('.hiddenForm .typeSelect').val()).each(function() {
				$(this).removeClass('hidden');
			});
			$('.hiddenForm .phaseSelect').removeClass('hidden');
			$('.hiddenForm .expertiseSelect').removeClass('hidden');
			$('.hiddenForm .subExpertiseSelect').removeClass('hidden');
			$('.hiddenForm .stateTypes').addClass('hidden');
		}

	} else if($('.hiddenForm .typeSelect').val() == 1) {
		$('.hiddenForm .inputTime').addClass('hidden');
		$('.hiddenForm .plannedTasks').addClass('hidden');
		$('.hiddenForm .nameInput').removeClass('hidden');
		$('.hiddenForm .statePercentage').addClass('hidden');
		$('.hiddenForm .phaseSelect').removeClass('hidden');
		$('.hiddenForm .nameInput').addClass('hidden');
		$('.hiddenForm .stateTypes').removeClass('hidden');
		$('.hiddenForm .expertiseSelect').removeClass('hidden');
		$('.hiddenForm .subExpertiseSelect').removeClass('hidden');
	} else {
		$('.hiddenForm .inputTime').addClass('hidden');
		$('.hiddenForm .stateTypes').addClass('hidden');
		$('.hiddenForm .plannedTasks').addClass('hidden');
		$('.hiddenForm .nameInput').removeClass('hidden');
		//$('.nameInput').text("");
		$('.hiddenForm .nameInput option').each(function() {
			$(this).addClass('hidden');
		});
		$('.hiddenForm .nameInput .eventType' + $('.hiddenForm .typeSelect').val()).each(function() {
			$(this).removeClass('hidden');
		});
		$('.hiddenForm .phaseSelect').removeClass('hidden');
		$('.hiddenForm .expertiseSelect').removeClass('hidden');
		$('.hiddenForm .subExpertiseSelect').removeClass('hidden');
	}
}

checkType();

$('.hiddenForm .typeSelect').change(function() {
	checkType();
});

$('.hiddenForm .expertiseSelect').change(function() {
	appendPhase();
});

function appendPhase() {
	var content = $('.hiddenForm .expertiseSelect').find(":selected").attr('content');
	var value = $('.hiddenForm .expertiseSelect').val();
	$('.hiddenForm .subExpertiseSelect .parent').each(function() {
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
	        $('.hiddenForm .phaseSelect').empty();
	        $('.hiddenForm .phaseSelect').append('<option value="0">Sem Fase</option>');
	        for(var i = 0; i < response.length; i++) {
	            $('.hiddenForm .phaseSelect').append('<option value="' + response[i].id + '">' + response[i].name + '</option>' );
	        }
	      }
	    });
	}
}

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
	        $('.editTable .phaseSelect').empty();
	        $('.editTable .phaseSelect').append('<option value="0">Sem Fase</option>');
	        for(var i = 0; i < response.length; i++) {
	            $('.editTable .phaseSelect').append('<option value="' + response[i].id + '">' + response[i].name + '</option>' );
	        }
	        if(phase_id != null)
	        	$('.editTable .phaseSelect option[value="' + phase_id + '"]').prop('selected', true);
	      }
	    });
	}
}

/* Open when someone clicks on the span element */
function openNav() {
    document.getElementById("myNav").style.width = "81.2%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
    document.getElementById("myNav").style.width = "0%";
}
</script>


@endsection