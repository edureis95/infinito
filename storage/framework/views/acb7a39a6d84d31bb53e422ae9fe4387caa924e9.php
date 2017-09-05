

<?php $__env->startSection('content'); ?>


<div class="col-xs-10" style="padding: 0%;">
	<div class="panel panel-default">
		<div class="panel-body link-nav">
			<a href="/project/<?php echo e($project->id); ?>" class="informação"> <span>Informação</span> </a>
			<a href="/project/gantt/<?php echo e($project->id); ?>" class="secondNavMargin"> <span>Gestão</span> </a>
		</div>
	</div>
	<?php echo $__env->make('layouts.project_second_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default">
		<div class="panel-body link-nav">
			<div class="col-xs-12">
				<table class="table borderless" style="width: auto;">
					<tr> 
						<?php if($project->number < 10000): ?>
							<td><b>Código:</b> 0<?php echo e($project->number); ?> <b style="padding-left: 10px;">Nome:</b> <?php echo e($project->name); ?></td>
						<?php else: ?>
							<td><b>Código:</b> 0<?php echo e($project->number); ?> <b style="padding-left: 10px;">Nome:</b> <?php echo e($project->name); ?></td>
						<?php endif; ?>
					</tr>
					<tr>
						<td><b>Designação do Projeto:</b> <?php echo e($project->title); ?></td>
					</tr>
					<tr>
						<td><b>Tipo de Projeto:</b> <?php echo e($project->typeName); ?></td>
					</tr>
					<tr>
						<td><b>Área de Construção:</b> <?php echo e($project->constructionArea); ?> m<sup>2</sup></td>
					</tr>
					<tr>
						<td><b>Área Total de Projeto:</b> <?php echo e($project->totalArea); ?> m<sup>2</sup></td>
					</tr>
					<tr>
						<td><b>Valor do Projeto:</b> <?php echo e($project->value); ?> €</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>