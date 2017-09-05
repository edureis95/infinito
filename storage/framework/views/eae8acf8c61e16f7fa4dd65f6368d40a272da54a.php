


<?php $__env->startSection('content'); ?>


	<div class="col-lg-9" style="padding: 0%;">

		<div class="panel panel-default">
			<div class="panel-heading"><h2><?php echo e($user->name); ?></h2></div> 
			<div class="panel-body">
				<form enctype="multipart/form-data" action="/profile/<?php echo e($user->id); ?>/edit " method="POST">
					<div class="form-group row">
						<label class="col-md-2 col-form-label" style="text-align: right; padding-top: 5px;">Nome</label>
						<div class="col-md-4">
							<input class="form-control" type="text" value="<?php echo e($user->name); ?>" name="name">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label" style="text-align: right;">Telemóvel</label>
						<div class="col-md-4">
							<input class="form-control" type="text" value="<?php echo e($user->cell_phone); ?>" name="cell_phone">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label" style="text-align: right;">Telefone</label>
						<div class="col-md-4">
							<input class="form-control" type="text" value="<?php echo e($user->desk_phone); ?>" name="desk_phone">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label" style="text-align: right;">Skype</label>
						<div class="col-md-4">
							<input class="form-control" type="text" value="<?php echo e($user->skype); ?>" name="skype">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-2 control-label" style="text-align: right;">Adicione foto</label>
						<div class="col-md-4">
							<input id="input" name="avatar" type="file" class="file" data-show-upload="false" data-show-caption="true">
							<script>
								$("#input").fileinput({
									language: "pt",
									allowedFileExtensions: ["jpg", "png", "gif"]
								});
							</script>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-2 col-form-label" style="text-align: right;">Empresa</label>
						<div class="col-md-4">
							<select class="form-control" type="text" name="company">
								<option> <?php echo e($user_company->name); ?> </option>
								<?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if($company->name != $user_company->name): ?>
								<option> <?php echo e($company->name); ?> </option>
								<?php endif; ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>