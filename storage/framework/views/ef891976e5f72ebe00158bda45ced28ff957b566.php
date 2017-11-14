<?php $__env->startSection('content'); ?>


<div class="col-xs-12" style="max-width: 98%;">
	<?php echo $__env->make('managementProject.project_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('managementProject.project_second_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body link-nav" style="padding: 0;">
			<div class="col-xs-12">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h5>Descrição <button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-success editDescriptionButton pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button><button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-danger cancelEditDescription hidden pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button></h5>
					</div>
					<div class="panel-body">
						<table class="table borderless descriptionTable" style="width: auto;">
							<tr> 
								<td><b>Código:</b> <?php echo e(str_pad($project->number, 5, '0', STR_PAD_LEFT)); ?><b style="padding-left: 10px;">Nome:</b> <?php echo e($project->name); ?></td>
							</tr>
							<?php if($project->projectDetails != null): ?>
							<tr>
								<?php if($project->projectDetails->title == ""): ?>
									<td><b>Designação do Projeto: </b>Sem designação</td>
								<?php else: ?>
									<td><b>Designação do Projeto:</b> <?php echo e($project->projectDetails->title); ?></td>
								<?php endif; ?>
							</tr>
							<tr>
								<td><b>Localização do Projeto: </b><?php echo e($project->projectDetails->address == "" ? "Sem localização": $project->projectDetails->address); ?><b style="padding-left: 10px;">Código Postal: </b> <?php echo e($project->projectDetails->zip_code == "" ? "XXXX-XXX": $project->projectDetails->zip_code); ?> <b style="padding-left: 10px;">Localidade: </b><?php echo e($project->projectDetails->local == "" ? "Sem localidade": $project->projectDetails->local); ?></td>
							</tr>
							<?php else: ?>
							<tr>
								<td><b>Designação do Projeto: </b>Sem designação</td>
							</tr>
							<tr>
								<td><b>Localização do Projeto: </b>Sem localização<b style="padding-left: 10px;">Código Postal: </b> XXXX-XXX <b style="padding-left: 10px;">Localidade: </b>Sem localidade</td>
							</tr>
							<?php endif; ?>
						</table>
						<div class="editableDescription hidden">
							<table class="table borderless editTableDescription" style="width: auto;">
								<tr> 
									<td data-editable='false'><b>Código:</b></td> 
									<td class="code"><?php echo e(str_pad($project->number, 5, '0', STR_PAD_LEFT)); ?></td>
									<td data-editable='false'><b style="padding-left: 10px;"> Nome:</b></td>
									<td class="name"><?php echo e($project->name); ?></td>
								</tr>
								<tr>
									<td data-editable='false'><b>Designação do Projeto:</b></td>
									<td class="title"><?php echo e($project->title == "" ? "Sem designação": $project->title); ?></td>
								</tr>
								<tr>
									<td data-editable='false'><b>Localização do Projeto: </b></td>
									<td class="address"><?php echo e($project->address == "" ? "Sem localização": $project->address); ?></td>
									<td data-editable='false'><b style="padding-left: 10px;">Código Postal: </b></td>
									<td class="zip_code"><?php echo e($project->zip_code == "" ? "XXXX-XXX": $project->zip_code); ?></td>
									<td data-editable='false'><b style="padding-left: 10px;">Localidade: </b></td>
									<td class="local"><?php echo e($project->local == "" ? "Sem localidade": $project->local); ?></td>
								</tr>
							</table>
							<button type="button" class="btn btn-success saveDescription pull-right">Guardar</button>
						</div>
					</div>
				</div>
				<div class="panel panel-info">
					<div class="panel-heading">
						<h5>Caracterização <button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-success editButton pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button><button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-danger cancelEditButton hidden pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button></h5>
					</div>
					<div class="panel-body">
						<table class="table borderless caracterizationTable" style="width: auto;">
							<?php if($project->projectDetails != null): ?>
							<tr>
								<td><b>Tipo de Projeto:</b> <?php echo e($project->projectDetails->typeName); ?></td>
							</tr>
							<tr>
								<td><b>Tipo de Construção:</b> <?php echo e($project->projectDetails->constructionTypeName); ?><b style="padding-left: 10px;">Tipo de Utilização:</b> <?php echo e($project->projectDetails->utilizationTypeName); ?></td>
							</tr>
							<tr>
								<td><b>Nº Total de Pisos:</b> <?php echo e($project->projectDetails->totalNumberFloors); ?><b style="padding-left: 10px;">Nº de Pisos Enterrados:</b> <?php echo e($project->projectDetails->numberBuriedFloors); ?></td>
							</tr>
							<tr>
								<td><b>Área de Construção:</b> <?php echo e($project->projectDetails->constructionArea); ?> m<sup>2</sup></td>
							</tr>
							<tr>
								<td><b>Valor da obra:</b> <?php echo e($project->projectDetails->value); ?> € <b style="padding-left: 10px;">Preço/m<sup>2:</sup></b> <?php echo e($project->projectDetails->priceBySquareMeter); ?> €</td>
							</tr>
							<tr>
								<td><b>Estimado da contrução:</b> <?php echo e($project->projectDetails->value); ?> €</td>
							</tr>
							<?php else: ?>
							<tr>
								<td><b>Tipo de Projeto:</b> Sem tipo</td>
							</tr>
							<tr>
								<td><b>Tipo de Construção:</b> Sem tipo<b style="padding-left: 10px;">Tipo de Utilização:</b> Sem tipo</td>
							</tr>
							<tr>
								<td><b>Nº Total de Pisos:</b> 0<b style="padding-left: 10px;">Nº de Pisos Enterrados:</b> 0</td>
							</tr>
							<tr>
								<td><b>Área de Construção:</b> 0 m<sup>2</sup></td>
							</tr>
							<tr>
								<td><b>Valor da obra:</b> 0 €</td>
								<td><b>Preço/m<sup>2:</sup></b> 0 €</td>
							</tr>
							<tr>
								<td><b>Estimado da contrução:</b> 0 €</td>
							</tr>
							<?php endif; ?>
						</table>

						<div class="editTable hidden">
							<table class="table borderless editTable " style="width: auto;">
								<tr>
									<td data-editable='false' style="padding-top: 10px;"><b>Tipo de Projeto: </b></td>
									<td data-editable='false'>
										<select class="form-control input-sm projectTypeSelect">
											<option value="0">Sem tipo</option>
											<?php $__currentLoopData = $projectTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php if($project->projectDetails != null and $project->projectDetails->type == $type->id): ?>
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
								<?php if($project->projectDetails != null): ?>
								<tr>
									<td data-editable='false'><b>Nº Total de Pisos:</b></td> 
									<td class="totalNumberFloors"><?php echo e($project->projectDetails->totalNumberFloors); ?></td>
									<td data-editable='false'><b>Nº de Pisos Enterrados:</b></td>
									<td class="numberBuriedFloors"><?php echo e($project->projectDetails->numberBuriedFloors); ?></td>
								</tr>
								<tr>
									<td data-editable='false'><b>Área de Construção (m<sup>2</sup>):</b> <td class="constructionArea"><?php echo e($project->projectDetails->constructionArea); ?></td></td>
								</tr>
								<tr>
									<td data-editable='false'><b>Valor da obra (€):</b></td> 
									<td><?php echo e($project->projectDetails->value); ?></td>
									<td data-editable='false'><b>Preço/m<sup>2 (€):</sup></b></td>
									<td class="priceBySquareMeter"><?php echo e($project->projectDetails->priceBySquareMeter); ?></td>
								</tr>
								<tr>
									<td data-editable='false'><b>Estimado da contrução (€):</b> <td data-editable='false' class="estimatedValue"><?php echo e($project->projectDetails->estimatedValue); ?></td></td>
								</tr>
								<?php else: ?>
								<tr>
									<td data-editable='false'><b>Nº Total de Pisos:</b> <td class="totalNumberFloors">0</td>
									<td data-editable='false'><b>Nº de Pisos Enterrados:</b class="numberBuriedFloors"> <td>0</td></td>
								</tr>
								<tr>
									<td data-editable='false'><b>Área de Construção (m<sup>2</sup>):</b> <td class="constructionArea">0</td></td>
								</tr>
								<tr>
									<td data-editable='false'><b>Valor da obra (€):</b></td> 
									<td class="value">0</td>
									<td data-editable='false'><b>Preço/m<sup>2 (€):</sup></b></td>
									<td class="priceBySquareMeter">0</td>
								</tr>
								<tr>
									<td data-editable='false'><b>Estimado da contrução (€):</b> <td data-editable='false' class="estimatedValue">0</td></td>
								</tr>
								<?php endif; ?>
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

$('.editDescriptionButton').click(function() {
	$(this).addClass('hidden');
	$('.cancelEditDescription').removeClass('hidden');
	$('.editableDescription').removeClass('hidden');
	$('.descriptionTable').addClass('hidden');
});

$('.cancelEditDescription').click(function() {
	$(this).addClass('hidden');
	$('.editDescriptionButton').removeClass('hidden');
	$('.editableDescription').addClass('hidden');
	$('.descriptionTable').removeClass('hidden');
});

$('.editTable').editableTableWidget();

$('.editTableDescription').editableTableWidget();

$('.constructionArea').change(function() {
	$('.estimatedValue').text($('.constructionArea').text() * $('.priceBySquareMeter').text());
});

$('.priceBySquareMeter').change(function() {
	$('.estimatedValue').text($('.constructionArea').text() * $('.priceBySquareMeter').text());
});

$('.saveButton').click(function() {
	var id = <?php echo e($project->id); ?>;
	var projectType = $('.projectTypeSelect').val();
	var constructionType = $('.constructionTypeSelect').val();
	var utilizationType = $('.utilizationTypeSelect').val();
	var totalNumberFloors = $('.totalNumberFloors').text();
	var numberBuriedFloors = $('.numberBuriedFloors').text();
	var constructionArea = $('.constructionArea').text();
	var value = $('.value').text();
	var priceBySquareMeter = $('.priceBySquareMeter').text();
	var estimatedValue = $('.estimatedValue').text();

	$.ajax({
		type: 'POST',
		url: '/commercialProject/editCaracterization',
		data: {
			'id': id,
			'projectType': projectType,
			'constructionType': constructionType,
			'utilizationType': utilizationType,
			'totalNumberFloors': totalNumberFloors,
			'numberBuriedFloors': numberBuriedFloors,
			'constructionArea': constructionArea,
			'value': value,
			'priceBySquareMeter': priceBySquareMeter,
			'estimatedValue': estimatedValue
		},
		success: function() {
			location.reload();
		},
		error: function() {
			location.reload();
		}
	});
});



$('.saveDescription').click(function() {
	var id = <?php echo e($project->id); ?>;
	var code = $('.code').text();
	var name = $('.name').text();
	var address = $('.address').text();
	var title = $('.title').text();
	var zip_code = $('.zip_code').text();
	var local = $('.local').text();

	$.ajax({
		type: 'POST',
		url: '/commercialProject/editDescription',
		data: {
			'id': id,
			'code': code,
			'name': name,
			'address': address,
			'title': title,
			'zip_code': zip_code,
			'local': local
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