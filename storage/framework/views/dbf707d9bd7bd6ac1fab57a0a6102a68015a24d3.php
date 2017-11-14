<?php $__env->startSection('content'); ?>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Criar Proposta</h4>
  </div>
  <div class="modal-body">
    <form class="form-horizontal" role="form" action="/commercialProjects/new" method="POST">
			<div class="panel-group">
				<div class="panel panel-info">
					<div class="panel-heading" style="height: 40px;">
						<p>Dados da proposta</p>
					</div>
					<div class="panel-body">
						  <div class="form-group">
						    <label for="input1" class="col-xs-2 control-label">Código</label>
						    <div class="col-xs-10">
						      <input style="width: 50px;display:inline;" type="text"  required class="form-control number input-medium bfh-phone" data-format="dd" name="code">
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="input2" class="col-xs-2 control-label">Nome</label>
						    <div class="col-xs-4">
						      <input type="text" required class="form-control" name="name">
						    </div>
						  </div>
						  
					</div>
				</div>
				<div class="panel panel-info">
					<div class="panel-heading" style="height: 40px;">
						<p>Especialidades e Fases</p>
					</div>
					<div class="panel-body controls">
						<div class="row">
						<div class="form-group col-xs-12 phases">
							<div class="col-xs-10 entry input-group">
									<div class="col-xs-4">
										<label class="col-form-label" style="text-align: right;">Fases</label>
									</div>
									<div class="col-xs-5">
									<select class="form-control" type="text" name="phases[]">
										<option value="0"> Sem fases </option>
										<?php $__currentLoopData = $phases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($phase->id); ?>"> <?php echo e($phase->name); ?> </option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
									</div>
									<div class="col-xs-1" style="padding-left: 0; margin: 0;">
									<span class="input-group-btn">
			                            <button class="btn btn-success btn-add-phase" type="button">
			                                <span class="glyphicon glyphicon-plus"></span>
			                            </button>
			                        </span>
			                        </div>
		                        </div>
							</div>
						</div>
						<div class="row">
						<div class="form-group col-xs-12 expertise">
							<div class="col-xs-10 entryExpert input-group">
									<div class="col-xs-4">
										<label class="col-form-label" style="text-align: right;">Especialidades</label>
									</div>
									<div class="col-xs-5">
									<select class="form-control expertiseSelect" type="text" name="expertise[]">
										<option value="0"> Sem especialidades </option>
										<?php $__currentLoopData = $expertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($expert->parent == 0): ?>
											<option value="<?php echo e($expert->id); ?>"> <?php echo e($expert->name); ?> </option>
										<?php endif; ?>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
									</div>
									<div class="col-xs-1" style="padding-left: 0; margin: 0;">
									<span class="input-group-btn">
			                            <button class="btn btn-success btn-add-expert" type="button">
			                                <span class="glyphicon glyphicon-plus">Esp.</span>
			                            </button>
			                        </span>
			                        <span class="input-group-btn">
			                            <button class="btn btn-success btn-add-subexpert" type="button">
			                                <span class="glyphicon glyphicon-plus">Sub.</span>
			                            </button>
			                        </span>
			                        </div>
			                        <div class="subexpertise">
			                        	
			                        </div>
		                        </div>
							</div>
						</div>
					</div>

					</div>
					<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
					<div class="form-group row">
						<div class="col-xs-offset-3 col-xs-3">
							<input type="submit" class="btn btn-primary">
						</div>
						<div class="col-xs-offset-3 col-xs-3">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						</div>
					</div>
				</div>
			</div>
			</form>
      </div>
    </div>
  </div>
</div>

