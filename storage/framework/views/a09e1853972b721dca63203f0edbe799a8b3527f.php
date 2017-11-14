<?php $__env->startSection('content'); ?>


<div class="col-xs-12" style="max-width: 98%;">
	<?php echo $__env->make('layouts.project_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.project_second_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body link-nav" style="padding: 0;">
			<div class="col-xs-12">
				<table class="table table-responsive smallFontTable">
					<thead>
						<th class="text-center">Tipo</th>
						<th class="text-center">Fase</th>
						<th class="text-center">Especialidade</th>
						<th class="text-center">Data de início</th>
						<th class="text-center">Data de fim</th>
						<th class="text-center">Milestone</th>
					</thead>
					<tbody class="text-center">
					<?php $__currentLoopData = $project_planning; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $planning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td>
							<select class="form-control input-sm" name="type">
								<?php $__currentLoopData = $planningTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if($type->id == $planning->type): ?>
									<option selected value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
								<?php else: ?>
									<option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
								<?php endif; ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</td>
						<td>
							<select class="form-control input-sm" name="phase">
								<?php $__currentLoopData = $phases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if($phase->phase_id == $planning->phase): ?>
									<option selected value="<?php echo e($phase->phase_id); ?>"><?php echo e($phase->name); ?></option>
								<?php else: ?>
									<option value="<?php echo e($phase->phase_id); ?>"><?php echo e($phase->name); ?></option>
								<?php endif; ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</td>
						<td>
							<select class="form-control input-sm" name="expertise">
								<?php $__currentLoopData = $expertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if($expert->expertise_id == $planning->expertise): ?>
									<option selected value="<?php echo e($expert->expertise_id); ?>"><?php echo e($expert->name); ?></option>
								<?php else: ?>
									<option value="<?php echo e($expert->expertise_id); ?>"><?php echo e($expert->name); ?></option>
								<?php endif; ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</td>
						<td><?php echo e($planning->startDate); ?></td>
						<?php if($planning->milestone == 1): ?>
						<td></td>
						<td><input type="checkbox" checked name="milestone" class="milestoneCheckbox"></td>
						<?php else: ?>
						<td><?php echo e($planning->endDate); ?></td>
						<td><input type="checkbox" name="milestone" class="milestoneCheckbox"></td>
						<?php endif; ?>
					</tr>	
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
$('.hiddenFormButton').click(function() {
	$('.hiddenForm').removeClass('hidden');
});

$('.milestoneCheckbox').change(function() {
	console.log($(this).is(":checked"));
	if($(this).is(":checked") == true) {
		$('.endDate').addClass('hidden');
	} else {
		$('.endDate').removeClass('hidden');
	}
});

$('.removePlanning').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().remove();
	$.get('/project/deletePlanning/' + id, function() {
	});
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>