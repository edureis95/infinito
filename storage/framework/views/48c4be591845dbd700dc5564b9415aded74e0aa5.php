<div class="col-md-3" >
	<div class="row">
		<div class="col-md-12">
			<a href="/project/<?php echo e($project->id); ?>" class="btn btn-info" style="width: 100%;" role="button">Página Projeto</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12" style="padding-top: 5%;">
			<a href="/project/<?php echo e($project->id); ?>/properties" class="btn btn-info" style="width: 100%;" role="button">Propriedades</a>
		</div>
	</div>
	<div class="row" style="padding-top: 5%;">
		<div class="col-md-12">
		<a href="/project/<?php echo e($project->id); ?>/gantt" class="btn btn-info" style="width: 100%;" role="button">Tarefas</a>
		</div>
	</div>
	<div class="row" style="padding-top: 5%;">
		<div class="col-md-12">
			<a href="/task/new" class="btn btn-info" style="width: 100%;" role="button">Adicionar Tarefa</a>
		</div>
	</div>
	<div class="row" style="padding-top: 5%;">
		<div class="col-md-12">
			<a href="/activity/new" class="btn btn-info" style="width: 100%;" role="button">Adicionar Atividade</a>
		</div>
	</div>
</div>