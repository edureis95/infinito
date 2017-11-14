

<?php $__env->startSection('content'); ?>
<div class="col-xs-12" style="max-width: 100%;">
	<?php echo $__env->make('layouts.management_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.management_company_second_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body" style="padding-left: 0;">
			<table class="table borderless" style="width: 200px;">
				<th class="text-center">Ano</th>
				<tr>
					<td>
						<select class="form-control yearFilter">
							<option value="0">Sem Filtro</option>
						</select>
					</td>
				</tr>
				<td></td>
				</tr>
				<tr>
					<td><button type="button" class="btn refreshFilter">Atualizar</button></td>
				</tr>
			</table>

			<table class="table companyDaysTable">
				<thead>
					<th class="text-center">Data/Data-Início</th>
					<th class="text-center">Data-Fim</th>
					<th class="text-center">Motivo</th>
					<th class="text-center">Descrição</th>
					<th class="text-center">Dia Único</th>
					<th class="text-center">Ação</th>
					<th class="text-center"><button style="padding: 3px 5px;" class="btn btn-primary addDay" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
				</thead>
				<tbody>
				<tr class="hiddenForm hidden text-center">
					<form action="/settings/company/calendar/addDay" method="POST">
						<td><input type="date" class="form-control" name="startDate"></td>
						<td><input type="date" class="form-control endDateInput" name="endDate"></td>
						<td><input style="margin: auto;" type="text" class="form-control" name="reason"></td>
						<td style="margin: auto;"><input type="text" class="form-control" name="description"></td>
						<td><input class="onlyDayCheckbox" type="checkbox" name="onlyDay"></td>
						<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
						<td><button type="submit" class="btn btn-primary">Inserir</button></td>
					</form>
				</tr>
				<?php $__currentLoopData = $companyDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr class="text-center companyDay">
					<?php if($day->end_date != null): ?>
						<td><?php echo e($day->start_date); ?></td>
						<td><?php echo e($day->end_date); ?></td>
					<?php else: ?>
						<td><?php echo e($day->start_date); ?></td>
						<td> - </td>
					<?php endif; ?>
					<td><?php echo e($day->reason); ?></td>
					<td><?php echo e($day->description); ?></td>
					<?php if($day->end_date != null): ?>
						<td>Não</td>
					<?php else: ?>
						<td>Sim</td>
					<?php endif; ?>
					<td><button content='<?php echo e($day->id); ?>' style="padding: 3px 5px; margin-bottom: 5px;" class="btn btn-danger removeDay" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
				</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>

function appendYears() {
	var i,yr,now = new Date();
	for (i=0; i<10; i++) {
	    yr = now.getFullYear()-5+i; // or whatever
	    $('.yearFilter').append($('<option/>').val(yr).text(yr));
	}
}

appendYears();

$('.onlyDayCheckbox').click(function() {
	if($(this).is(":checked"))
		$('.endDateInput').addClass('hidden');
	else
		$('.endDateInput').removeClass('hidden');
});

$('.addDay').click(function() {
	$('.hiddenForm').removeClass('hidden');
});

var companyDays = '';
$('.companyDay').each(function() {
	companyDays += $(this).parent().html();
});

$('.refreshFilter').click(function() {
	var year = $('.yearFilter').val();
	$.ajax({
	  type: "POST",
	  url: '/settings/company/calendar/getByYear',
	  data: {
	  	'year' : year
	  },
	  success: function(response) {
	  	$('.companyDay').remove();
	  	for(var i = 0; i < response.length; i++) {
	  		var toAppend = '<tr class="text-center companyDay"><td>' + response[i].start_date + '</td>';
	  		if(response[i].end_date != null)
	  			toAppend += '<td>' + response[i].end_date + '</td>';
	  		else
	  			toAppend += '<td> - </td>';
	  		toAppend += '<td>' + response[i].reason + '</td><td>' + response[i].description + '</td>';
	  		if(response[i].end_date != null) 
	  			toAppend += '<td> Não </td>';
	  		else 
	  			toAppend += '<td> Sim </td>';

	  		toAppend += '<td><button content="' + response[i].id + '" style="padding: 3px 5px; margin-bottom: 5px;" class="btn btn-danger removeDay" type="button"><i class="glyphicon glyphicon-minus"></i></button></td></tr>';

	  		$('.companyDaysTable tbody').append(toAppend);
	  	}
	  }
	});
})

$('.companyDaysTable').on('click', '.removeDay', function() {
	var id = $(this).attr('content');
	$(this).parent().parent().find('td').remove();
	$.get('/settings/company/calendar/removeDay/' + id, function() {
	});
});	
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>