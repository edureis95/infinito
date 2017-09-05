<?php $__env->startSection('content'); ?>

<div class="col-xs-12" style="max-width: 100%;">
	<?php echo $__env->make('layouts.management_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.management_company_second_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body" style="padding: 0;">
			<table class="table borderless" style="width: auto;">
				<thead>
					<th class="text-center">Ano</th>
					<th class="text-center">Dias de Férias Obrigatórias</th>
					<th class="text-center">Dias Extra</th>
					<th class="text-center">Total de Dias de Férias</th>
					<th class="text-center">Ação</th>
					<th class="text-center"><button style="padding: 3px 5px;" class="btn btn-primary addHoliday" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
				</thead>
				<tr class="hiddenForm hidden text-center">
					<form action="/settings/company/holidays/addDays" method="POST">
						<td style="max-width: 100px; margin: auto;"><input type="number" class="form-control" name="year"></td>
						<td><input style="max-width: 100px; margin: auto;" type="number" class="form-control" name="requiredDays"></td>
						<td style="max-width: 100px; margin: auto;"><input type="number" class="form-control" name="extraDays"></td>
						<td>-</td>
						<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
						<td><button type="submit" class="btn btn-primary">Inserir</button></td>
					</form>
				</tr>
				<?php $__currentLoopData = $holidays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $holiday): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr class="text-center">
					<td><?php echo e($holiday->year); ?></td>
					<td><?php echo e($holiday->required_days); ?></td>
					<td><?php echo e($holiday->extra_days); ?></td>
					<td><?php echo e($holiday->required_days + $holiday->extra_days); ?></td>
					<td><button content='<?php echo e($holiday->id); ?>' style="padding: 3px 5px; margin-bottom: 5px;" class="btn btn-danger removeHoliday" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
				</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</table>
		</div>
	</div>
</div>

<script>

$('.addHoliday').click(function() {
	$('.hiddenForm').removeClass('hidden');
});

$('.removeHoliday').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().find('td').remove();
	$.get('/settings/company/holidays/removeHoliday/' + id, function() {
	});
});	
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>