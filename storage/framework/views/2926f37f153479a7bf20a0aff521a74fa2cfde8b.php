<?php $__env->startSection('content'); ?>

<script type="text/javascript" src="/js/canvasjs.min.js"></script>
<div class="col-xs-12" style="max-width: 98%;">
	<?php echo $__env->make('layouts.project_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.project_management_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body" style="padding: 0;">
			<div>
				<p>Tempo de Execução: <?php echo e($task_timer_hours); ?></p>
				<p>Nº de Tarefas: <?php echo e($totalNumberTasks); ?></p>
			</div>
			<div id="taskByType" class="chart" style="float: left; height: 40%; width: 50%;"></div>
			<div id="members" class="chart" style="float: left; height: 40%; width: 50%;"></div>
			<div id="expertise" class="chart" style="float: left; height: 40%; width: 50%;"></div>
			<div id="phases" class="chart" style="float: left; height: 40%; width: 50%;"></div>
		</div>
	</div>
</div>
<style>
.canvasjs-chart-credit {
   display: none;
}
</style>

<script>

var array = [];
<?php $__currentLoopData = json_decode($pieDataTaskType); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	var object = {};
	object['y'] = <?php echo e($data); ?>;
	object['indexLabel'] = '<?php echo e($key); ?>';
	array.push(object);
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

var membersArray = [];
<?php $__currentLoopData = json_decode($pieDataMembers); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	var object = {};
	object['y'] = <?php echo e($data); ?>;
	object['indexLabel'] = '<?php echo e($key); ?>';
	membersArray.push(object);
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

var expertiseArray = [];
<?php $__currentLoopData = json_decode($pieDataExpertise); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	var object = {};
	object['y'] = <?php echo e($data); ?>;
	object['indexLabel'] = '<?php echo e($key); ?>';
	expertiseArray.push(object);
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

var phasesArray = [];
<?php $__currentLoopData = json_decode($pieDataPhases); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	var object = {};
	object['y'] = <?php echo e($data); ?>;
	object['indexLabel'] = '<?php echo e($key); ?>';
	phasesArray.push(object);
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

var chart = new CanvasJS.Chart("taskByType",
{
	title:{
		text: "Nº de Tarefas por Tipo"
	},		
	data: [
	{       
		type: "pie",
		showInLegend: true,
		indexLabel:"#percent",
		toolTipContent: "{y} - #percent %",
		legendText: "{indexLabel}",
		dataPoints: array
	}
	]
});
chart.render();

var membersChart = new CanvasJS.Chart("members",
{
	title:{
		text: "Nº de Horas por Colaborador"
	},		
	data: [
	{       
		type: "pie",
		showInLegend: true,
		toolTipContent: "{y} h - #percent %",
		legendText: "{indexLabel}",
		dataPoints: membersArray
	}
	]
});
membersChart.render();

var expertiseChart = new CanvasJS.Chart("expertise",
{
	title:{
		text: "Nº de Horas por Especialidade"
	},		
	data: [
	{       
		type: "pie",
		showInLegend: true,
		toolTipContent: "{y} h - #percent %",
		legendText: "{indexLabel}",
		dataPoints: expertiseArray
	}
	]
});
expertiseChart.render();

var phasesChart = new CanvasJS.Chart("phases",
{
	title:{
		text: "Nº de Horas por Fase"
	},		
	data: [
	{       
		type: "pie",
		showInLegend: true,
		toolTipContent: "{y} h - #percent %",
		legendText: "{indexLabel}",
		dataPoints: phasesArray
	}
	]
});
phasesChart.render();

</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>