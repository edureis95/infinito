<?php $__env->startSection('content'); ?>

	<div class="col-lg-9" style="padding: 0%;">
		<div class="panel panel-default">
			<input type="hidden" id="user_val" value="<?php echo e($users); ?>" />
			<div class="panel-heading"><h2>Create Task</h2></div> 
			<div class="panel-body">
				<form enctype="multipart/form-data" action="/task/new" method="POST">
					<div class="form-group row">
						<label class="col-md-2 col-form-label" style="text-align: right; padding-top: 5px;">Nome</label>
						<div class="col-md-4">
							<input class="form-control" type="text" value="" name="text">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label" style="text-align: right;">Descrição</label>
						<div class="col-md-4">
							<textarea class="form-control" rows="5" value="" name="description"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label" style="text-align: right;">Data de criação</label>
						<div class="col-md-4">
							<input class="form-control" type="date" value="" name="start_date">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label" style="text-align: right;">Duração</label>
						<div class="col-md-4">
							<input class="form-control" type="text" value="" name="duration">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label" style="text-align: right;">Deadline</label>
						<div class="col-md-4">
							<input class="form-control" type="date" value="" name="deadline">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label" style="text-align: right;">Data prevista de início</label>
						<div class="col-md-4">
							<input class="form-control" type="date" value="" name="planned_start">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label" style="text-align: right;">Data prevista de conclusão</label>
						<div class="col-md-4">
							<input class="form-control" type="date" value="" name="planned_end">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-2 col-form-label" style="text-align: right;">Projeto</label>
						<div class="col-md-4">
							<select class="form-control js-example-basic-single" type="text" name="parent_project">
								<?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value='<?php echo e($project->project_Task_ID); ?>'> <?php echo e($project->name); ?> </option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-2 col-form-label" style="text-align: right;">Responsável</label>
						<div class="col-md-4">
							<select class="form-control js-example-basic-single" type="text" name="responsible">
								<option> Não existe responsável </option>
								<?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<optgroup label="<?php echo e($company->name); ?>" id="r<?php echo e($company->id); ?>">
									
								</optgroup>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-2 col-form-label" style="text-align: right;">Sub Task de</label>
						<div class="col-md-4">
							<select class="form-control js-example-basic-single" type="text" name="parent_task" id="activities">
								<option> Nenhuma tarefa </option>
							</select>
						</div>
					</div>

					<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

					<div class="form-group row">
						<div class="col-md-offset-3 col-md-3">
							<input type="submit" class="btn btn-sm btn-primary">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<script>
<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	$('#r<?php echo e($user->company); ?>').append("<option value = '<?php echo e($user->id); ?>''> <?php echo e($user->name); ?> </option>");
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	$('#activities').append("<option value = '<?php echo e($activity->activity_task_id); ?>''> <?php echo e($activity->name); ?> </option>");
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>