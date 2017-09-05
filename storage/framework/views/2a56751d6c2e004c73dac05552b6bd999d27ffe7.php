<?php $__env->startSection('content'); ?>
    <div class="col-xs-12" style="width: 98%;">
        <?php echo $__env->make('layouts.personal_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('layouts.user_profile_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="panel panel-default borderless" style="margin-top: 2%;">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-2">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="/uploads/avatars/<?php echo e($user-> avatar); ?>" style="max-width:150px; float:left; margin-right:25px; padding:2px; border:1px solid #C0C0C0">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <table>
                            <tr>
                                <th><i class="fa fa-envelope"></i> Email:</th>
                                <th><a href="mailto:<?php echo e($user->email); ?>"> <?php echo e($user->email); ?> </a></th>
                            </tr>
                            <?php if($user->sigla != ''): ?>
                            <tr>
                                <th>Sigla: </th>
                                <th><?php echo e($user->sigla); ?></th>
                            </tr>
                            <?php endif; ?>
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
                    <div class="col-md-3">
                        <table class="table table-bordered">
                            <thead><tr><th>Ações</th></tr></thead>
                            <div class="list-group">
                                <tr><th><a href="<?php echo e($user->id); ?>/edit" class="list-group-item list-group-action"><i class="fa fa-btn fa-pencil-square-o"> Edita o perfil</i></a></th></tr>
                            </div>
                        </table>
                    </div>
                </div>  
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>