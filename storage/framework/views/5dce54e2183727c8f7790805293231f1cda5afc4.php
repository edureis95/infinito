<?php $__env->startSection('content'); ?>


<div class="col-xs-12" style="max-width: 98%;">
	<?php echo $__env->make('layouts.project_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.project_second_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body link-nav" style="padding: 0;">
			<div class="col-xs-12">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h5>Descrição</h5>
					</div>
					<div class="panel-body">
						<table class="table borderless" style="width: auto;">
							<tr> 
								<td><b>Código:</b> <?php echo e(str_pad($project->number, 5, '0', STR_PAD_LEFT)); ?><b style="padding-left: 10px;">Nome:</b> <?php echo e($project->name); ?></td>
							</tr>
							<tr>
								<td><b>Designação do Projeto:</b> <?php echo e($project->title); ?></td>
							</tr>
							<tr>
								<td><b>Localização do Projeto: </b><?php echo e($project->address); ?><b style="padding-left: 10px;">Código Postal: </b> <?php echo e($project->zip_code); ?> <b style="padding-left: 10px;">Localidade: </b><?php echo e($project->local); ?></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="panel panel-info">
					<div class="panel-heading">
						<h5>Caracterização <button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-success editButton pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button><button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-danger cancelEditButton hidden pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button></h5>
					</div>
					<div class="panel-body">
						<table class="table borderless caracterizationTable" style="width: auto;">
							<tr>
								<td><b>Tipo de Projeto:</b> <?php echo e($project->typeName); ?></td>
							</tr>
							<?php if($project->projectDetails != null): ?>
							<tr>
								<td><b>Tipo de Construção:</b> <?php echo e($project->projectDetails->constructionTypeName); ?><b style="padding-left: 10px;">Tipo de Utilização:</b> <?php echo e($project->projectDetails->utilizationTypeName); ?></td>
							</tr>
							<tr>
								<td><b>Nº Total de Pisos:</b> <?php echo e($project->projectDetails->totalNumberFloors); ?><b style="padding-left: 10px;">Nº de Pisos Enterrados:</b> <?php echo e($project->projectDetails->numberBuriedFloors); ?></td>
							</tr>
							<?php endif; ?>
							<tr>
								<td><b>Área de Construção:</b> <?php echo e($project->constructionArea); ?> m<sup>2</sup></td>
							</tr>
							<tr>
								<td><b>Área Total de Projeto:</b> <?php echo e($project->totalArea); ?> m<sup>2</sup></td>
							</tr>
							<tr>
								<td><b>Estimado da contrução:</b> <?php echo e($project->value); ?> €</td>
							</tr>
						</table>

						<div class="editTable hidden">
							<table class="table borderless editTable " style="width: auto;">
								<tr>
									<td data-editable='false' style="padding-top: 10px;"><b>Tipo de Projeto: </b></td>
									<td data-editable='false'>
										<select class="form-control input-sm projectTypeSelect">
											<option value="0">Sem tipo</option>
											<?php $__currentLoopData = $projectTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php if($project->type == $type->id): ?>
													<option selected value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
												<?php else: ?>
													<option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
												<?php endif; ?>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</select>
									</td>
								</tr>
								<tr>
									<td data-editable='false' style="padding-top: 10px;"><b>Tipo de Construção: </b></td>
									<td data-editable='false'>
										<select class="form-control input-sm constructionTypeSelect">
											<option value="0">Sem tipo</option>
											<?php $__currentLoopData = $constructionTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php if($project->projectDetails != null and $project->projectDetails->constructionType == $type->id): ?>
													<option selected value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
												<?php else: ?>
													<option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
												<?php endif; ?>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</select>
									</td>

									<td data-editable='false' style="padding-top: 10px;"><b>Tipo de Utilização: </b></td>
									<td data-editable='false'>
										<select class="form-control input-sm utilizationTypeSelect">
											<option value="0">Sem tipo</option>
											<?php $__currentLoopData = $utilizationTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php if($project->projectDetails != null and $project->projectDetails->utilizationType == $type->id): ?>
													<option selected value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
												<?php else: ?>
													<option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
												<?php endif; ?>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</select>
									</td>
								</tr>
								<tr>
								<?php if($project->projectDetails != null): ?>
									<td data-editable='false'><b>Nº Total de Pisos:</b> <td class="totalNumberFloors"><?php echo e($project->projectDetails->totalNumberFloors); ?></td>
									<td data-editable='false'><b>Nº de Pisos Enterrados:</b> <td class="numberBuriedFloors"><?php echo e($project->projectDetails->numberBuriedFloors); ?></td></td>
								<?php else: ?>
									<td data-editable='false'><b>Nº Total de Pisos:</b> <td class="totalNumberFloors">0</td>
									<td data-editable='false'><b>Nº de Pisos Enterrados:</b class="numberBuriedFloors"> <td>0</td></td>
								<?php endif; ?>
								</tr>
								<tr>
									<td data-editable='false'><b>Área de Construção (m<sup>2</sup>):</b> <td class="constructionArea"><?php echo e($project->constructionArea); ?></td></td>
								</tr>
								<tr>
									<td data-editable='false'><b>Área Total de Projeto (m<sup>2</sup>):</b> <td class="totalArea"><?php echo e($project->totalArea); ?></td></td>
								</tr>
								<tr>
									<td data-editable='false'><b>Estimado da contrução (€):</b> <td class="value"><?php echo e($project->value); ?></td></td>
								</tr>
							</table>
							<button type="button" class="btn btn-success saveButton pull-right">Guardar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$('.editButton').click(function() {
	$(this).addClass('hidden');
	$('.cancelEditButton').removeClass('hidden');
	$('.editTable').removeClass('hidden');
	$('.caracterizationTable').addClass('hidden');
});

$('.cancelEditButton').click(function() {
	$(this).addClass('hidden');
	$('.editButton').removeClass('hidden');
	$('.editTable').addClass('hidden');
	$('.caracterizationTable').removeClass('hidden');
});

$('.editTable').editableTableWidget();

$('.saveButton').click(function() {
	var id = <?php echo e($project->id); ?>;
	var projectType = $('.projectTypeSelect').val();
	var constructionType = $('.constructionTypeSelect').val();
	var utilizationType = $('.utilizationTypeSelect').val();
	var totalNumberFloors = $('.totalNumberFloors').text();
	var numberBuriedFloors = $('.numberBuriedFloors').text();
	var constructionArea = $('.constructionArea').text();
	var totalArea = $('.totalArea').text();
	var value = $('.value').text();

	$.ajax({
		type: 'POST',
		url: '/project/editCaracterization',
		data: {
			'id': id,
			'projectType': projectType,
			'constructionType': constructionType,
			'utilizationType': utilizationType,
			'totalNumberFloors': totalNumberFloors,
			'numberBuriedFloors': numberBuriedFloors,
			'constructionArea': constructionArea,
			'totalArea': totalArea,
			'value': value
		},
		success: function() {
			location.reload();
		},
		error: function() {
			location.reload();
		}
	});
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>