<div class="panel panel-default panelMenu borderless">
	<div class="panel-body link-nav">
		<span style="color:#99cc00; font-size: 20px;"><?php echo e(str_pad($project->number, 5, '0', STR_PAD_LEFT)); ?> - <?php echo e($project->name); ?></span>
		<a href="/management/project/<?php echo e($project->id); ?>" class="informação secondNavMargin"> <span>Informação</span> </a>
	</div>
</div>
<div class="row">
    <hr style="margin-top: 0; margin-left: 0; width: 100%; border-color: #DCDCDC; margin-bottom: 0;">
</div>