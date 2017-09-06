<?php $__env->startSection('content'); ?>

<div class="col-xs-12 insideContainer">
	<?php echo $__env->make('layouts.personal_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body">
			<table class="table approvalTable smallFontTable">
				<thead>
					<th class="text-center">Início</th>
					<th class="text-center">Fim<br>Horas</th>
					<th class="text-center">Motivo</th>
					<th class="text-center" style="width: 50%;">Descrição</th>	
					<th class="text-center">Aprovado</th>
				</thead>
				<tbody>
				<?php $__currentLoopData = $absences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $absence): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr class="text-center">
						<td><?php echo e($absence->start_date); ?></td>
						<td><?php echo e($absence->end_date); ?></td>
						<td><?php echo e($absence->a_name); ?></td>
						<td class="text-left"><?php echo e($absence->text); ?></td>
						<?php if($absence->a_ap == 0): ?>
						<td class="taskWaiting">Aguarda</td>
						<?php elseif($absence->a_ap > 0): ?>
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


</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>