<?php $__env->startSection('content'); ?>

<div class="col-md-11">
	<?php echo $__env->make('layouts.settings_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default">
		<div class="panel-body">
			<table class="table borderless" style="width:auto;">
			<th>Fases <button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
			<th style="padding: 0;" class="hidden hiddenForm">
				<form action="/settings/addPhase" method="POST">
					<div class="col-md-6">
						<input type="text" required  class="form-control" name="phase" aria-describedby="emailHelp" placeholder="Fase">
					</div>
					<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
					<button type="submit" class="btn btn-primary">Inserir</button>
				</form>
			</th>
			<?php $__currentLoopData = $phases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
				<tr>
					<td><?php echo e($phase->name); ?></td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</table>
			<table class="table expertiseTable borderless" style="width: auto">
				<th>Especialidades <button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
				<th style="padding: 0" class="hidden hiddenForm">
				<form action="/settings/addExpertise" method="POST">
					<div class="col-md-6">
						<input type="text" required  class="form-control" name="expertise" aria-describedby="emailHelp" placeholder="Especialidade">
					</div>
					<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
					<button type="submit" class="btn btn-primary">Inserir</button>
				</form>
				</th>
				<th></th>
				<?php $__currentLoopData = $expertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
					<tr class="expert" id="expert<?php echo e($expert->id); ?>">
						<?php if($expert->parent == 0): ?>
						<td><?php echo e($expert->name); ?> <button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button></td>
						<td></td>
						<td class="hidden hiddenForm" style="padding: 0">
							<form action="/settings/addSubExpertise" method="POST">
								<div class="col-md-7">
									<input type="text" required  class="form-control" name="expertise" aria-describedby="emailHelp" placeholder="Sub-especialidade">
								</div>
								<input type="hidden" name="parent" value="<?php echo e($expert->id); ?>">
								<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
								<button type="submit" class="btn btn-primary">Inserir</button>
							</form>
						</td>
						<?php endif; ?>
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</table>
		</div>
	</div>
</div>

<script>
function appendSubExpertise() {
	$.ajax({
      type: "GET",
      url: '/expertiseWithParent',
      success: function(response) {
        for(var i = 0; i < response.length; i++) {
        	$('#expert' + response[i].parent).after('<tr><td></td><td>' + response[i].name + '</td></tr>');
        }
      }
    });
}

$('.hiddenFormButton').click(function() {
	$(this).parent().parent().find('.hiddenForm').removeClass('hidden');
});
appendSubExpertise();
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>