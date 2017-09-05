<div class="panel panel-default">
	<div class="panel-body link-nav">
		<a href="/project/<?php echo e($project->id); ?>" class="informações"> <span>Informações</span> </a>
		<a href="/project/team/<?php echo e($project->id); ?>" class="secondNavMargin equipa"> <span>Equipa</span> </a>
		<a href="/project/expertise/<?php echo e($project->id); ?>" class="secondNavMargin especialidades"> <span>Especialidades</span> </a>
		<a href="/project/phases/<?php echo e($project->id); ?>" class="secondNavMargin fases"> <span>Fases</span> </a>
		<a href="/project/<?php echo e($project->id); ?>/planning" class="secondNavMargin planeamento"> <span>Planeamento</span> </a>
	</div>
</div>