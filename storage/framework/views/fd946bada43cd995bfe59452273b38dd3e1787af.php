<?php $__env->startSection('content'); ?>


<div class="col-xs-12" style="max-width: 100%;">
	<?php echo $__env->make('layouts.project_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.project_second_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body link-nav" style="padding: 0;">
			<div class="col-xs-12">
				<table class="table phasesSelectTable" style="width: auto; min-width: 50%;">
					<thead>
						<th></th>
						<?php $__currentLoopData = $projectPhases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<th><?php echo e($phase->p_sigla); ?></th>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</thead>	
					<tbody>
						<?php $__currentLoopData = $projectExpertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($expert->e_sigla); ?> - <?php echo e($expert->e_name); ?></td>
							<?php $__currentLoopData = $projectPhases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<td>
								<?php if($expert->phases->contains('phase_id', $phase->p_id)): ?>
								<input style="float: left;" disabled checked class="expertCheckbox" content="<?php echo e($expert->e_id); ?>" 2ndContent="<?php echo e($phase->p_id); ?>" type="checkbox">
								<?php else: ?>
								<input style="float: left;" disabled class="expertCheckbox" content="<?php echo e($expert->e_id); ?>" 2ndContent="<?php echo e($phase->p_id); ?>" type="checkbox">
								<?php endif; ?>
								<input class="form-control input-sm" disabled style="width: 60px;" type="number" max="100" min="0">
							</td>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php $__currentLoopData = $expert->subExpertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subExpert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr class="subExpertise<?php echo e($expert->p_e_id); ?>">
								<td><span style="padding-left: 10%;"><?php echo e($subExpert->e_sigla); ?> - <?php echo e($subExpert->e_name); ?></span></td>
								<?php $__currentLoopData = $projectPhases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<td>
									<?php if($subExpert->phases->contains('phase_id', $phase->p_id)): ?>
									<input disabled checked class="expertCheckbox expertCheckbox<?php echo e($phase->p_id); ?><?php echo e($subExpert->e_parent); ?>" 2ndContent="<?php echo e($phase->p_id); ?>" content="<?php echo e($subExpert->e_id); ?>" style="float: left;" type="checkbox">
									<?php else: ?>
									<input disabled class="expertCheckbox expertCheckbox<?php echo e($phase->p_id); ?><?php echo e($subExpert->e_parent); ?>" 2ndContent="<?php echo e($phase->p_id); ?>" content="<?php echo e($subExpert->e_id); ?>" style="float: left;" type="checkbox">
									<?php endif; ?>
									<input disabled class="form-control input-sm" style="width: 60px;" type="number" max="100" min="0">
								</td>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tbody>
				</table>
				<!--<button type="button" class="btn btn-success saveButton">Guardar</button>-->
			</div>
		</div>
	</div>
</div>

<script>

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>