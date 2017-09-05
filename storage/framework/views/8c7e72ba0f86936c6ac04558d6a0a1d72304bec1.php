


<?php $__env->startSection('content'); ?>


    <div class="col-md-9" style="padding: 0%;">
        <div class="panel panel-default">
            <div class="panel-heading"><h2><?php echo e($user->name); ?></h2></div> 
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="/uploads/avatars/<?php echo e($user-> avatar); ?>" style="max-width:250px; float:left; margin-right:25px; padding:2px; border:1px solid #C0C0C0">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <table>
                            <tr>
                                <th><h5><b>Contact Information</b></h5></th>
                            </tr>
                            <tr>
                                <th><i class="fa fa-envelope"></i> Email:</th>
                                <th><a href="mailto:<?php echo e($user->email); ?>"> <?php echo e($user->email); ?> </a></th>
                            </tr>
                            <?php if($user->cell_phone  != ''): ?>
                            <tr>
                                <th><i class="fa fa-mobile"></i> Telemóvel: </th>
                                <th> <?php echo e($user->cell_phone); ?> </th>
                            </tr>
                            <?php endif; ?>

                            <?php if($user->desk_phone  != ''): ?>
                            <tr>
                                <th><i class="fa fa-phone"></i> Telefone: </th>
                                <th> <?php echo e($user->desk_phone); ?> </th>
                            </tr>
                            <?php endif; ?>

                            <?php if($user->skype  != ''): ?>
                            <tr>
                                <th><i class="fa fa-skype"></i> Skype: </th>
                                <th> <?php echo e($user->skype); ?> </th>
                            </tr>
                            <?php endif; ?>

                        </table>                            
                    </div>
                    <?php if(Auth::user()->id == $user->id): ?>
                    <div class="col-md-3">
                        <table class="table table-bordered">
                            <thead><tr><th>Ações</th></tr></thead>
                            <div class="list-group">
                                <tr><th><a href="<?php echo e(Auth::user()->id); ?>/edit" class="list-group-item list-group-action"><i class="fa fa-btn fa-pencil-square-o"> Edita o perfil</i></a></th></tr>
                            </div>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>  
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>