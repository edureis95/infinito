<?php $__env->startSection('content'); ?>


	<div class="col-md-9" style="padding: 0%; height:100%;">
		<script src="dhtmlxGantt/codebase/dhtmlxgantt.js" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" href="dhtmlxGantt/codebase/dhtmlxgantt.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<style>
			.high{
				/*display: none;*/
			}

			.weekend {
				background: #f4f7f4;
			}

			.number-teste{
				display: inline;
				margin-right: 5px;
			}


			.gantt_selected .weekend {
				background: #f7eb91;
			}

			.project {
				display: none;
			}

			.activity {
				max-height: 10px;
				margin-top: 10px;
				background-color: black;
				border-color: black;
			}

			.activity .gantt_task_progress_drag {
				display:none !important;
			}
			.activity_start_date {
			position: absolute;
			
			width: 12px;
			height: 12px;
			margin-top: 17px;
			z-index: 1;
			background: url("dhtmlxGantt/samples/04_customization/common/triangle.png") center no-repeat;
			}

			.activity_end_date {
			position: absolute;
			-ms-transform: rotate(90deg); /* IE 9 */
		    -webkit-transform: rotate(90deg); /* Chrome, Safari, Opera */
		    transform: rotate(90deg);

			width: 12px;
			height: 12px;
			margin-top: 17px;
			margin-left: -12px;
			z-index: 1;
			background: url("dhtmlxGantt/samples/04_customization/common/triangle.png") center no-repeat;
			}

		</style>
		<?php echo $__env->make('layouts.gestao_projetos_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<div class="panel panel-default">
		<div class="panel-body">
		<input type="button" class="zoom" name="scale" /><label for="zoom">Zoom in</label><br>
		<input type="button" class="zoom_out" name="scale" /><label for="zoom_out">Zoom out</label><br>
		<div id="gantt_here" style='width:100%;height: 100px;'></div>
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

			gantt.config.xml_date = "%Y-%m-%d %H:%i:%s";
			gantt.config.columns = [
			{name:"text", label:"Task name", tree:true, width:"200", resize:true, align:"left"},
			];
			gantt.config.scale_unit = "month";
			gantt.config.date_scale = "%F, %Y";
			gantt.config.subscales = [
			{unit:"day", step:1, date:"%j" }
			];
			gantt.config.scale_height = 50;
			gantt.templates.date_scale = null;
			gantt.config.min_column_width = 20;
			gantt.config.autosize = "y";
			gantt.init("gantt_here", new Date(2016,12,1), new Date(2017,1,1));


			gantt.load("./gantt_data", "xml");

			var dp = new dataProcessor("./gantt_data");
			dp.init(gantt);


			gantt.attachEvent("onBeforeTaskDisplay", function(id, task){
				
			});


			gantt.templates.grid_file = function(task) {
				var taskObj = gantt.getTask(task.parent);
			    return "<div class='gantt_tree_icon number-teste'>" + "#" + taskObj.number + "." + task.number + "</div>";
			};

			gantt.templates.grid_folder = function(task) {
				if(task.type == 1)
					return "<div class='gantt_tree_icon number-teste'>" + "#" + task.number + "</div>";
				else {
					var taskObj = gantt.getTask(task.parent);
			    	return "<div class='gantt_tree_icon number-teste'>" + "#" + taskObj.number + "." + task.number + "</div>";
				}
			};

			/*gantt.templates.scale_cell_class = function(date) {
				if(date.getDay() == 0 || date.getDay() == 6) {
					return 'weekend';
				}
			};*/

			gantt.templates.task_cell_class = function(item, date) {
				if(date.getDay() == 0 || date.getDay() == 6) {
					return 'weekend';
				}
			};

			gantt.addTaskLayer(function draw_deadline(task) {
				if (task.type == 2) {
					var el = document.createElement('div');
					el.className = 'activity_start_date';
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
					el.className = 'activity_end_date';
					var sizes = gantt.getTaskPosition(task, task.end_date);

					el.style.left = sizes.left + 'px';
					el.style.top = sizes.top + 'px';

					//el.setAttribute('title', gantt.templates.task_date(task.start_date));
					return el;
				}
				return false;
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