<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/datepicker-pt.js"></script>
<div id="myNav" class="overlay">

  <!-- Button to close the overlay navigation -->
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <div class="panel panel-default" style="margin-top: 8%;">
  	<div class="panel-info">
  		<div class="panel-heading">
  			<h5>
  				<span class="overlayTaskName"></span>
  				<button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-success editDescriptionButton pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button><button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-danger cancelEditDescription hidden pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button>
  			</h5>
  		</div>
  		<div class="panel-body">
  			<div class="summernoteOverlay">

  			</div>
  			<table class="table borderless descriptionTable" style="width: auto;">
  				<tr>
  					<td><b>Feito Por: </b></td>
  					<td class="overlayUser"></td>
  				</tr>
  				<tr>
  					<td> <b>Data: </b> </td>
  					<td class="overlayDate">-</td>
  				</tr>
  				<tr>
  					<td> <b>Tipo: </b> </td>
  					<td class="overlayType">-</td>
  				</tr>
  				<tr>
	  				<td> <b>Especialidade: </b></td>
	  				<td class="overlayExpertise">-</td>
	  				<td> <b>Sub-Especialidade: </b></td>
	  				<td class="overlaySubExpertise">-</td>
	  				<td> <b>Fase: </b></td>
	  				<td class="overlayPhase">-</td>
  				</tr>
  				<tr>
  					<td>
  						<b>Tempo: </b>
  					</td>
  					<td>
  						<span class="overlayHours"></span><span class="overlayMinutes"></span>
  					</td>
  				</tr>
  			</table>
  			<div class="editTable hidden">
	  			<table class="table borderless" style="width: auto;">
					<tr>
	  					<td><b>Feito Por: </b></td>
	  					<td class="">
	  						<select disabled class="form-control input-sm userSelect">
								<option value="<?php echo e(Auth::user()->id); ?>"><?php echo e(Auth::user()->sigla); ?></option>
	  						</select>
	  					</td>
	  				</tr>
	  				<tr>
	  					<td> <b>Data: </b> </td>
	  					<td><input type="text" required class="input-sm form-control datepicker overlayDatePicker" name="start_date"></td>
	  				</tr>
	  				<tr>
	  					<td> <b>Tipo: </b> </td>
	  					<td>
	  						<select name="type" disabled class="typeSelect input-sm form-control">
								<option value="6">Tarefa</option>
							</select>
	  					</td>
	  				</tr>
	  				<tr>
		  				<td> <b>Especialidade: </b></td>
		  				<td class="">
		  					<select disabled name="expertise" class="input-sm form-control expertiseSelect">
								<option value="0">Sem Especialidade</option>
								<?php $__currentLoopData = $expertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option content="<?php echo e($expert->proj_e_id); ?>" value="<?php echo e($expert->id); ?>"><?php echo e($expert->name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
		  				</td>
		  				<td> <b>Sub-Especialidade: </b></td>
		  				<td class="">
		  					<select disabled name="subExpertise" class="input-sm form-control subExpertiseSelect">
								<option value="0">Sem Sub-especialidade</option>
								<?php $__currentLoopData = $subExpertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option class="hidden parent parent<?php echo e($expert->parent); ?>" value="<?php echo e($expert->id); ?>"><?php echo e($expert->name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
		  				</td>
		  				<td> <b>Fase: </b></td>
		  				<td class="">
		  					<select disabled name="phase" class="input-sm form-control phaseSelect">
								<option value="0">Sem Fase</option>
							</select>
		  				</td>
	  				</tr>
	  				<tr>
	  					<td>
	  						<b>Tempo: </b>
	  					</td>
	  					<td>
	  						<input class="form-control overlayHoursInput" type="number" min="0" style="float:left; width: 70px;"> 
	  						<span style="float: left; margin-left: 5px; margin-top: 5px; margin-right: 5px;">:</span> 
	  						<input class="form-control overlayMinutesInput" style="float:left; width: 70px;" type="number" min="0">
	  					</td>
	  				</tr>
				</table>
				<button type="button" class="saveTask btn btn-success pull-right">Guardar</button>
				<button type="button" class="btn btn-danger pull-right removeTask" style="margin-right: 10px;">Eliminar Registo</button>
			</div>
  		</div>
  	</div>
  </div>

</div>


<div class="col-xs-12" style="max-width: 98%;">
	<?php echo $__env->make('layouts.personal_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body" style="padding-left: 0;">
			<table class="table approvalTable smallFontTable">
				<thead>
					<th class="text-center">Data</th>
					<th class="text-center">Área</th>
					<th class="text-left">Projeto</th>
					<th class="text-center">Esp.</th>
					<th class="text-center">Fase</th>
					<th class="text-center" style="width: 50%;">Descrição</th>
					<th class="text-center">Tempo</th>
					<th class="text-center">%</th>
					<th class="text-center">Aprovado</th>	
				</thead>
				<tbody>
				<?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr class="text-center">
						<td class="taskId hidden"><?php echo e($task->t_id); ?></td>
						<td><?php echo e($task->t_date); ?></td>
						<td>Área</td>
						<td class="text-left"><?php echo e(sprintf('%05d', $task->p_number)); ?> - <?php echo e($task->p_name); ?></td>
						<td><?php echo e($task->e_sigla); ?></td>
						<td><?php echo e($task->ph_sigla); ?></td>
						<td class="text-left openTaskLayer buttonCursor"><?php echo e($task->t_name); ?></td>
						<td><?php echo e(sprintf('%02d', $task->t_hours)); ?>:<?php echo e(sprintf('%02d', $task->t_min)); ?></td>
						<?php if($task->outdated == 1): ?>
						<td><?php echo e($task->done); ?></td>
						<?php elseif($task->done < 25): ?>
						<td style="background-color: red; color:white;"><?php echo e($task->done); ?></td>
						<?php elseif($task->done < 75): ?>
						<td style="background-color: orange; color:white;"><?php echo e($task->done); ?></td>
						<?php elseif($task->done < 100): ?>
						<td style="background-color: green; color:white;"><?php echo e($task->done); ?></td>
						<?php else: ?>
						<td style="background-color: #39B1F0; color:white;"><?php echo e($task->done); ?></td>
						<?php endif; ?>	
						<?php if($task->approved == 0): ?>
							<td class="taskWaiting">Aguarda</td>
						<?php elseif($task->approved > 0): ?>
							<td class="taskApproved">Sim</td>
						<?php else: ?>
							<td class="taskNotApproved">Não</td>
						<?php endif; ?>
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>

$(document).ready(function() {
	$( function() {
		$( ".datepicker" ).datepicker();
	    $( ".datepicker" ).datepicker("option", "dateFormat",'yy-mm-dd');
	});
});

var idClicked  = null;

$('.removeTask').click(function() {
	var approved = $(this).attr('approved');
	if(approved == 1)
		alert('Este registo já foi aprovado, não o podes apagar!');
	else {
		var txt;
		var r = confirm("Tem a certeza que quer eliminar este registo?");
		if (r == true) {
			$.ajax({
		      type: "POST",
		      url: '/removeTaskTimer',
		      data: {
		        'id' : idClicked
		      },
		      success: function() {
		        location.reload();
		      }
		    });
		} else {
		   
		}
	}
})

$('.openTaskLayer').click(function() {
	$('.overlayTaskName').text('-');
	$('.overlayDate').text('-');
	$('.overlayUser').text('-');
	$('.overlayExpertise').text('-');
	$('.overlayPhase').text('-');
	$('.overlaySubExpertise').text('-');
	$('.overlayType').text('-');
	idClicked = $(this).closest('tr').find('.taskId').text();
	$.ajax({
      type: "POST",
      url: '/personal/hoursApproval/getApprovalDetail',
      data: {
        'id' : idClicked,
      },
      success: function(response) {
      		console.log(response);
      		$('#myNav').css('width', 'calc(96% - 200px)');
      		$('.overlayTaskName').text(response.name);
			$('.overlayDate').text(response.start_date);
			$('.overlayUser').text('<?php echo e(Auth::user()->name); ?>');
			$('.overlayExpertise').text(response.expertiseSigla);
			$('.overlayPhase').text(response.phaseSigla);
			$('.overlayHours').text(response.hours + ' horas');
			$('.overlayMinutes').text(' ' + response.minutes + ' e minutos');
			$('.overlayHoursInput').val(response.hours);
			$('.overlayMinutesInput').val(response.minutes);
			if(response.subExpertiseSigla != null)
				$('.overlaySubExpertise').text(response.subExpertiseSigla);
			$('.overlayType').text('Tarefa');
			$('.overlayDatePicker').val(response.start_date);

			$('.editTable .expertiseSelect option[value="0"]').prop('selected', true);
			$('.editTable .subExpertiseSelect option[value="0"]').prop('selected', true);
			$('.editTable .phaseSelect option[value="0"]').prop('selected', true);

			$('.editTable .userSelect option[value="' + response.user_id + '"]').prop('selected', true);
			$('.editTable .typeSelect option[value="' + response.type_id + '"]').prop('selected', true);
			$('.editTable .expertiseSelect option[value="' + response.expertise_id + '"]').prop('selected', true);
			appendPhaseToLayer(response.phase_id);
			$('.editTable .subExpertiseSelect option[value="' + response.subexpertise_id + '"]').prop('selected', true);
			$('.removeTask').attr('approved', response.approved);
      	}
      });
});

$('.saveTask').click(function() {
	var date = $('.editTable .overlayDatePicker').val();
	var hours = $('.editTable .overlayHoursInput').val();
	var minutes = $('.editTable .overlayMinutesInput').val();
	var id = idClicked;
	$.ajax({
      type: "POST",
      url: '/personal/hoursApproval/editApproval',
      data: {
        'id' : id,
        'date': date,
        'hours': hours,
        'minutes': minutes
      },
      success: function() {
        location.reload();
      }
    });
});

$('.editDescriptionButton').click(function() {
	$(this).addClass('hidden');
	$('.cancelEditDescription').removeClass('hidden');
	$('.editTable').removeClass('hidden');
	$('.descriptionTable').addClass('hidden');
});

$('.cancelEditDescription').click(function() {
	$(this).addClass('hidden');
	$('.editDescriptionButton').removeClass('hidden');
	$('.editTable').addClass('hidden');
	$('.descriptionTable').removeClass('hidden');
})

$('.editTable .expertiseSelect').change(function() {
	$('.editTable .subExpertiseSelect option[value="0"]').prop('selected', true);
	$('.editTable .phaseSelect').empty();
    $('.editTable .phaseSelect').append('<option value="0">Sem Fase</option>');
	appendPhaseToLayer(null);
});

function appendPhaseToLayer(phase_id) {
	var content = $('.editTable .expertiseSelect').find(":selected").attr('content');
	var value = $('.editTable .expertiseSelect').val();
	$('.editTable .subExpertiseSelect .parent').each(function() {
		$(this).addClass('hidden');
		if($(this).hasClass('parent' + value)) {
			$(this).removeClass('hidden');
		}
	});
	if(content != undefined) {
		$.ajax({
	      type: "POST",
	      url: '/getExpertisePhasesFromProject',
	      data: {
	        'project_expertise_id' : content
	      },
	      success: function(response) {
	        $('.editTable .phaseSelect').empty();
	        $('.editTable .phaseSelect').append('<option value="0">Sem Fase</option>');
	        for(var i = 0; i < response.length; i++) {
	            $('.editTable .phaseSelect').append('<option value="' + response[i].id + '">' + response[i].name + '</option>' );
	        }
	        if(phase_id != null)
	        	$('.editTable .phaseSelect option[value="' + phase_id + '"]').prop('selected', true);
	      }
	    });
	}
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
    document.getElementById("myNav").style.width = "0%";
}

</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>