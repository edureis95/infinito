

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
						<th>Especialidade</th>
						<th>Ações</th>
						<th><button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
					</thead>
					<tr class="hidden hiddenForm">
						<form action="/project/expertise/addExpertise/<?php echo e($project->id); ?>" method="POST">
							<td>
								<select class="form-control input-sm" name="expertise">
									<?php $__currentLoopData = $expertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($expert->id); ?>"><?php echo e($expert->sigla); ?> - <?php echo e($expert->name); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</td>
							<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
							<td><button type="submit" class="btn btn-primary input-sm">Inserir</button></td>
						</form>
					</tr>
					<?php $__currentLoopData = $projectExpertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td><?php echo e($expert->e_sigla); ?> - <?php echo e($expert->e_name); ?></td>
						<td data-editable='false'><button style="padding: 3px 5px;" content='<?php echo e($expert->p_e_id); ?>' class="btn btn-primary hiddenFormSubExpertButton" type="button"><i class="glyphicon glyphicon-plus"></i></button> 
						<button content='<?php echo e($expert->p_e_id); ?>' style="padding: 3px 5px;" class="btn btn-danger removeExpertise" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
						<tr class="subExpertiseForm<?php echo e($expert->p_e_id); ?> hidden">
							<form action="/project/expertise/addExpertise/<?php echo e($project->id); ?>" method="POST">
								<td style="padding-left: 40px;">
									<select class="form-control input-sm" name="expertise">
										<?php $__currentLoopData = $subExpertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subExpert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($subExpert->parent == $expert->e_id): ?>
											<option value="<?php echo e($subExpert->id); ?>"><?php echo e($subExpert->sigla); ?> - <?php echo e($subExpert->name); ?></option>
										<?php endif; ?>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</td>
								<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
								<td><button type="submit" class="btn btn-primary input-sm">Inserir</button></td>
							</form>
						</tr>
						<tr class="subExpertise<?php echo e($expert->p_e_id); ?>">
							<?php $__currentLoopData = $expert->subExpertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subExpert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<td style="padding-left: 40px;"><?php echo e($subExpert->e_sigla); ?> - <?php echo e($subExpert->e_name); ?></td>
								<td><button content='<?php echo e($subExpert->p_e_id); ?>' style="padding: 3px 5px;" class="btn btn-danger removeExpertise" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
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

$('.hiddenFormSubExpertButton').click(function() {
	var id = $(this).attr('content');
	$('.subExpertiseForm' + id).removeClass('hidden');
})

$('.removeExpertise').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().remove();
	$('.subExpertiseForm' + id).remove();
	$('.subExpertise' + id).remove();
	$.get('/project/deleteExpertise/' + id, function() {
	});
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>