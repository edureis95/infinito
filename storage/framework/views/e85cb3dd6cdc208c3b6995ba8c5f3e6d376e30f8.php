<?php $__env->startSection('content'); ?>


	<div class="col-xs-12" style="max-width: 98%;">
		<script src="dhtmlxGantt/codebase/dhtmlxgantt.js" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" href="dhtmlxGantt/codebase/dhtmlxgantt.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<style>

			.gantt_task_link.link .gantt_line_wrapper div{
				background-color: red;
			}
			.gantt_task_link.link:hover .gantt_line_wrapper div{
				box-shadow: 0 0 5px 0px #7576ba;
			}

			.gantt_task_link.link .gantt_link_arrow_right{
				border-left-color: red;
			}

			
			.high{
				/*display: none;*/
			}

			.weekend {
				background: lightgrey;
			}

			.companyDay {
				background: lightgreen;
			}

			.today {
				background: lightblue;
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
		<?php echo $__env->make('layouts.gestao_projetos_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<div class="panel panel-default borderless">
		<div class="panel-body" style="padding: 0;">
		<div class="clearfix">
			<button type="button" style="float:left;" class="zoom btn btn-default" name="scale"><i class="glyphicon glyphicon-zoom-in"></i></button>
			<button type="button" style="float:left;" class="zoom_out btn btn-default" name="scale"><i class="glyphicon glyphicon-zoom-out"></i></button>
		</div>
		<div id="gantt_here" style='width:100%;min-height: 200px;'></div>
		</div>
		</div>

		<script type="text/javascript">
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
			function showDate(date){
			   var date_x = gantt.posFromDate(date);
			   var scroll_to = Math.max(date_x - gantt.config.task_scroll_offset, 0);
			   gantt.scrollTo(scroll_to);
			};


			gantt.templates.task_text = function(start, end, task) {
				if(task.milestone == 1) {
					return "";
				} else return task.text;
			};

			//Fit text
			(function(){
				gantt.config.font_width_ratio = 9;
				gantt.templates.leftside_text = function leftSideTextTemplate(start, end, task) {
					if (getTaskFitValue(task) === "left" && (task.type == 0 || task.type == 3)) {
						if(task.responsible != "")
							return task.responsible + ' - ' + task.text;
						else 
							return task.text;
					}
					return "";
				};
				gantt.templates.rightside_text = function rightSideTextTemplate(start, end, task) {
					if (getTaskFitValue(task) === "right" && (task.type == 0 || task.type == 3)) {
						if(task.responsible != "")
							return task.responsible + ' - ' + task.text;
						else 
							return task.text;
					}
					return "";
				};
				gantt.templates.task_text = function taskTextTemplate(start, end, task){
					if (getTaskFitValue(task) === "center" && (task.type == 0 || task.type == 3)) {
						if(task.responsible != "")
							return task.responsible + ' - ' + task.text;
						else 
							return task.text;
					}
					return "";
				};

				function getTaskFitValue(task){
					var taskStartPos = gantt.posFromDate(task.start_date),
						taskEndPos = gantt.posFromDate(task.end_date);

					var width = taskEndPos - taskStartPos;
					var textWidth = (task.text + task.responsible || "").length * gantt.config.font_width_ratio;

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
						return "center";
					}
				}
			})();

			gantt.config.xml_date = "%Y-%m-%d %H:%i:%s";
			gantt.config.row_height = 28;
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
				if(task.progress == 1)
					return false;
				if(task.parent != 0) {
					var taskTemp = gantt.getTask(task.parent);
					if(taskTemp.type == 5)
						return false;

					if(taskTemp.parent != 0) {
						taskTemp = gantt.getTask(taskTemp.parent);
						if(taskTemp.type == 5)
							return false;

						if(taskTemp.parent != 0) {
							taskTemp = gantt.getTask(taskTemp.parent);
							if(taskTemp.type == 5)
								return false;
						}
					}
				}

				if(task.type == 1) {
					if(gantt.hasChild(id)) {
							var children = gantt.getChildren(id);
							for(var i = 0; i < children.length; i++) {
								var child = gantt.getTask(children[i]);
								if(child.type == 0)
									return true;
								else if(gantt.hasChild(child.id)) {
									var children2 = gantt.getChildren(child.id);
									for(var i = 0; i < children2.length; i++) {
										var child2 = gantt.getTask(children2[i]);
										if(child2.type == 0 || gantt.hasChild(child2.id))
											return true;
									}
								}
							}
							return false;
					} else return false;
				}
				else if(task.type == 2) {
					if(gantt.hasChild(id)) {
						var children = gantt.getChildren(id);
							for(var i = 0; i < children.length; i++) {
								var child = gantt.getTask(children[i]);
								if(child.type == 0 || gantt.hasChild(child.id))
									return true;
							}
							return false;
					} else {
						return false;
					}
				}
				else if(task.type == 0)
					return true;
			});

			var task_list = [];

			<?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			    task_list.push('<?php echo e($task); ?>');
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

			
			gantt.load("./gantt_data", 'xml');

			gantt.attachEvent('onBeforeLightbox', function(id) {
				var task = gantt.getTask(id);
				/*if(task.milestone == 1)
					return false;
				return true;*/

				return false;
			});

			var dp = new dataProcessor("./gantt_data");
			dp.init(gantt);

			gantt.templates.link_class = function(link){
			    return "link";
			};

			gantt.templates.task_class  = function(start, end, task){
				var currentDate = new Date();
				if(task.type == 4 || task.type == 5)
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

			gantt.templates.grid_file = function(task) {
				if(task.responsible != "")
			    	return "<div class='gantt_tree_icon number-teste'>" + task.responsible + ' - ' + "</div>";
			    else
			    	return "<div class='gantt_tree_icon number-teste'>" + task.id + "</div>";
			};


			gantt.templates.grid_folder = function(task) {
				var pad = "00000";
				if(task.type == 4 || task.type == 5)
					return "<div class='gantt_tree_icon number-teste'>" + "</div>";
				else if(task.type == 1)
					return "<div class='gantt_tree_icon number-teste projectGantt'>" + pad.substring(0, pad.length - task.number.length) + task.number + " | " + "</div>";
				else {
					var taskObj = gantt.getTask(task.parent);
			    	return "<div class='gantt_tree_icon number-teste'>" + "</div>";
				}
			};

			gantt.templates.grid_row_class = function(start, end, task){
				if(task.type == 4 || task.type == 5 || task.type == 1)
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
				}, 100);
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