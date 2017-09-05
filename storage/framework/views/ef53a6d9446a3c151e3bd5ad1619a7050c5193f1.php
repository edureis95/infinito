

<?php $__env->startSection('content'); ?>

<div class="col-md-11">
	<?php echo $__env->make('layouts.settings_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.company_settings_2nd_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default">
		<div class="panel-body">
			<?php if(count($absenceReasons)): ?>
			<table class="table borderless" style="width: auto;">
				<thead>
					<th>Código</th>
					<th>Motivo de ausência </th>
					<th>Ação
					<th><button style="padding: 3px 5px;" class="btn btn-primary addReason" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
				</thead>
				<tr class="hiddenForm hidden">
					<form action="/settings/company/absence/addReason" method="POST">
						<td style="max-width: 100px;"><input type="number" class="form-control" name="code"></td>
						<td><input type="text" class="form-control" name="reason"></td>
						<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
						<td><button type="submit" class="btn btn-primary">Inserir</button></td>
					</form>
				</tr>
				<?php $__currentLoopData = $absenceReasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td><?php echo e($reason->code); ?></td>
					<td><?php echo e($reason->name); ?></td>
					<td><button content='<?php echo e($reason->id); ?>' style="padding: 3px 5px; margin-bottom: 5px;" class="btn btn-danger removeReason" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
				</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</table>
			<?php endif; ?>
		</div>
	</div>
</div>

<script>

$('.addReason').click(function() {
	$('.hiddenForm').removeClass('hidden');
});

$('.removeReason').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().find('td').remove();
	$.get('/settings/company/absence/removeReason/' + id, function() {
	});
});	
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>