<?php $__env->startSection('content'); ?>
<style>
.editClientTable tr {
	vertical-align: middle !important;
}
.editClientTable td {
	vertical-align: middle !important;
}
</style>
<div class="col-xs-12 insideContainer">
	<?php echo $__env->make('layouts.commercial_project_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.commercial_project_secondNav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default">
		<div class="panel-heading smallPanelHeading">
			<h5>Detalhes <button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-success editClient pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button><button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-danger cancelEditClient hidden pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button></h5>
		</div>
		<div class="panel-body">
			<table class="table borderless clientTable" style="width: auto;">
				<?php if($client != null): ?>
				<tr>
					<td><b>Nome do cliente:</b></td>
					<td><?php echo e($client->contact->firstName); ?> <?php echo e($client->contact->lastName); ?></td>
				</tr>
				<tr>
					<td><b>Morada:</b></td>
					<td><?php echo e($client->contact->address != null ? $client->contact->address : '-'); ?></td>

					<td><b>Cód-Postal:</b></td>
					<td><?php echo e($client->contact->zip_code != null ? $client->contact->zip_code : '-'); ?></td>
				</tr>
				<tr>
					<td><b>Localidade:</b></td>
					<td><?php echo e($client->contact->city != null ? $client->contact->city : '-'); ?></td>

					<td><b>País:</b></td>
					<td><?php echo e($client->contact->country != null ? $client->contact->country : '-'); ?></td>
				</tr>
				<tr>
					<td><b>Pessoa responsável:</b></td>
					<td><?php echo e($client->r_name); ?></td>
				</tr>
				<?php else: ?>
				<tr>
					<td>Nome do cliente:</td>
					<td>Sem cliente</td>
				</tr>
				<?php endif; ?>
			</table>

			<table class="table borderless editClientTable hidden" style="width: auto;">
				<tr>
					<td>Nome do cliente:</td>
					<td>
						<select class="form-control input-sm clientSelect">
						<?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option value="<?php echo e($contact->id); ?>"><?php echo e($contact->firstName); ?> <?php echo e($contact->lastName); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Pessoa Responsável:</td>
					<td>
						<select class="form-control input-sm responsibleSelect">
						<?php $__currentLoopData = $usersList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
					</td>
				</tr>
				<tr></tr>
				<tr>
					<td><button type="button" class="saveClient btn btn-success btn-xs">Guardar</button></td>
				</tr>
			</table>
		</div>
	</div>
</div>

<script>
$('.saveClient').click(function() {
	$.ajax({
		method: 'POST',
		url: '/commercialProject/client/savePersonalClient',
		data: {
			'project_id': '<?php echo e($project->id); ?>',
			'client_id': $('.clientSelect').val(),
			'responsible_id': $('.responsibleSelect').val()
		},
		success: function() {
			location.reload();
		}
	})
})

$('.editClient').click(function() {
	$(this).addClass('hidden');
	$('.editClientTable').removeClass('hidden');
	$('.clientTable').addClass('hidden');
	$('.cancelEditClient').removeClass('hidden');

})
$('.cancelEditClient').click(function() {
	$(this).addClass('hidden');
	$('.editClientTable').addClass('hidden');
	$('.clientTable').removeClass('hidden');
	$('.editClient').removeClass('hidden');
})
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>