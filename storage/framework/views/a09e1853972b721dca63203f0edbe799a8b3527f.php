<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/datepicker-pt.js"></script>

<div class="col-xs-12 insideContainer">
	<?php echo $__env->make('layouts.project_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.project_second_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body link-nav">
			<button class="dropdown-toggle hiddenFormButton btn btn-primary" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px; margin-left: 93%;">
				<span style="font-size: 12px;">Adicionar</span>
			</button>
			<div class="formButtons hidden">
				<button class="dropdown-toggle cancelFunction btn btn-danger pull-right" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px; margin-right: 80px;">
					<span style="font-size: 12px;">Cancelar</span>
				</button>
				<button class="dropdown-toggle saveFunction btn btn-primary pull-right" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px;">
						<span style="font-size: 12px;">Guardar</span>
				</button>
			</div>
			<table class="table table-responsive smallFontTable">
				<thead>
					<th class="text-center">Tipo</th>
					<th class="text-center">Especialidade</th>
					<th class="text-center">Fase</th>
					<th class="text-center">Data</th>
					<th class="text-center">Ação</th>
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
							<select class="form-control input-sm" name="expertise">
								<?php $__currentLoopData = $expertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($expert->expertise_id); ?>"><?php echo e($expert->name); ?></option>
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
							<input type="text" name="startDate" class="form-control input-sm datepicker">
						</td>
						<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
						<td><button type="submit" class="btn btn-primary input-sm submitButton hidden">Inserir</button></td>
					</form>
				</tr>
				<?php $__currentLoopData = $project_planning; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $planning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr class="text-center">
					<td>
						<?php echo e($planning->pl_name); ?>

					</td>
					<td>
						<?php echo e($planning->e_name); ?>

					</td>
					<td>
						<?php echo e($planning->ph_name); ?>

					</td>
					<td><?php echo e($planning->startDate); ?></td>						
					<td data-editable='false'><button content='<?php echo e($planning->id); ?>' style="padding: 3px 5px;" class="btn btn-danger removePlanning" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
				</tr>	
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</table>
		</div>
	</div>
</div>

<script>
$('.hiddenFormButton').click(function() {
	$(this).addClass('hidden');
	$('.formButtons').removeClass('hidden');
	$('.hiddenForm').removeClass('hidden');
});

$('.cancelFunction').click(function() {
	$('.formButtons').addClass('hidden');
	$('.hiddenFormButton').removeClass('hidden');
	$('.hiddenForm').addClass('hidden');
})

$('.saveFunction').click(function() {
	$('.submitButton').click();
})

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