<div class="col-xs-12" style="max-width: 98%;">
	<?php echo $__env->make('layouts.management_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.commercial_management_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body" style="padding: 0;">
			<table class="table typesTable">
				<thead>
					<th class="text-center">Código</th>
					<th class="text-center">Descrição</th>
					<th class="text-center">Especialidade</th>
					<th class="text-center">Localidade</th>
					<th class="text-center">Valor de Obra</th>
					<th class="text-center">Valor de Projeto</th>
					<th class="text-center">Estado Comercial</th>
					<th class="text-center">
						<button style="padding: 3px 5px;" data-toggle="modal" data-target="#myModal" class="btn btn-primary addType" type="button"><i class="glyphicon glyphicon-plus"></i> Nova proposta</button>
					</th>
				</thead>
				<tbody class="text-center">
				<?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td><a href="/commercialProject/showProject/<?php echo e($project->id); ?>"><?php echo e($project->number); ?></a></td>
					<td><a href="/commercialProject/showProject/<?php echo e($project->id); ?>"><?php echo e($project->name); ?></a></td>
					<td></td>
					<td></td>
				</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
$(function () {
	$(document).on('click', '.btn-add-phase', function(e) {
	    e.preventDefault();

	    var controlForm = $('.controls .phases:first'),
	        currentEntry = $(this).parents('.entry:first'),
	        newEntry = $(currentEntry.clone()).appendTo(controlForm);

	   	newEntry.find('label').addClass('hidden');

	    newEntry.find('input').val('');
	    controlForm.find('.entry:not(:last) .btn-add-phase')
	        .removeClass('btn-add-phase').addClass('btn-remove-phase')
	        .removeClass('btn-success').addClass('btn-danger')
	        .html('<span class="glyphicon glyphicon-minus"></span>');
	}).on('click', '.btn-remove-phase', function(e) {
		$(this).parents('.entry:first').remove();
		$('.controls .phases:first').find('label:first').removeClass('hidden');

		e.preventDefault();
		return false;
	});

	$(document).on('click', '.btn-add-expert', function(e) {
	    e.preventDefault();

	    var toClone = '<div class="col-xs-10 entryExpert input-group">'+
						'<div class="col-xs-4">'+
							'<label class="col-form-label" style="text-align: right;">Especialidades</label>'+
						'</div>'+
						'<div class="col-xs-5">'+
						'<select class="form-control expertiseSelect" type="text" name="expertise[]">'+
							'<option value="0"> Sem especialidades </option>'+
							'<?php $__currentLoopData = $expertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>'+
							'<?php if($expert->parent == 0): ?>' +
							'<option value="<?php echo e($expert->id); ?>"> <?php echo e($expert->name); ?> </option>'+
							'<?php endif; ?>' +
							'<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>'+
						'</select>'+
						'</div>'+
						'<div class="col-xs-1" style="padding-left: 0; margin: 0;">'+
						'<span class="input-group-btn">'+
	                        '<button class="btn btn-success btn-add-expert" type="button">'+
	                            '<span class="glyphicon glyphicon-plus">Esp.</span>'+
	                        '</button>'+
	                    '</span>'+
	                    '<span class="input-group-btn">'+
	                        '<button class="btn btn-success btn-add-subexpert" type="button">'+
	                            '<span class="glyphicon glyphicon-plus">Sub.</span>'+
	                        '</button>'+
	                    '</span>'+
	                    '</div>'+
	                    '<div class="subexpertise">'+
	                    	
	                    '</div>'+
	                '</div>';

	    var controlForm = $('.controls .expertise:first'),
	        currentEntry = $(this).parents('.entryExpert:first'),
	        newEntry = $(toClone).appendTo(controlForm);

	   	newEntry.find('label').addClass('hidden');

	    newEntry.find('input').val('');
	    controlForm.find('.entryExpert:not(:last) .btn-add-expert')
	        .removeClass('btn-add-expert').addClass('btn-remove-expert')
	        .removeClass('btn-success').addClass('btn-danger')
	        .html('<span class="glyphicon glyphicon-minus"></span>');
	}).on('click', '.btn-remove-expert', function(e) {
		$(this).parents('.entryExpert:first').remove();
		$('.controls .expertise:first').find('label:first').removeClass('hidden');

		e.preventDefault();
		return false;
	});

	$(document).on('click', '.btn-add-subexpert', function(e) {
	    e.preventDefault();

	    var value = $(this).parent().parent().parent().find('.expertiseSelect').val();
	    if(value == undefined) {
	    	value = $(this).parent().parent().parent().parent().parent().find('.expertiseSelect').val();
	    }
	    var toClone = '<div class="toClone hidden">'+
	                	'<div class="col-md-offset-2 col-xs-4">'+
						'</div>'+
						'<div class="col-xs-5">'+
						'<select class="form-control subExpertiseSelect" type="text" name="expertise[]">'+
							'<option value="0"> Sem sub-especialidades </option>'+
							'<?php $__currentLoopData = $expertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>'+
							'<?php if($expert->parent != 0): ?>'+
							'<option value="<?php echo e($expert->id); ?>" class="subOption" content="<?php echo e($expert->parent); ?>"> <?php echo e($expert->name); ?> </option>'+
							'<?php endif; ?>'+
							'<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>'+
						'</select>'+
						'</div>'+
						'<div class="col-xs-1" style="padding-left: 0; margin: 0;">'+
						'<span class="input-group-btn">'+
	                        '<button class="btn btn-success btn-add-subexpert" type="button">'+
	                            '<span class="glyphicon glyphicon-plus"></span>'+
	                        '</button>'+
	                    '</span>'+
	                    '</span>'+
	                    '</div>'+
	                    '</div>';


	    var controlForm = $(this).parent().parent().parent().find('.subexpertise');

	    if(controlForm.html() == undefined)
	    	controlForm = $(this).parent().parent().parent().parent().parent().find('.subexpertise');
	    var newEntry = $(toClone).appendTo(controlForm);

	    newEntry.find('label').addClass('hidden');
	    newEntry.parent().find('.toClone:last').removeClass('hidden');

	    newEntry.find('.subOption').each(function() {
			$(this).removeClass('hidden');
			var parent = $(this).attr('content');
			if(parent != value) {
				$(this).addClass('hidden');
			}
		});

	    newEntry.find('input').val('');
	    $('.toClone:not(:last) .btn-add-subexpert')
	        .removeClass('btn-add-subexpert').addClass('btn-remove-subexpert')
	        .removeClass('btn-success').addClass('btn-danger')
	        .html('<span class="glyphicon glyphicon-minus"></span>');
	}).on('click', '.btn-remove-subexpert', function(e) {
		$(this).parents('.toClone:first').remove();
		$('.controls .expertise:first').find('label:first').removeClass('hidden');

		e.preventDefault();
		return false;
	});

	$(document).on('change', '.expertise .expertiseSelect', function() {
		var value = this.value;
		$(this).parent().parent().find('.subOption').each(function() {
			$(this).removeClass('hidden');
			var parent = $(this).attr('content');
			if(parent != value) {
				$(this).addClass('hidden');
			}
		});
	});
});
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>