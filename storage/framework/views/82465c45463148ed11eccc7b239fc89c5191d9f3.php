

<?php $__env->startSection('content'); ?>

<div class="col-md-11">
	<?php echo $__env->make('layouts.settings_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.project_settings_2nd_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default">
		<div class="panel-body">
			<table class="table borderless typesTable" style="width:auto;">
			<th>Cód.</th>
			<th>Sigla</th>
			<th>Nome</th>
			<th>Ações</th>
			<th>
				<button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button>
			</th>
			<th style="padding: 0;" class="hidden hiddenForm">
				<form action="/settings/addProjectType" method="POST">
					<div class="col-md-3">
						<input type="text" required  class="form-control" name="code" placeholder="Cód.">
					</div>
					<div class="col-md-3">
						<input type="text" required  class="form-control" name="sigla" placeholder="Sigla">
					</div>
					<div class="col-md-4">
						<input type="text" required  class="form-control" name="type" placeholder="Tipo de Projeto">
					</div>
					<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
					<button type="submit" class="btn btn-primary">Inserir</button>
				</form>
			</th>
			<?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
				<tr>
					<td content='<?php echo e($type->id); ?>' class="code"><?php echo e($type->code); ?></td>
					<td content='<?php echo e($type->id); ?>' class="sigla"><?php echo e($type->sigla); ?></td>
					<td content='<?php echo e($type->id); ?>' class="type name"><?php echo e($type->name); ?></td>
					<td data-editable='false'><button content='<?php echo e($type->id); ?>' style="padding: 3px 5px;" class="btn btn-danger removeType" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</table>
		</div>
	</div>
</div>

<script>

$('.hiddenFormButton').click(function() {
	$(this).parent().parent().find('.hiddenForm').removeClass('hidden');
});

$('.removeType').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().find('.type').parent().remove();
	$.get('/settings/projects/types/deleteProjectType/' + id, function() {
	});

});

$('.typesTable').editableTableWidget();

$('.typesTable td').on('change', function(evt, newValue) {
	var id = $(this).attr('content');
	if($(this).hasClass('code')) {
		$.ajax({
	      type: "POST",
	      url: '/settings/projects/types/changeTypeCode',
	      data: {
	      	'code': newValue,
	      	'id': id
	      },
	      success: function(response) {
	      }
	    });
	} else if($(this).hasClass('sigla')) {
		$.ajax({
	      type: "POST",
	      url: '/settings/projects/types/changeTypeSigla',
	      data: {
	      	'sigla': newValue,
	      	'id': id
	      },
	      success: function(response) {
	      }
	    });
	} else if($(this).hasClass('name')) {
		$.ajax({
	      type: "POST",
	      url: '/settings/projects/types/changeTypeName',
	      data: {
	      	'name': newValue,
	      	'id': id
	      },
	      success: function(response) {
	      }
	    });
	}
});	
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>