

<?php $__env->startSection('content'); ?>

<div class="col-xs-12 insideContainer">
	<?php echo $__env->make('layouts.settings_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.project_settings_2nd_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body">
			<table class="table typesTable smallFontTable">
			<thead>
				<th>Cód.</th>
				<th>Sigla</th>
				<th>Nome</th>
				<th>
					<button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button>
					<button style="padding: 3px 5px;" class="btn btn-success editButton" type="button"><i class="glyphicon glyphicon-edit"></i></button>
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
			</thead>
			<tbody>
			<?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
				<tr>
					<td content='<?php echo e($type->id); ?>' class="code"><?php echo e($type->code); ?></td>
					<td content='<?php echo e($type->id); ?>' class="sigla"><?php echo e($type->sigla); ?></td>
					<td content='<?php echo e($type->id); ?>' class="type name"><?php echo e($type->name); ?></td>
					<td></td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</tbody>
			</table>
			<div class="editableTypes hidden">
				<table class="table typesEditableTable smallFontTable">
				<thead>
					<th>Cód.</th>
					<th>Sigla</th>
					<th>Nome</th>
					<th>Ações</th>
					<th>
						<button style="padding: 3px 5px;" class="btn btn-danger cancelEdit" type="button"><i class="glyphicon glyphicon-edit"></i></button>
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
				</thead>
				<tbody>
				<?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
					<tr class="editableType" content="<?php echo e($type->id); ?>">
						<td content='<?php echo e($type->id); ?>' class="code"><?php echo e($type->code); ?></td>
						<td content='<?php echo e($type->id); ?>' class="sigla"><?php echo e($type->sigla); ?></td>
						<td content='<?php echo e($type->id); ?>' class="type name"><?php echo e($type->name); ?></td>
						<td data-editable='false'><button content='<?php echo e($type->id); ?>' style="padding: 3px 5px;" class="btn btn-danger removeType" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
						<td></td>
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
				</table>
				<button type="button" class="btn btn-success pull-right saveButton">Guardar</button>
			</div>
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
	//$.get('/settings/projects/types/deleteProjectType/' + id, function() {
	//});

});

$('.typesEditableTable').editableTableWidget();

$('.editButton').click(function() {
	$('.editableTypes').removeClass('hidden');
	$('.typesTable').addClass('hidden');
});

$('.cancelEdit').click(function() {
	$('.editableTypes').addClass('hidden');
	$('.typesTable').removeClass('hidden');
});

$('.saveButton').click(function() {
	var obj = {};
	var ids = [];
	$('.editableType').each(function() {
		var id = $(this).attr('content');
		var expertise = [];
		$(this).find('td').each(function(index) {
			if(index < 3)
				expertise.push($(this).text());
		})
		if(expertise.length > 0) {
			ids.push(id);
			obj[id] = expertise;
		}
	});

	$.ajax({
	  type: "POST",
	  url: '/settings/projects/types/edit',
	  data: {
	  	'obj': obj,
	  	'ids': ids
	  },
	  success: function() {
	  	location.reload();
	  }
	});
});
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>