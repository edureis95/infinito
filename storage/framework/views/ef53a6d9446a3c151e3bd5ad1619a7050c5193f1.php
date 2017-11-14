

<?php $__env->startSection('content'); ?>

<div class="col-xs-12 insideContainer">
	<?php echo $__env->make('layouts.settings_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.company_settings_2nd_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body">
			<?php if(count($absenceReasons)): ?>
			<table class="table smallFontTable">
				<thead>
					<th>Código</th>
					<th>Motivo de ausência </th>
					<th class="text-center">Ação
					<th><button style="padding: 3px 5px;" class="btn btn-primary addReason" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
				</thead>
				<tr class="hiddenForm hidden">
					<form action="/settings/company/absence/addReason" method="POST">
						<td style="max-width: 100px;"><input type="number" class="form-control" name="code"></td>
						<td><input type="text" class="form-control" name="reason"></td>
						<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
						<td><button type="submit" class="btn btn-primary">Inserir</button></td>
						<td></td>
					</form>
				</tr>
				<?php $__currentLoopData = $absenceReasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr class="reasonEdit<?php echo e($reason->id); ?> hidden">
						<td><input class="input-sm form-control codeInput" required name="code" value="<?php echo e($reason->code); ?>" type="text"></td>
						<td><input class="input-sm form-control nameInput" required name="name" type="text" value="<?php echo e($reason->name); ?>"></td>
						<td class="text-center">
							<button class="btn btn-xs btn-danger cancelEdit" content="<?php echo e($reason->id); ?>"><i class="glyphicon glyphicon-edit"></i></button>
							<button class="btn btn-xs btn-success saveEdit" content="<?php echo e($reason->id); ?>"><i class="glyphicon glyphicon-check"></i></button>
						</td>
					</tr>
				<tr class="reason<?php echo e($reason->id); ?>">
					<td><?php echo e(str_pad($reason->code, 3, '0', STR_PAD_LEFT)); ?></td>
					<td><?php echo e($reason->name); ?></td>
					<td class="text-center">
						<button content='<?php echo e($reason->id); ?>' class="btn btn-warning btn-xs editReason" type="button"><i class="glyphicon glyphicon-edit"></i></button>
						<button content='<?php echo e($reason->id); ?>' class="btn btn-danger btn-xs removeReason" type="button"><i class="glyphicon glyphicon-minus"></i></button>
					</td>
					<td></td>
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
	var txt;
	var r = confirm("Tem a certeza que quer eliminar este tipo de ausência?");
	if (r == true) {
		$.get('/settings/company/absence/removeReason/' + id, function() {
			location.reload();
		});
	}
});	

$('.editReason').click(function() {
	var id = $(this).attr('content');
	$('.reason' + id).addClass('hidden');
	$('.reasonEdit' + id).removeClass('hidden');
})

$('.cancelEdit').click(function() {
	var id = $(this).attr('content');
	$('.reason' + id).removeClass('hidden');
	$('.reasonEdit' + id).addClass('hidden');
})

$('.saveEdit').click(function() {
	var id = $(this).attr('content');
	var code = $('.reasonEdit' + id + ' .codeInput').val();
	var name = $('.reasonEdit' + id + ' .nameInput').val();
	$.ajax({
		method: 'POST',
		url: '/settings/company/absence/editReason',
		data: {
			id: id,
			code: code,
			name: name
		},
		success: function() {
			location.reload();
		}
	})
})

</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>