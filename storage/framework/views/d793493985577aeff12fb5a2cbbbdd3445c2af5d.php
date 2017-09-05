

<?php $__env->startSection('content'); ?>


<div class="col-xs-11" style="padding: 0%;">
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
				<table class="table table-responsive borderless" style="width: auto;">
					<thead>
						<th>Tipo</th>
						<th>Fase</th>
						<th>Especialidade</th>
						<th>Data de início</th>
						<th>Data de fim</th>
						<th>Milestone</th>
						<th>Ação</th>
						<th><button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
					</thead>
					<tr class="hidden hiddenForm">
						<form action="/project/<?php echo e($project->id); ?>/planning/addPlanning" method="POST">
							<td>
								<select class="form-control input-sm" name="type">
									<?php $__currentLoopData = $planningTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</td>
							<td>
								<select class="form-control input-sm" name="phase">
									<?php $__currentLoopData = $phases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($phase->phase_id); ?>"><?php echo e($phase->name); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</td>
							<td>
								<select class="form-control input-sm" name="expertise">
									<?php $__currentLoopData = $expertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($expert->expertise_id); ?>"><?php echo e($expert->name); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</td>
							<td>
								<input type="date" name="startDate" class="form-control">
							</td>
							<td>
								<input type="date" name="endDate" class="form-control endDate">
							</td>
							<td>
								<input type="checkbox" name="milestone" class="milestoneCheckbox">
							</td>
							<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
							<td><button type="submit" class="btn btn-primary input-sm">Inserir</button></td>
						</form>
					</tr>
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
						<td data-editable='false'><button content='<?php echo e($planning->id); ?>' style="padding: 3px 5px;" class="btn btn-danger removePlanning" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
					</tr>	
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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