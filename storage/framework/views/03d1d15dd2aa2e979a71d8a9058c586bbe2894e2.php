<?php $__env->startSection('content'); ?>

	<div class="col-md-6" style="padding: 0%;">
		<div class="panel panel-default">
			<div class="panel-heading"><h2 style="text-align: center;"> <?php echo e($project->name); ?> </h2></div>
			<div class="panel-body">
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12">
							<img src="/uploads/projects/<?php echo e($project->picture); ?>" style="max-width:200px; float:left; margin-right:25px; padding:2px; border:1px solid #C0C0C0">
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<p> <b>Número Projeto:</b> <?php echo e($project->number); ?> </p>
					<p> <b>Responsável: </b><?php echo e($userResponsible->name); ?> </p>
					<p> <b>Criado Em: </b><?php echo e($project->created_at); ?> </p>
					<p> <b>Membros: </b>
					<ul>
					<?php $__currentLoopData = $userMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userMember): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li> <?php echo e($userMember->name); ?> </li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</ul>
					</p>
				</div>
			</div>
		</div>
	</div>
	<?php echo $__env->make('layouts.project_sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>