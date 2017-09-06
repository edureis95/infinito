<?php $__env->startSection('content'); ?>


<div class="col-xs-12 insideContainer">
	<?php echo $__env->make('layouts.commercial_project_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.commercial_project_secondNav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body link-nav">
			<div class="col-xs-12">
				<table class="table phasesSelectTable smallFontTable" style="max-width: 50%; min-width: 50%; float: left;">
					<thead>
						<th></th>
						<?php $__currentLoopData = $projectPhases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<th class="text-center"><?php echo e($phase->p_sigla); ?></th>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<th class="text-center">Valor</th>
					</thead>	
					<tbody>
						<?php $__currentLoopData = $projectExpertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($expert->e_sigla); ?> - <?php echo e($expert->e_name); ?></td>
							<?php $__currentLoopData = $projectPhases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<td class="text-center" style="width: 80px;">
								<?php if($expert->phases->contains('phase_id', $phase->p_id)): ?>
								<input style="float: left;" disabled checked class="expertCheckbox" content="<?php echo e($expert->e_id); ?>" 2ndContent="<?php echo e($phase->p_id); ?>" type="checkbox">
								<?php else: ?>
								<input style="float: left;" disabled class="expertCheckbox" content="<?php echo e($expert->e_id); ?>" 2ndContent="<?php echo e($phase->p_id); ?>" type="checkbox">
								<?php endif; ?>
								<?php if($expert->phases->where("phase_id", $phase->p_id)->first() != null): ?>
								<input class="form-control input-sm text-right expertisePercentage" content='<?php echo e($expert->p_e_id); ?>' 2ndContent='<?php echo e($phase->p_id); ?>' placeholder="%" disabled style="width: 80%; float: left;" type="number" max="100" min="0" value='<?php echo e($expert->phases->where("phase_id", $phase->p_id)->first()->percentage); ?>'>
								<?php else: ?>
								<input class="form-control input-sm text-right expertisePercentage" content='<?php echo e($expert->p_e_id); ?>' 2ndContent='<?php echo e($phase->p_id); ?>' placeholder="%" disabled style="width: 80%; float: left;" type="number" max="100" min="0">
								<?php endif; ?>
							</td>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<td>
							<?php if($expert->e_value != null): ?>
								<input class="form-control input-sm text-right valueInput expert<?php echo e($expert->p_e_id); ?>" value="<?php echo e($expert->e_value); ?>" placeholder="€" disabled  type="number" min="0">
							<?php else: ?>
								<input class="form-control input-sm text-right valueInput expert<?php echo e($expert->p_e_id); ?>" placeholder="€" disabled  type="number" min="0">
							<?php endif; ?>
							</td>
							<?php $__currentLoopData = $expert->subExpertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subExpert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr class="subExpertise<?php echo e($expert->p_e_id); ?>">
								<td><span style="padding-left: 10%;"><?php echo e($subExpert->e_sigla); ?> - <?php echo e($subExpert->e_name); ?></span></td>
								<?php $__currentLoopData = $projectPhases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<td class="text-center" style="max-width: 30px;">
									<?php if($subExpert->phases->contains('phase_id', $phase->p_id)): ?>
									<input disabled checked class="expertCheckbox expertCheckbox<?php echo e($phase->p_id); ?><?php echo e($subExpert->e_parent); ?>" 2ndContent="<?php echo e($phase->p_id); ?>" content="<?php echo e($subExpert->e_id); ?>" style="float: left;" type="checkbox">
									<?php else: ?>
									<input disabled class="expertCheckbox expertCheckbox<?php echo e($phase->p_id); ?><?php echo e($subExpert->e_parent); ?>" 2ndContent="<?php echo e($phase->p_id); ?>" content="<?php echo e($subExpert->e_id); ?>" style="float: left;" type="checkbox">
									<?php endif; ?>
									<input disabled class="form-control input-sm text-right" placeholder="%" style="width: 80%; float: left;" type="number" max="100" min="0">
								</td>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td>Total</td>
							<?php $__currentLoopData = $projectPhases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<td></td>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<td><input class="form-control input-sm text-right valueTotal" placeholder="€" disabled  type="number" min="0"></td>
						</tr>
					</tbody>
				</table>
				<table class="expertiseTable hidden table table-responsive borderless smallFontTable" style="width: 40%; float: right;">
					<thead>
						<th>Especialidade</th>
						<th>Ações</th>
						<th><button style="padding: 3px 5px;" class="btn btn-primary expertiseHiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
					</thead>
					<tr class="hidden expertiseHiddenForm">
						<form action="/commercialProject/expertise/addExpertise/<?php echo e($project->id); ?>" method="POST">
							<td>
								<select class="form-control input-sm" name="expertise">
									<?php $__currentLoopData = $expertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($expert->id); ?>"><?php echo e($expert->sigla); ?> - <?php echo e($expert->name); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</td>
							<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
							<td><button type="submit" class="btn btn-primary input-sm">Inserir</button></td>
						</form>
					</tr>
					<?php $__currentLoopData = $projectExpertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td><?php echo e($expert->e_sigla); ?> - <?php echo e($expert->e_name); ?></td>
						<td data-editable='false'><button style="padding: 3px 5px;" content='<?php echo e($expert->p_e_id); ?>' class="btn btn-primary hiddenFormSubExpertButton" type="button"><i class="glyphicon glyphicon-plus"></i></button> 
						<button content='<?php echo e($expert->p_e_id); ?>' style="padding: 3px 5px;" class="btn btn-danger removeExpertise" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
						<tr class="subExpertiseForm<?php echo e($expert->p_e_id); ?> hidden">
							<form action="/commercialProject/expertise/addExpertise/<?php echo e($project->id); ?>" method="POST">
								<td style="padding-left: 40px;">
									<select class="form-control input-sm" name="expertise">
										<?php $__currentLoopData = $subExpertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subExpert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($subExpert->parent == $expert->e_id): ?>
											<option value="<?php echo e($subExpert->id); ?>"><?php echo e($subExpert->sigla); ?> - <?php echo e($subExpert->name); ?></option>
										<?php endif; ?>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</td>
								<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
								<td><button type="submit" class="btn btn-primary input-sm">Inserir</button></td>
							</form>
						</tr>
						<?php $__currentLoopData = $expert->subExpertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subExpert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr class="subExpertise<?php echo e($expert->p_e_id); ?>">
								<td style="padding-left: 40px !important;"><?php echo e($subExpert->e_sigla); ?> - <?php echo e($subExpert->e_name); ?></td>
								<td><button content='<?php echo e($subExpert->p_e_id); ?>' style="padding: 3px 5px;" class="btn btn-danger removeExpertise" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</table>
				<table class="phaseTable hidden table table-responsive borderless smallFontTable" style="width: 40%; float: right;">
					<thead>
						<th>Fase</th>
						<th>Ação</th>
						<th><button style="padding: 3px 5px;" class="btn btn-primary phasesHiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
					</thead>
					<tr class="hidden phasesHiddenForm">
						<form action="/commercialProject/phases/addPhase/<?php echo e($project->id); ?>" method="POST">
							<td>
								<select class="form-control input-sm" name="phase">
									<?php $__currentLoopData = $phases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($phase->id); ?>"><?php echo e($phase->sigla); ?> - <?php echo e($phase->name); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</td>
							<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
							<td><button type="submit" class="btn btn-primary input-sm">Inserir</button></td>
						</form>
					</tr>
					<?php $__currentLoopData = $projectPhases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td><?php echo e($phase->p_sigla); ?> - <?php echo e($phase->p_name); ?></td>
						<td data-editable='false'><button content='<?php echo e($phase->proj_p_id); ?>' style="padding: 3px 5px;" class="btn btn-danger removePhase" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
					</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</table>
				<table class="table borderless" style="width: auto; clear: left;">
					<tbody>
						<tr>
							<td>Valor s/iva</td>
							<td class="noIvaValue"><span>0</span> €</td>
						</tr>
						<tr>
							<td style="vertical-align: middle !important;">IVA</td>
							<td style="vertical-align: middle !important;">
								<select class="ivaSelect form-control input-sm">
								<?php $__currentLoopData = $iva; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ivaOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($ivaOption->id); ?>"><?php echo e($ivaOption->percentage); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</td>
						</tr>	
						<tr>
							<td>Valor c/iva</td>
							<td class="ivaValue"><span>0</span> €</td>
						</tr>
						<tr>	
							<td style="vertical-align: middle !important;">Preço (€)/h</td>
							<td style="vertical-align: middle !important;">
								<select class="hourlyRateSelect form-control input-sm">
								<?php $__currentLoopData = $hourlyRate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($rate->id); ?>"><?php echo e($rate->value); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Horas Previstas</td>
							<td class="estimatedHours"><span>0</span> h</td>
						</tr>
						<tr></tr>
						<tr>
							<td><button type="button" class="btn btn-success saveButton hidden btn-xs">Guardar</button></td>
						</tr>
					</tbody>
				</table>	
			</div>
		</div>
	</div>
</div>

<script>
$('.expertiseHiddenFormButton').click(function() {
	$('.expertiseHiddenForm').removeClass('hidden');
});

$('.phasesHiddenFormButton').click(function() {
	$('.phasesHiddenForm').removeClass('hidden');
});

$('.hiddenFormSubExpertButton').click(function() {
	var id = $(this).attr('content');
	$('.subExpertiseForm' + id).removeClass('hidden');
})

$('.removeExpertise').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().remove();
	$('.subExpertiseForm' + id).remove();
	$('.subExpertise' + id).remove();
	$.get('/project/deleteExpertise/' + id, function() {
	});
});

