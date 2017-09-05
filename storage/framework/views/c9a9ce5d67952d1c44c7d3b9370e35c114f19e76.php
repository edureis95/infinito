<?php $__env->startSection('content'); ?>

	<div class="col-lg-9" style="padding: 0%;">
		<div class="panel panel-default">

			<!-- Modal -->
			<div id="myModal" class="modal fade" role="dialog">
				<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Modal Header</h4>
						</div>
						<div class="modal-body">

							<?php echo $__env->make('forms.create_client', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>

				</div>
			</div>

			<input type="hidden" id="user_val" value="<?php echo e($users); ?>" />
			<div class="panel-heading"><h2></h2></div> 
			<div class="panel-body">
				<form enctype="multipart/form-data" action="/projects/new" method="POST">
					<div class="form-group row">
						<label class="col-md-2 col-form-label vcenter" style="text-align: right;">Nome</label>
						<div class="col-md-4 vcenter">
							<input class="form-control" type="text" value="" name="name">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label vcenter" style="text-align: right;">Número</label>
						<div class="col-md-4 vcenter">
							<input class="form-control" type="text" value="" name="number">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label vcenter" style="text-align: right;">Descrição</label>
						<div class="col-md-4 vcenter">
							<textarea class="form-control" rows="5" value="" name="description"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 control-label vcenter" style="text-align: right;">Adicione foto</label>
						<div class="col-md-4 vcenter">
							<input id="input" name="picture" type="file" class="file" data-show-upload="false" data-show-caption="true">
							<script>
								$("#input").fileinput({
									language: "pt",
									allowedFileExtensions: ["jpg", "png", "gif"]
								});
							</script>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label vcenter" style="text-align: right;">Morada</label>
						<div class="col-md-4 vcenter">
							<input class="form-control" type="text" value="" name="address">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label vcenter" style="text-align: right;">Cidade</label>
						<div class="col-md-4 vcenter">
							<input class="form-control" type="text" value="" name="city">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label vcenter" style="text-align: right;">País</label>
						<div class="col-md-4 vcenter">
							<input class="form-control" type="text" value="" name="country">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-2 col-form-label vcenter" style="text-align: right;">Cliente</label>
						<div class="col-md-4 vcenter">
							<select class="form-control js-example-basic-single" type="text" name="client">
								<option value="0"> Não existe cliente </option>
								<?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($client->id); ?>"> <?php echo e($client->name); ?> </option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							</select>
						</div>
						<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Adicionar Cliente</button>
					</div>

					<div class="form-group row">
						<label class="col-md-2 col-form-label vcenter" style="text-align: right;">Responsável</label>
						<div class="col-md-4 vcenter">
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
						<label class="col-md-2 col-form-label vcenter" style="text-align: right;">Membros</label>
						<div class="col-md-4 vcenter">
							<select multiple="true" class="form-control js-example-tags" type="text" name="members[]">
								<option> Não existe responsável </option>
								<?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<optgroup label="<?php echo e($company->name); ?>" id="m<?php echo e($company->id); ?>">
									
								</optgroup>
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
<script>

<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	$('#r<?php echo e($user->company); ?>').append("<option value = '<?php echo e($user->id); ?>''> <?php echo e($user->name); ?> </option>");
	$('#m<?php echo e($user->company); ?>').append("<option value='<?php echo e($user->id); ?>'> <?php echo e($user->name); ?> </option>");
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	var count = $('#r<?php echo e($company->id); ?>').children().length;
	if(count == 0) {
		$('#r<?php echo e($company->id); ?>').remove();
		$('#m<?php echo e($company->id); ?>').remove();
	}
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>