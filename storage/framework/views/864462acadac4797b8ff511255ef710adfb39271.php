<?php $__env->startSection('content'); ?>
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
							<?php $__currentLoopData = $usersList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($user->id); ?>"><?php echo e($user->sigla); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
								<?php $__currentLoopData = $eventTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
							</select>
	  					</td>
	  				</tr>
	  				<tr>
		  				<td class="text-right"> <b>Especialidade: </b></td>
		  				<td class="">
		  					<select name="expertise" class="input-sm form-control expertiseSelect">
								<option value="0">Sem Especialidade</option>
								<?php $__currentLoopData = $expertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option content="<?php echo e($expert->proj_e_id); ?>" value="<?php echo e($expert->id); ?>"><?php echo e($expert->name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
		  				</td>
		  				<td class="text-right"> <b>Sub-Especialidade: </b></td>
		  				<td class="">
		  					<select name="subExpertise" class="input-sm form-control subExpertiseSelect">
								<option value="0">Sem Sub-especialidade</option>
								<?php $__currentLoopData = $subExpertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option class="hidden parent parent<?php echo e($expert->parent); ?>" value="<?php echo e($expert->id); ?>"><?php echo e($expert->name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
				<button type="button" class="btn btn-danger pull-right removeTask" style="margin-right: 10px;">Eliminar Tarefa</button>
			</div>
  		</div>
  	</div>
  </div>

</div>
	<div class="col-xs-12 insideContainer">
	<script src="/dhtmlxGantt/codebase/dhtmlxgantt.js" type="text/javascript" charset="utf-8"></script>
	<script src="/dhtmlxGantt/codebase/locale/locale_pt.js" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" href="/dhtmlxGantt/codebase/dhtmlxgantt.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<style>
			.openTaskLayer .gantt_tree_content{
				color: blue;
				cursor: pointer; 
   				cursor: hand; 
			}
			.high{
				/*display: none;*/
			}

			.weekend {
				background: lightgrey;
			}

			.companyDay {
				background: #e4e4e4;
			}

			.today {
				background: #FF5050;
			}

			.number-teste{
				display: inline;
			}

			.projectGantt {
				font-weight: bold;
			}

			.boldLetters {
				font-weight: bold;
			}

			.gantt_selected .weekend {
				background: #f7eb91;
			}

			.gantt_tree_indent {
				width: 5;
			}

			.commercial {
				display: none;
			}

			.executed {
				border: none !important;
			}

			.project {
				max-height: 5px;
				background-color: black;
				border-color: grey;
			}

			.project .gantt_task_progress_drag {
				display:none !important;
			}


			.task-badProgress-good .gantt_task_progress_drag {
				display: none !important;
			}

			.task-badProgress-good .gantt_task_progress {
				background-color: #FF5050;
			}

			.task-badProgress-good {
				background-color: green;
				border: none !important;
			}

			.task-badProgress-medium .gantt_task_progress_drag {
				display: none !important;
			}

			.task-badProgress-medium .gantt_task_progress {
				background-color: #FF5050;
			}

			.task-badProgress-medium {
				background-color: orange;
				border: none !important;
			}

			.task-badProgress-bad {
				background-color: red;
				border: none !important;
			}

			.task-badProgress-bad .gantt_task_progress {
				background-color: #FF5050;
			}

			.task-badProgress-bad .gantt_task_progress_drag {
				display: none !important;
			}

			.task-mediumProgress-good {
				background-color: green;
				border: none !important;
			}

			.task-mediumProgress-good .gantt_task_progress {
				background-color: #FFEB46;
			}

			.task-mediumProgress-good .gantt_task_progress_drag {
				display: none !important;
			}

			.task-mediumProgress-medium {
				background-color: orange;
				border: none !important;
			}

			.task-mediumProgress-medium .gantt_task_progress {
				background-color: #FFEB46;
			}

			.task-mediumProgress-medium .gantt_task_progress_drag {
				display:none !important;
			}

			.task-mediumProgress-bad {
				background-color: red;
				border: none !important;
			}

			.task-mediumProgress-bad .gantt_task_progress {
				background-color: #FFEB46;
			}

			.task-mediumProgress-bad .gantt_task_progress_drag {
				display: none !important;
			}

			.task-goodProgress-good {
				background-color: green;
				border: none !important;
			}

			.task-goodProgress-good .gantt_task_progress {
				background-color: #50D050;
			}

			.task-goodProgress-good .gantt_task_progress_drag {
				display: none !important;
			}

			.task-goodProgress-medium {
				background-color: orange;
				border: none !important;
			}

			.task-goodProgress-medium .gantt_task_progress {
				background-color: #50D050;
			}

			.task-goodProgress-medium .gantt_task_progress_drag {
				display: none !important;
			}

			.task-goodProgress-bad {
				background-color: red;
				border: none !important;
			}

			.task-goodProgress-bad .gantt_task_progress {
				background-color: #50D050;
			}

			.task-goodProgress-bad .gantt_task_progress_drag {
				display: none !important;
			}

			.executed .gantt_task_progress_drag {
				display: none !important;
			}

			.project_start_date {
				position: absolute;

				width: 12px;
				height: 12px;
				margin-top: 17px;
				z-index: 1;
				background: url("/dhtmlxGantt/samples/04_customization/common/triangle.png") center no-repeat;
			}

			.project_end_date {
				position: absolute;
				-ms-transform: rotate(90deg); /* IE 9 */
				-webkit-transform: rotate(90deg); /* Chrome, Safari, Opera */
				transform: rotate(90deg);

				width: 12px;
				height: 12px;
				margin-top: 17px;
				margin-left: -12px;
				z-index: 1;
				background: url("/dhtmlxGantt/samples/04_customization/common/triangle.png") center no-repeat;
			}

			.milestone {
				background: url('/images/losango.png') center no-repeat;
				background-size: 20px;
				border: none;
			}

			.milestone .gantt_task_progress_drag {
				display: none !important;
			}

			.activity {
				max-height: 5px;
				background-color: grey;
				border: none !important;
			}

			.activity .gantt_task_progress_drag {
				display:none !important;
			}
			.activity_start_date {
				position: absolute;
				margin-top: 6px;
				width: 0px;
				height: 0px;
				border-top: 12px solid grey;
				border-right: 12px solid transparent;
				z-index: 0;
			}

			.activity_end_date {
				position: absolute;
			    margin-top: 6px;
				width: 0px;
				height: 0px;
				margin-left: -12px;
				z-index: 0;
				border-top: 12px solid grey;
				border-left: 12px solid transparent;
			}

			.light-activity {
				max-height: 5px;
				background-color: #bdbdbd;
				border: none !important;
			}

			.light-activity .gantt_task_progress_drag {
				display:none !important;
			}
			.light-activity_start_date {
				position: absolute;
				margin-top: 6px;
				width: 0px;
				height: 0px;
				border-top: 12px solid #bdbdbd;
				border-right: 12px solid transparent;
				z-index: 0;
			}

			.light-activity_end_date {
				position: absolute;
			    margin-top: 6px;
				width: 0px;
				height: 0px;
				margin-left: -12px;
				z-index: 0;
				border-top: 12px solid #bdbdbd;
				border-left: 12px solid transparent;
			}
			

			.gantt_side_content.gantt_right {
			    bottom: 1.5;
			}

		</style>
		<?php echo $__env->make('layouts.project_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php echo $__env->make('layouts.project_management_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<div class="clearfix">
			<button type="button" style="float:left;" class="zoom btn btn-default" name="scale"><i class="glyphicon glyphicon-zoom-in"></i></button>
			<button type="button" style="float:left;" class="zoom_out btn btn-default" name="scale"><i class="glyphicon glyphicon-zoom-out"></i></button>
			<div class="dropdown" style="float: right; margin-right: 2%;">
				<button class="dropdown-toggle btn btn-primary" data-toggle="dropdown">
					<i class="glyphicon"></i>Filtro
				</button>
				<ul class="dropdown-menu dropdown-form pull-right" style="width: 500% !important;">
	                <li>
	                	<table class="borderless">
	                		<tr>
	                		<td>Planeamento</td>
	                		<td>Executado</td>
	                		</tr>
	                		<tr>
		                		<td>
		                			<input type="checkbox" checked class="ganttCheckbox plannedHideDone">Ocultar Concluídas
		                		</td>
		                		<td>
		                			<input type="checkbox" class="ganttCheckbox">Ocultar Concluídas
		                		</td>
	                		</tr>
	                		<tr>
		                		<td>
		                			<input type="checkbox" checked class="ganttCheckbox plannedTasksCheckbox">Tarefas
		                		</td>
		                		<td>
		                			<input type="checkbox" class="ganttCheckbox">Tarefas
		                		</td>
	                		</tr>
	                		<tr>
		                		<td>
		                			<input type="checkbox" class="ganttCheckbox">Reuniões/Outras
		                		</td>
		                		<td>
		                			<input type="checkbox" class="ganttCheckbox">Reuniões/Outras
		                		</td>
	                		</tr>
	                		<tr>
		                		<td>
		                			<input type="checkbox" class="ganttCheckbox">Entregas
		                		</td>
		                		<td>
		                			<input type="checkbox" class="ganttCheckbox">Entregas
		                		</td>
	                		</tr>
	                		<tr>
		                		<td>
		                			<input type="checkbox" class="ganttCheckbox">Comunicações
		                		</td>
		                		<td>
		                			<input type="checkbox" class="ganttCheckbox">Comunicações
		                		</td>
	                		</tr>
	                	</table>
	                </li>   
	            </ul>
			</div>
		</div>
		<div class="panel panel-default borderless">
		<div class="panel-body" style="padding-left: 0; padding-top: 0;">
		<div id="gantt_here" style='width:100%;min-height: 200px;'></div>
		</div>
		</div>

		<script type="text/javascript">

		function closeNav() {
		    document.getElementById("myNav").style.width = "0%";
		}

		var task_id = null;
		$(document).ready(function() {
			$(document).on('click', '.gantt_tree_content', function() {
				task_id = $(this).parent().parent().attr('task_id');
				if(	gantt.getTask(task_id).type == 0) {
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
				      url: '/project/gantt/getPlannedTaskDetails',
				      data: {
				        'id' : task_id
				      },
				      success: function(response) {
				      		$('#myNav').css('width', 'calc(96% - 170px)');
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
				}
			});

			$('.saveTask').click(function() {
				var user = $('.editTable .userSelect').val();
				var phase = $('.editTable .phaseOptions').val();
				var expertise = $('.editTable .expertiseSelect').val();
				var subExpertise = $('.editTable .subExpertiseSelect').val();
				var start_date = $('.editTable .overlayStartDatePicker').val();
				var end_date = $('.editTable .overlayEndDatePicker').val();
				var notes = $('.summernoteOverlay').summernote('code');
				$.ajax({
			      type: "POST",
			      url: '/project/gantt/editPlannedTaskFromGantt',
			      data: {
			        'id' : task_id,
			        'project_id': '<?php echo e($project->id); ?>',
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

			$('.summernoteOverlay').summernote({
				height: 100,
				maximumImageFileSize: 65536
			});
			$('.note-editor').css('font-family', 'Arial');
			$('.summernoteOverlay').summernote('disable');
			$('.note-toolbar').addClass('hidden');

			$('.editDescriptionButton').click(function() {
				$(this).addClass('hidden');
				$('.cancelEditDescription').removeClass('hidden');
				$('.editTable').removeClass('hidden');
				$('.descriptionTable').addClass('hidden');
				$('.summernoteOverlay').summernote('enable');
				$('.note-toolbar').removeClass('hidden');
			});

			$('.cancelEditDescription').click(function() {
				$(this).addClass('hidden');
				$('.editDescriptionButton').removeClass('hidden');
				$('.editTable').addClass('hidden');
				$('.descriptionTable').removeClass('hidden');
				$('.summernoteOverlay').summernote('disable');
				$('.note-toolbar').addClass('hidden');
			});

			$('.ganttCheckbox').change(function() {
				gantt.refreshData();
			});

			$('.removeTask').click(function() {
				var txt;
				var r = confirm("Tem a certeza que quer eliminar esta tarefa? (As tarefas executadas associadas a esta tarefa também serão apagadas)");
				if (r == true) {
					$.ajax({
				      type: "POST",
				      url: '/removeProjectTask',
				      data: {
				        'id' : task_id
				      },
				      success: function() {
				        location.reload();
				      }
				    });
				} else {
				   
				}
			})
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

		$( function() {
			$( ".datepicker" ).datepicker();
		    $( ".datepicker" ).datepicker("option", "dateFormat",'yy-mm-dd');
		});


			function setScaleConfig(value){
				switch (value) {
					case "1":
					gantt.config.scale_unit = "year";
					gantt.config.step = 1;
					gantt.config.date_scale = "%Y";
					gantt.config.min_column_width = 50;

					gantt.config.scale_height = 90;
					gantt.templates.date_scale = null;

					gantt.config.subscales = [
					{unit:"month", step:4, date:"%F" }
					];
					gantt.config.start_date = new Date(2016,12,1);
					gantt.config.end_date = new Date(2019,12,1);

					gantt.templates.task_cell_class = function(item, date) {
						if(date.getDay() == 0 || date.getDay() == 6) {
							return '0';
						}
					};
					break;
					case "2":
					gantt.config.scale_unit = "year";
					gantt.config.step = 1;
					gantt.config.date_scale = "%Y";
					gantt.config.min_column_width = 50;

					gantt.config.scale_height = 90;
					gantt.templates.date_scale = null;

					gantt.config.subscales = [
					{unit:"month", step:1, date:"%M" }
					];
					gantt.config.start_date = new Date(2016,12,1);
					gantt.config.end_date = new Date(2019,12,1);

					gantt.templates.task_cell_class = function(item, date) {
						if(date.getDay() == 0 || date.getDay() == 6) {
							return '0';
						}
					};
					break;
					case "3":
					gantt.config.scale_unit = "month";
					gantt.config.date_scale = "%F, %Y";
					gantt.config.subscales = [
					{unit:"day", step:1, date:"%j" }
					];
					gantt.config.scale_height = 50;
					gantt.templates.date_scale = null;
					gantt.config.min_column_width = 20;
					gantt.config.start_date = new Date(2016,12,1);
					gantt.config.end_date = new Date(2017,12,1);
					gantt.templates.task_cell_class = function(item, date) {
						if(date.getDay() == 0 || date.getDay() == 6) {
							return 'weekend';
						}
					};
					break;
					case "4":
					gantt.config.scale_unit = "month";
					gantt.config.date_scale = "%F, %Y";
					gantt.config.subscales = [
					{unit:"day", step:1, date:"%j" }
					];
					gantt.config.scale_height = 50;
					gantt.templates.date_scale = null;
					gantt.config.min_column_width = 40;
					gantt.config.start_date = new Date(2016,12,1);
					gantt.config.end_date = new Date(2017,12,1);
					break;
					case "5":
					gantt.config.scale_unit = "month";
					gantt.config.date_scale = "%F, %Y";
					gantt.config.subscales = [
					{unit:"day", step:1, date:"%D" }
					];
					gantt.config.scale_height = 50;
					gantt.templates.date_scale = null;
					gantt.config.min_column_width = 50;
					gantt.config.start_date = new Date(2016,12,1);
					gantt.config.end_date = new Date(2017,12,1);
					gantt.templates.task_cell_class = function(item, date) {
						if(date.getDay() == 0 || date.getDay() == 6) {
							return 'weekend';
						}
					};
					break;
					case "6":
					gantt.config.scale_unit = "day";
					gantt.config.date_scale = "%j, %M";
					gantt.config.subscales = [
					{unit:"hour", step:6, date:"%H:00" }
					];
					gantt.config.scale_height = 50;
					gantt.templates.date_scale = null;
					gantt.config.min_column_width = 50;
					gantt.config.start_date = new Date(2016,12,1);
					gantt.config.end_date = new Date(2017,12,1);
					gantt.templates.task_cell_class = function(item, date) {
						if(date.getDay() == 0 || date.getDay() == 6) {
							return 'weekend';
						}
					};
					break;
				}
			}


			gantt.templates.task_text = function(start, end, task) {
				if(task.milestone == 1) {
					return "";
				} else if(task.type == 1)
					return ""; 
				else if(task.type == 2)
					return "";
				else if(task.type == 4 || task.type == 5 || task.type == 6)
					return "";
				else {
					return task.text;
				}
			};

			//Fit text
			(function(){
				gantt.config.font_width_ratio = 9;
				gantt.templates.leftside_text = function leftSideTextTemplate(start, end, task) {
					if (getTaskFitValue(task) === "left" && (task.type == 0 || task.type == 3)) {
						if(task.u_sigla != "")
							return task.u_sigla;
						else 
							return task.text;
					}
					return "";
				};
				gantt.templates.rightside_text = function rightSideTextTemplate(start, end, task) {
					if (getTaskFitValue(task) === "right" && (task.type == 0 || task.type == 3)) {
						if(task.u_sigla != "")
							return task.u_sigla;
						else 
							return task.text;
					}
					return "";
				};
				gantt.templates.task_text = function taskTextTemplate(start, end, task){
					if (getTaskFitValue(task) === "center" && (task.type == 0 || task.type == 3)) {
						if(task.u_sigla != "")
							return task.u_sigla;
						else 
							return task.text;
					}
					return "";
				};

				function getTaskFitValue(task){
					var taskStartPos = gantt.posFromDate(task.start_date),
						taskEndPos = gantt.posFromDate(task.end_date);

					var width = taskEndPos - taskStartPos;
					var textWidth = (task.text + task.u_sigla || "").length * gantt.config.font_width_ratio;

					if(width < textWidth){
						var ganttLastDate = gantt.getState().max_date;
						var ganttEndPos = gantt.posFromDate(ganttLastDate);
						if(ganttEndPos - taskEndPos < textWidth){
							return "left"
						}
						else {
							return "right"
						}
					}
					else {
						return "right";
					}
				}
			})();

			gantt.config.xml_date = "%Y-%m-%d %H:%i:%s";
			gantt.config.columns = [
			{name:"text", label:"Gantt", tree:true, width:"400", resize:true, align:"left"},
			];
			gantt.config.scale_unit = "month";
			gantt.config.date_scale = "%F, %Y";
			gantt.config.subscales = [
			{unit:"day", step:1, date:"%j" }
			];
			gantt.config.scale_height = 50;
			gantt.config.row_height = 22;
			gantt.config.task_height = 10;
			gantt.templates.date_scale = null;
			gantt.config.min_column_width = 20;
			gantt.config.autosize = "y";
			gantt.config.duration_unit = "hour";
			var previousDate = new Date();
			previousDate.setMonth(previousDate.getMonth() - 4);
			var futureDate = new Date();
			futureDate.setMonth(futureDate.getMonth() + 4);
			gantt.init("gantt_here", previousDate, futureDate);
			gantt.showDate(new Date());

			gantt.attachEvent("onBeforeTaskDisplay", function(id, task){
				//Filters
				if(task.type == 0 && task.milestone == 0 && !$('.plannedTasksCheckbox').is(':checked'))
					return false;
				if(task.progress == 1 && $('.plannedHideDone').is(':checked'))
					return false;

				if(task.type == 4) {
					return true;
				} else if(task.type == 5) {
					return true;
				} else if(task.type == 6) {
					return true;
				} 
				else if(task.type == 2){

					if((task.parent == <?php echo e($project->commercial_project_Task_ID); ?> || task.parent == <?php echo e($project->operational_project_Task_ID); ?> || task.parent == <?php echo e($project->plannedTask_id); ?>) && gantt.hasChild(id)) {
						if(gantt.getTask(gantt.getChildren(id)[0]).type == 2) {
							if(gantt.hasChild(gantt.getChildren(id)[0]))
								return true;
							else
								return false;
						}
						else if(gantt.getTask(gantt.getChildren(id)[0]).type == 1)
							return true;
					}
					else if((gantt.getParent(task.parent) == <?php echo e($project->commercial_project_Task_ID); ?> || gantt.getParent(task.parent) == <?php echo e($project->operational_project_Task_ID); ?> || gantt.getParent(task.parent) == <?php echo e($project->plannedTask_id); ?>) && gantt.hasChild(id))
						return true;
					else
						return false;

					return true;
				} else if(task.type == 0  || task.type == 3 || task.type == 7) {
					if((task.parent == <?php echo e($project->commercial_project_Task_ID); ?> || task.parent == <?php echo e($project->operational_project_Task_ID); ?> || task.parent == <?php echo e($project->plannedTask_id); ?>)) {
							return true;
					} else {
						var parent1 = gantt.getParent(task.parent);
						if(parent1.type == 0 || parent1.type == 3 || parent1.type == 7)
							return false;
						if((parent1 == <?php echo e($project->commercial_project_Task_ID); ?> || parent1 == <?php echo e($project->operational_project_Task_ID); ?> || parent1 == <?php echo e($project->plannedTask_id); ?>)) {
								return true;
						}
						else {
							var parent2 = gantt.getParent(parent1);
							if(parent2.type == 0 || parent2.type == 3 || parent2.type == 7)
								return false;
							if((parent2 == <?php echo e($project->commercial_project_Task_ID); ?> || parent2 == <?php echo e($project->operational_project_Task_ID); ?> || parent2 == <?php echo e($project->plannedTask_id); ?>)) {
									return true;
							}
						}
					}
				}

				return false;
			});

			var task_list = [];

			<?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			    task_list.push('<?php echo e($task); ?>');
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

			gantt.attachEvent("onBeforeTaskDisplay", function(id, task){
				if(task_list.indexOf(task.id) != -1)
					return true;
				else 
					return false;
			});

			gantt.attachEvent("onAfterTaskDrag", function(id, mode, e){
				var task = gantt.getTask(id);
				if(task.type == 0) {
					var end_date = task.end_date;
					var start_date = task.start_date;
					var start_date_month = start_date.getMonth() + 1;
					var end_date_month = end_date.getMonth() + 1;
					start_date = start_date.getFullYear() + "-" + start_date_month + "-" + start_date.getDate();
					end_date = end_date.getFullYear() + "-" + end_date_month + "-" + end_date.getDate();
					$.ajax({
					  type: "POST",
					  url: '/project/gantt/editTaskTime',
					  data: {
					  	'task_id': id,
					  	'start_date': start_date,
					  	'end_date': end_date
					  },
					  success: function() {
					  }
					});
				}
			});

			gantt.attachEvent("onBeforeTaskUpdate", function(id,new_item){
				var task = gantt.getTask(id);
			    if(task.type == 0)
			    	return true;
			   	else 
			   		return false;
			});

			gantt.load("../../gantt_data", "xml");

			gantt.attachEvent('onBeforeLightbox', function(id) {
				var task = gantt.getTask(id);
				/*if(task.milestone == 1)
					return false;
				return true;*/

				return false;
			});

			var dp = new dataProcessor("../../gantt_data");
			dp.init(gantt);

			gantt.templates.task_class  = function(start, end, task){
				var currentDate = new Date();
				if(task.type == 4 || task.type == 5 || task.type == 6)
					return 'commercial';
				else if(task.type == 1) {
					return 'project';
				}
				else if(task.type == 2) {
					if(gantt.getTask(task.parent).type == 1)
						return 'activity';
					else
						return "light-activity";
				}
				if(task.milestone == 1) {
					return 'milestone';
				}
				if(task.type == 3) {
					return 'executed';
				} else if(task.type == 0)
					if(task.progress < 0.25) {
						if(start > currentDate)
							return 'task-badProgress-good';
						else if(currentDate >= start && currentDate <= end)
							return 'task-badProgress-medium'
						else
							return 'task-badProgress-bad';
					}
					else if(task.progress < 0.75) {
						if(start > currentDate)
							return 'task-mediumProgress-good';
						else if(currentDate >= start && currentDate <= end)
							return 'task-mediumProgress-medium'
						else
							return 'task-mediumProgress-bad';
					}
					else {
						if(start > currentDate)
							return 'task-goodProgress-good';
						else if(currentDate >= start && currentDate <= end)
							return 'task-goodProgress-medium'
						else
							return 'task-goodProgress-bad';
					}
			};

			gantt.templates.grid_file = function(task) {
				if(task.u_sigla != "")
			    	return "<div class='gantt_tree_icon number-teste'>" + task.u_sigla + ' - ' + "</div>";
			    else
			    	return "<div class='gantt_tree_icon number-teste'>" + "</div>";
			};

			gantt.templates.grid_folder = function(task) {
				var pad = "00000";
				if(task.type == 4 || task.type == 5 || task.type == 6)
					return "<div class='gantt_tree_icon number-teste'>" + "</div>";
				else if(task.type == 1)
					return "<div class='gantt_tree_icon number-teste projectGantt'>" + pad.substring(0, pad.length - task.number.length) + task.number + " | " + "</div>";
				else {
					var taskObj = gantt.getTask(task.parent);
			    	return "<div class='gantt_tree_icon number-teste'>" + "</div>";
				}
			};

			gantt.templates.grid_row_class = function(start, end, task){
				if(task.type == 4 || task.type == 5 || task.type == 6)
			    	return "boldLetters";
			    if(task.type == 0)
			    	return 'openTaskLayer';
			};

			gantt.templates.task_cell_class = function(item, date) {
				var currentDate = new Date();
				var month = date.getMonth() + 1;
				<?php $__currentLoopData = $companyDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					if('<?php echo e($day->start_date); ?>' == (date.getFullYear() + '-' + ("0" + month).slice(-2) + '-' + ("0" + date.getDate()).slice(-2))) {
						return 'companyDay';
					}
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				if(date.getDate() == currentDate.getDate() && date.getMonth() == currentDate.getMonth() && date.getFullYear() == currentDate.getFullYear()) {
					return 'today';
				}
				if(date.getDay() == 0 || date.getDay() == 6) {
					return 'weekend';
				}
			};

			gantt.addTaskLayer(function draw_deadline(task) {
				if (task.type == 2) {
					var el = document.createElement('div');
					if(gantt.getTask(task.parent).type == 1)
						el.className = 'activity_start_date';
					else
						el.className = 'light-activity_start_date';
					var sizes = gantt.getTaskPosition(task, task.start_date);

					el.style.left = sizes.left + 'px';
					el.style.top = sizes.top + 'px';

					//el.setAttribute('title', gantt.templates.task_date(task.start_date));
					return el;
				}
				return false;
			});

			gantt.addTaskLayer(function draw_deadline(task) {
				if (task.type == 2) {
					var el = document.createElement('div');
					if(gantt.getTask(task.parent).type == 1)
						el.className = 'activity_end_date';
					else
						el.className = 'light-activity_end_date';
					var sizes = gantt.getTaskPosition(task, task.end_date);

					el.style.left = sizes.left + 'px';
					el.style.top = sizes.top + 'px';

					//el.setAttribute('title', gantt.templates.task_date(task.start_date));
					return el;
				}
				return false;
			});

			gantt.attachEvent("onGanttRender", function(){
			    var timeout = setTimeout(function(){
					gantt.showDate(new Date());
				}, 200);
			});

			var func = function(e) {
				e = e || window.event;
				var el = e.target || e.srcElement;
				var value = el.value;
				setScaleConfig(value);
				gantt.render();
			};

			var zoom = 3;

			$('.zoom').click(function(event) {
				zoom++;
				setScaleConfig("" + zoom);
				gantt.render();
			});

			$('.zoom_out').click(function(event) {
				zoom--;
				setScaleConfig("" + zoom);
				gantt.render();
			});
					
				</script>
			</div>

		<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>