<div class="panel panel-default secondPanelMenu borderless">
	<div class="panel-body link-nav">
		<a href="/project/gantt/<?php echo e($project->id); ?>" class="gantt secondNavMargin"> <span>Gantt</span> </a>
		<a href="/project/tasks/<?php echo e($project->id); ?>" class="secondNavMargin planeamento"> <span>Planeamento</span> </a>
		<a href="/project/executedTasks/<?php echo e($project->id); ?>" class="secondNavMargin tarefasExecutadas"><span>Executado</span></a>
		<a href="/project/report/<?php echo e($project->id); ?>" class="secondNavMargin relatório"><span>Relatório</span></a>
	</div>
</div>
<div class="row">
    <hr style="margin-top: 0; margin-left: 0; width: 100%;">
</div>