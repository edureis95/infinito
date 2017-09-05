<?php $__env->startSection('content'); ?>

<div class="col-xs-12 insideContainer">
	<?php echo $__env->make('layouts.settings_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.project_settings_2nd_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body">
			<button class="pull-right hidden saveButton btn btn-success" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px;">
					<span style="font-size: 12px;">Guardar</span>
			</button>
			<table class="table expertiseTable smallFontTable">
			<thead>
				<th>Cód.</th>
				<th>Sigla</th>
				<th>Nome Especialidade</th>
				<th>Ações</th>
				<th>
					<button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button>
					<button style="padding: 3px 5px;" class="btn btn-success editButton" type="button"><i class="glyphicon glyphicon-edit"></i></button>
				</th>
				<th style="padding: 0" class="hidden hiddenForm">
				<form action="/settings/addExpertise" method="POST">
					<div class="col-md-3">
						<input type="text" required  class="form-control" name="code" placeholder="Cód.">
					</div>
					<div class="col-md-3">
						<input type="text" required  class="form-control" name="sigla" placeholder="Sigla">
					</div>
					<div class="col-md-4">
						<input type="text" required  class="form-control" name="expertise" placeholder="Especialidade">
					</div>
					<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
					<button type="submit" class="btn btn-primary">Inserir</button>
				</form>
				</th>
				<th></th>
			</thead>
			<tbody>
				<?php $__currentLoopData = $expertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
					<tr class="expert" id="expert<?php echo e($expert->id); ?>">
						<?php if($expert->parent == 0): ?>
						<td class="code" content="<?php echo e($expert->id); ?>"><?php echo e($expert->code); ?></td>
						<td class="sigla" content="<?php echo e($expert->id); ?>"><?php echo e($expert->sigla); ?></td>
						<td class="name" content="<?php echo e($expert->id); ?>"><?php echo e($expert->name); ?></td>
						<td data-editable='false'><button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button> 
						<td data-editable='false' class="hidden hiddenForm" style="padding: 0">
							<form action="/settings/addSubExpertise" method="POST">
								<div class="col-md-3">
									<input type="text" required  class="form-control" name="code" placeholder="Cód.">
								</div>
								<div class="col-md-3">
									<input type="text" required  class="form-control" name="sigla" placeholder="Sigla">
								</div>
								<div class="col-md-4">
									<input type="text" required  class="form-control" name="expertise" placeholder="Sub-Especialidade">
								</div>
								<input type="hidden" name="parent" value="<?php echo e($expert->id); ?>">
								<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
								<button type="submit" class="btn btn-primary">Inserir</button>
							</form>
						</td>
						<td></td>
						<td></td>
						<?php endif; ?>
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</tbody>
			</table>
			<table class="table expertiseTableEditable hidden smallFontTable">
				<thead>
				<th>Cód.</th>
				<th>Sigla</th>
				<th>Nome Especialidade</th>
				<th>Ações</th>
				<th>
				<button style="padding: 3px 5px;" class="btn btn-danger closeEditButton" type="button"><i class="glyphicon glyphicon-edit"></i></button>
				</th>
				</thead>
				<tbody>
				<?php $__currentLoopData = $expertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
					<tr class="expertEditable" id="expertEditable<?php echo e($expert->id); ?>">
						<?php if($expert->parent == 0): ?>
						<td class="code" content="<?php echo e($expert->id); ?>"><?php echo e($expert->code); ?></td>
						<td class="sigla" content="<?php echo e($expert->id); ?>"><?php echo e($expert->sigla); ?></td>
						<td class="name" content="<?php echo e($expert->id); ?>"><?php echo e($expert->name); ?></td>
						<td><button content='<?php echo e($expert->id); ?>' style="padding: 3px 5px;" class="btn btn-danger removeExpertise" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
						<td></td>
						<?php endif; ?>
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
function appendSubExpertise() {
	$.ajax({
	  async: false,
      type: "GET",
      url: '/expertiseWithParent',
      success: function(response) {
        for(var i = 0; i < response.length; i++) {
        	$('#expert' + response[i].parent).after('<tr class="subexpert' + response[i].parent + '"><td content="' + response[i].id + '" class="code">' + response[i].code + '</td><td content="' + response[i].id + '" class="sigla">' + response[i].sigla + '</td><td content="' + response[i].id + '" class="subexpert name" style="padding-left: 40px !important;">' + response[i].name + ' </td><td></td><td></td><td></td></tr>');

        	$('#expertEditable' + response[i].parent).after('<tr class="editableSubExpert subexpert' + response[i].parent + '" id="editableSubExpert' + response[i].id + '"><td content="' + response[i].id + '" class="code">' + response[i].code + '</td><td content="' + response[i].id + '" class="sigla">' + response[i].sigla + '</td><td content="' + response[i].id + '" class="subexpert name" style="padding-left: 40px !important;">' + response[i].name + ' </td><td data-editable="false"><button style="padding: 3px 5px;" class="btn btn-danger removeSubExpertise" content="'+ response[i].id +'" type="button"><i class="glyphicon glyphicon-minus"></i></button></td><td></td></tr>');
        }
      }
    });
}

$('.expertiseTable').on('click', '.hiddenFormButton', function() {
	$(this).parent().parent().find('.hiddenForm').removeClass('hidden');
});

$('.editButton').click(function() {
	$('.saveButton').removeClass('hidden');
	$('.closeEditButton').removeClass('hidden');
	$('.expertiseTable').addClass('hidden');
	$('.expertiseTableEditable').removeClass('hidden');
});

$('.closeEditButton').click(function() {
	$('.saveButton').addClass('hidden');
	$('.closeEditButton').addClass('hidden');
	$('.expertiseTable').removeClass('hidden');
	$('.expertiseTableEditable').addClass('hidden');
});

$('.expertiseTableEditable').on('click','.removeExpertise' , function() {
	var id = $(this).attr('content');
	$('#expertEditable' + id).remove();
	$('.subexpert' + id).each(function() {
		$(this).remove();
	});
	//$.get('/settings/projects/expertise/deleteExpertise/' + id, function() {
	//});

});

$('.expertiseTableEditable').on('click', '.removeSubExpertise', function() {
	var id = $(this).attr('content');
	$(this).parent().parent().find('.subexpert').parent().remove();
	//$.get('/settings/projects/expertise/deleteExpertise/' + id, function() {
	//});
})

appendSubExpertise();


$('.expertiseTableEditable').editableTableWidget();


$('.saveButton').click(function() {
	var obj = {};
	var obj2 = {};
	var ids = [];
	$('.expertEditable').each(function() {
		var id = $(this).attr('id').substr(14);
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

	$('.editableSubExpert').each(function() {
		var id = $(this).attr('id').substr(17);
		var expertise = [];
		$(this).find('td').each(function(index) {
			if(index < 3)
				expertise.push($(this).text());
		})
		if(expertise.length > 0) {
			ids.push(id);
			obj2[id] = expertise;
		}
	});

	var objJoined = $.extend(true, {}, obj, obj2);

	$.ajax({
	  type: "POST",
	  url: '/settings/projects/expertise/edit',
	  data: {
	  	'obj': objJoined,
	  	'ids': ids
	  },
	  success: function() {
	  	location.reload();
	  }
	});
})

</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>