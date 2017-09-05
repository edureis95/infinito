

<?php $__env->startSection('content'); ?>

<div class="col-md-11">
	<?php echo $__env->make('layouts.settings_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.project_settings_2nd_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default">
		<div class="panel-body">
			<table class="table expertiseTable borderless" style="width: auto">
				<th>Cód.</th>
				<th>Sigla</th>
				<th>Nome Especialidade</th>
				<th>Ações</th>
				<th><button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
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
				<?php $__currentLoopData = $expertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
					<tr class="expert" id="expert<?php echo e($expert->id); ?>">
						<?php if($expert->parent == 0): ?>
						<td class="code" content="<?php echo e($expert->id); ?>"><?php echo e($expert->code); ?></td>
						<td class="sigla" content="<?php echo e($expert->id); ?>"><?php echo e($expert->sigla); ?></td>
						<td class="name" content="<?php echo e($expert->id); ?>"><?php echo e($expert->name); ?></td>
						<td data-editable='false'><button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button> 
						<button content='<?php echo e($expert->id); ?>' style="padding: 3px 5px;" class="btn btn-danger removeExpertise" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
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
	  async: false,
      type: "GET",
      url: '/expertiseWithParent',
      success: function(response) {
        for(var i = 0; i < response.length; i++) {
        	$('#expert' + response[i].parent).after('<tr class="subexpert' + response[i].parent + '"><td content="' + response[i].id + '" class="code">' + response[i].code + '</td><td content="' + response[i].id + '" class="sigla">' + response[i].sigla + '</td><td content="' + response[i].id + '" class="subexpert name" style="padding-left: 40px;">' + response[i].name + ' </td><td><button content="' + response[i].id + '" style="padding: 3px 5px;" class="btn btn-danger removeSubExpertise" type="button"><i class="glyphicon glyphicon-minus"></i></button></td></tr>');
        }
      }
    });
}

$('.expertiseTable').on('click', '.hiddenFormButton', function() {
	$(this).parent().parent().find('.hiddenForm').removeClass('hidden');
});

$('.expertiseTable').on('click','.removeExpertise' , function() {
	var id = $(this).attr('content');
	$('#expert' + id).remove();
	$('.subexpert' + id).each(function() {
		$(this).remove();
	});
	$.get('/settings/projects/expertise/deleteExpertise/' + id, function() {
	});

});

$('.expertiseTable').on('click', '.removeSubExpertise', function() {
	var id = $(this).attr('content');
	$(this).parent().parent().find('.subexpert').parent().remove();
	$.get('/settings/projects/expertise/deleteExpertise/' + id, function() {
	});
})

appendSubExpertise();

$('.expertiseTable').editableTableWidget();


$('.expertiseTable td').on('change', function(evt, newValue) {
	var id = $(this).attr('content');
	if($(this).hasClass('code')) {
		$.ajax({
	      type: "POST",
	      url: '/settings/projects/expertise/changeExpertiseCode',
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
	      url: '/settings/projects/expertise/changeExpertiseSigla',
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
	      url: '/settings/projects/expertise/changeExpertiseName',
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