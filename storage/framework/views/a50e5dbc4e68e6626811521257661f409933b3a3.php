

<?php $__env->startSection('content'); ?>

	<style>
	.buttonJquery {
		cursor: pointer; 
      	cursor: hand;
	}
	</style>	
	<div class="col-lg-11" style="padding: 0%;">
		<?php echo $__env->make('layouts.company_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<div class="row" style="padding-bottom: 1%;">
			<div class="col-xs-2 pull-right">
					<div class="row">
						<div class="col-xs-12">
							<img src="/images/bullets-icon.png" class="img-responsive pull-left buttonJquery" id="bullets" style="width: 33%;">
							<img src="/images/blue-slash.png" class="img-responsive pull-left" style="width: 20px; height: 45px;">
							<img src="/images/squares-icon.png" class="img-responsive pull-left buttonJquery" id="squares" style="width: 33%;">
						</div>
					</div>
			</div>
		</div>
		<div class="panel panel-default">
				<ul class="list-group">
					<li class="list-group-item"> 
						<div class="row">
							<div class="col-xs-12 members">

							<div id="displaySquares" class="hidden">
							<?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-xs-4">
                            	<a href="#" class=""> 
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

                                </a>       
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                            </div>       

							<table class="table borderless table-responsive" style="width:auto;overflow-x: scroll;" id="displayLine"> 
                                <thead> 
                                    <tr>
                                    	<th></th>
                                        <th>Nome</th> 
                                        <th>Função</th> 
                                        <th>Email</th>
                                        <th>Telemóvel</th> 
                                    </tr>                                     
                                </thead>                       
                                <tbody> 
                                <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr> 
                                    	
                                    	<td>
                                        	<img src="/uploads/avatars/<?php echo e($member->avatar); ?>" alt="" class="" style="min-width:15; max-width: 50px;"> 	
                                        </td>
                                        <td>
                                            <span><?php echo e($member->name); ?></span>
                                        </td>
                                        <td>
                                            <span><?php echo e($member->department_name); ?></span>
                                        </td>
                                        <td>
                                            <?php if($member->email != ''): ?>
											<span><?php echo e($member->email); ?></span>
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