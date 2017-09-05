

<?php $__env->startSection('content'); ?>

<div class="col-md-11">
	<?php echo $__env->make('layouts.settings_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default">
		<div class="panel-body">
			<form action="/settings/addExpertise" method="POST">
				<div class="col-md-6">
					<input type="text" required  class="form-control" name="expertise" aria-describedby="emailHelp" placeholder="Introduz o nome da especialidade que queres inserir na bd">
				</div>
				<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
				<button type="submit" class="btn btn-primary">Inserir especialidade</button>
			</form>
			<form action="/settings/addPhase" method="POST">
				<div class="col-md-6">
					<input type="text" required  class="form-control" name="phase" aria-describedby="emailHelp" placeholder="Introduz o nome da fase que queres inserir na bd">
				</div>
				<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
				<button type="submit" class="btn btn-primary">Inserir fase</button>
			</form>
		</div>
	</div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>