<?php $__env->startSection('content'); ?>

<div class="col-xs-12 insideContainer">
	<?php echo $__env->make('layouts.settings_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.project_settings_2nd_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body">
			<table class="table typesTable smallFontTable">
			<thead>
				<th class="text-center">Cód.</th>
				<th class="text-center">Sigla</th>
				<th class="text-center">Tipo Acontecimento</th>
				<th class="text-center">Ações</th>
				<th class="text-center">
					<button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button>
				</th>
			</thead>
			<tbody class="text-center">
			<tr class="hiddenForm hidden">
				<form action="/settings/addProjectEventType" method="POST">
					<td>
						<input type="text" required  class="form-control" name="code">
					</td>
					<td>
						<input type="text" required  class="form-control" name="sigla">
					</td>
					<td>
						<input type="text" required  class="form-control" name="type">
					</td>
					<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
					<td>
						<button type="submit" class="btn btn-primary">Inserir</button>
					</td>
				</form>
			</tr>
			<?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
				<tr>
					<td content='<?php echo e($type->id); ?>' class="code"><?php echo e($type->code); ?></td>
					<td content='<?php echo e($type->id); ?>' class="sigla"><?php echo e($type->sigla); ?></td>
					<td content='<?php echo e($type->id); ?>' class="type name"><?php echo e($type->name); ?></td>
					<td data-editable='false'><button content='<?php echo e($type->id); ?>' style="padding: 3px 5px;" class="btn btn-danger removeType" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
					<td></td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</tbody>
			</table>
		</div>
	</div>
</div>

<script>

$('.hiddenFormButton').click(function() {
	$('.hiddenForm').removeClass('hidden');
});

$('.removeType').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().find('.type').parent().remove();
	$.get('/settings/projects/documentTypes/deleteDocumentType/' + id, function() {
	});

});
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>