<?php $__env->startSection('content'); ?>

<style>
.buttonJquery {
cursor: pointer; 
	cursor: hand;
}
</style>	
<div class="col-xs-12" style="max-width: 98%;">
<?php echo $__env->make('layouts.company_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="row">
	<hr style="margin-top: 0; margin-left: 0; width: 104%; border-color: #DCDCDC;">
</div>
</div>
	<ul class="list-group">
		<li class="list-group-item borderless"> 
			<div class="row">
				<div class="col-xs-12 members">
					<div id="displaySquares" class="hidden">
					<?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-xs-4">
                    		<div class="row">
                    		<div class="col-xs-12">
                            	<img src="/uploads/avatars/<?php echo e($member->avatar); ?>" alt="" class="img img-responsive thumbnail" style="min-width:15; vertical-align: middle;max-height: 100px;">
                            </div> 
                            </div>
                            <div class="row">
                            <div class="col-xs-12">
                            	<p> <?php echo e($member->name); ?></p>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-xs-12">
                            	<p> Função: <?php echo e($member->department_name); ?> </p>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-xs-12">
								<p> Email: <?php echo e($member->email); ?></p>
							</div>
							</div>
							<?php if($member->cell_phone != ''): ?>
							<div class="row">
							<div class="col-xs-12">
								<p> Telemóvel: <?php echo e($member->cell_phone); ?> </p>
							</div>
							</div>
							<?php else: ?>
							<div class="row">
							<div class="col-xs-12">
								<p> Telemóvel: Não tem </p>
							</div>
							</div>
							<?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                    </div>       

					<table class="table table-responsive smallFontTable" style="overflow-x: scroll;" id="displayLine"> 
                        <thead> 
                            <tr>
                                <th class="text-center">Foto</th>
                                <th class="text-left">Nome</th>
                                <th class="text-left">Sigla</th>
                                <th class="text-left">Departamento</th> 
                                <th class="text-left">Função</th> 
                                <th class="text-left">Email</th>
                                <th class="text-left">Skype</th>
                                <th class="text-left">Telemóvel</th> 
                            </tr>                                     
                        </thead>                       
                        <tbody class="text-left"> 
                        <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr> 
                                <td class="text-center">
                                	<img src="/uploads/avatars/<?php echo e($member->avatar); ?>" alt="" class="" style="min-width:15; max-width: 50px; max-height: 50px;"> 	
                                </td>
                                <td>
                                    <span><?php echo e($member->name); ?></span>
                                </td>
                                <td>
                                	<span><?php echo e($member->sigla); ?></span>
                                </td>
                                <td>
                                    <span><?php echo e($member->department_name); ?></span>
                                </td>
                                <td>
                                	<span>Sem Função</span>
                                </td>
                                <td>
                                    <?php if($member->email != ''): ?>
									<span><?php echo e($member->email); ?></span>
									<?php endif; ?>
								</td>
								<td>
									<?php if($member->skype != ''): ?>
									<span><?php echo e($member->skype); ?></span>
									<?php endif; ?>
								</td>
								<td>
									<?php if($member->cell_phone != ''): ?>
									<span><?php echo e($member->cell_phone); ?> </span>
									<?php endif; ?>
								</td>                                               
                                </div>
                                </td>                                                                                                 
                                <!--<td>
                                	<?php if($member->email != ''): ?>
									<p> Email: <?php echo e($member->email); ?> </p>
									<?php endif; ?>

									<?php if($member->cell_phone != ''): ?>
									<p> Telemóvel: <?php echo e($member->cell_phone); ?> </p>
									<?php endif; ?>

									<?php if($member->desk_phone != ''): ?>
									<p> Telefone: <?php echo e($member->desk_phone); ?> </p>
									<?php endif; ?>

									<?php if($member->skype != ''): ?>
									<p> Skype: <?php echo e($member->skype); ?> </p>
									<?php endif; ?>
                                </td>
                                <td>
                                	<?php $__currentLoopData = $member->supervisors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supervisor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<p>Supervisor: <?php echo e($supervisor->name); ?></p>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<p><?php echo e($member->department_name); ?></p>
                                </td> -->
                            </tr> 
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                                                       
                        </tbody>
                    </table>
				</div>
			</div>
		</li>
	</ul>
</div>

<script>
$('#squares').click(function() {
	$('#displaySquares').removeClass('hidden');
	$('#displayLine').addClass('hidden');
});
$('#bullets').click(function() {
	$('#displayLine').removeClass('hidden');
	$('#displaySquares').addClass('hidden');
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>