$('.removePhase').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().remove();
	$.get('/project/deletePhase/' + id, function() {
	});
});

$('.expertCheckbox').change(function() {
	if($(this).is(":checked")) {
		var content = $(this).attr('content');
		var secondContent = $(this).attr('2ndContent');
		$('.expertCheckbox' + secondContent + content).prop('checked', true);
	}
});

$('.saveButton').click(function() {
	var obj = {};
	$('.phasesSelectTable .expertCheckbox').each(function() {
		if($(this).is(':checked')) {
			if(obj[$(this).attr('content')] == null)
				obj[$(this).attr('content')] = new Array();
			obj[$(this).attr('content')].push($(this).attr('2ndContent'));
		} else {
			if(obj[$(this).attr('content')] == null)
				obj[$(this).attr('content')] = new Array();
			obj[$(this).attr('content')].push('-' + $(this).attr('2ndContent'));
		}
	});

	var percentages = {};
	$('.phasesSelectTable .expertisePercentage').each(function() {
		if(percentages[$(this).attr('content')] == null)
			percentages[$(this).attr('content')] = new Array();
		percentages[$(this).attr('content')].push([$(this).attr('2ndContent'), this.value]);
		
	});

	var expertValues = {};
	<?php $__currentLoopData = $projectExpertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expertise): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		var value = $('.expert<?php echo e($expertise->p_e_id); ?>').val();
		expertValues['<?php echo e($expertise->p_e_id); ?>'] = value;
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

	$.ajax({
	  type: "POST",
	  url: '/commercialProject/expertise/editExpertisePhases',
	  data: {
	  	'obj': obj,
	  	'project_id': <?php echo e($project->id); ?>,
	  	'expertValues': expertValues,
	  	'percentages': percentages
	  },
	  success: function(response) {
	  	location.reload();
	  }
	});
});

function updateValues() {
	var value = 0;
	$('.valueInput').each(function() {
		if(this.value > 0)
			value += parseInt(this.value);
	})
	$('.valueTotal').val(value);
	$('.noIvaValue span').text(value);
	var iva = $('.ivaSelect option:selected').text() / 100;
	$('.ivaValue span').text(value - (iva * value));
	$('.estimatedHours span').text($('.ivaValue span').text() / $('.hourlyRateSelect option:selected').text());
}

updateValues();

$('.valueInput').keyup(function() {
	updateValues();
})

$('.ivaSelect').change(function() {
	updateValues();
})

if(<?php echo e(Auth::user()->profile == 1); ?>) {
	$('input').each(function() {
		$(this).prop('disabled', false);
	})
	$('.valueTotal').prop('disabled', true);
	$('.expertiseTable').removeClass('hidden');
	$('.phaseTable').removeClass('hidden');
	$('.saveButton').removeClass('hidden');
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>