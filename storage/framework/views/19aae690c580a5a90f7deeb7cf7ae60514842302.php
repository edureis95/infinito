<?php $__env->startSection('content'); ?>
    <div class="col-xs-12" style="width: 98%;">
        <?php echo $__env->make('layouts.personal_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="panel panel-default panelMenu borderless" style="height: 69px !important;">
            <div class="panel-body link-nav" style="padding-top: 40px;">
                <span style="color: black; font-size: 20px;"><a href="/profile/<?php echo e($user->id); ?>"><?php echo e($user->name); ?></a></span>
            </div>
        </div>
        <div class="row">
            <hr style="margin-top: 0px; margin-left: 0; width: 100%;">
        </div>
        <div class="panel panel-default borderless" style="margin-top: 2%;">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-2">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="/uploads/avatars/<?php echo e($user-> avatar); ?>" class="img img-responsive" style="max-width:150px; float:left; margin-right:25px; padding:2px; border:1px solid #C0C0C0; width: 100%;">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <table>
                            <tr>
                                <th><i class="fa fa-envelope"></i> Email:</th>
                                <td><a href="mailto:<?php echo e($user->email); ?>"> <?php echo e($user->email); ?> </a></td>
                            </tr>
                            <?php if($user->sigla != ''): ?>
                            <tr>
                                <th>Sigla: </th>
                                <td><?php echo e($user->sigla); ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if($user->cell_phone  != ''): ?>
                            <tr>
                                <th><i class="fa fa-mobile"></i> Telemóvel: </th>
                                <td> <?php echo e($user->cell_phone); ?> </td>
                            </tr>
                            <?php endif; ?>

                            <?php if($user->desk_phone  != ''): ?>
                            <tr>
                                <th><i class="fa fa-phone"></i> Telefone: </th>
                                <td> <?php echo e($user->desk_phone); ?> </td>
                            </tr>
                            <?php endif; ?>

                            <?php if($user->skype  != ''): ?>
                            <tr>
                                <th><i class="fa fa-skype"></i> Skype: </th>
                                <td> <?php echo e($user->skype); ?> </td>
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
                <div class="row">
                    <div class="col-xs-2">

                    </div>
                    <div class="col-xs-6">
                        <table>
                             <?php if($userDetails != null): ?>
                            <tr>
                                <th>Morada:</th>
                                <td><?php echo e($userDetails->address); ?></td>
                            </tr>
                            <tr>
                                <th>Cód. Postal:</th>
                                <td><?php echo e($userDetails->zip_code); ?></td>
                            </tr>
                            <tr>
                                <th>Localidade:</th>
                                <td><?php echo e($userDetails->local); ?></td>
                            </tr>
                            <tr>
                                <th>NIF:</th>
                                <td><?php echo e($userDetails->nif); ?></td>
                            </tr>
                            <tr>
                                <th>NISS:</th>
                                <td><?php echo e($userDetails->niss); ?></td>
                            </tr>
                            <tr>
                                <th>IBAN:</th>
                                <td><?php echo e($userDetails->iban); ?></td>
                            </tr>
                            <tr>
                                <th>Banco:</th>
                                <td><?php echo e($userDetails->bank); ?></td>
                            </tr>
                            <tr>
                                <th>Seguro:</th>
                                <td><?php echo e($userDetails->insurance); ?></td>
                            </tr>
                            <?php endif; ?>
                        </table>
                    </div>  
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>