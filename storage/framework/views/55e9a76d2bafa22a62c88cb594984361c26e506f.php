<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'elementofinito')); ?></title>

    <link rel="icon" type="image/png" href="/images/logo-icon.png" sizes="16x16">
    <!-- for IE -->
    <link rel="icon" type="image/x-icon" href="/images/logo-icon.png" >

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <!-- Styles -->
    <link href="/css/jquery.orgchart.css" rel="stylesheet" />
    <link href="/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/fileinput.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="/css/metisMenu.min.css" rel="stylesheet">
    <link href="/css/summernote.css" rel="stylesheet">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Custom CSS -->
    <link href="/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/css/morris.css" rel="stylesheet">

    <link href="/css/bootstrap-formhelpers.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css"/>
    <link href="/css/css.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/overlayLayer.css">
    <link rel="stylesheet" href="/css/print.css" media="print">
    <link rel="stylesheet" href="/css/nonResponsive.css">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
    </script>

    <script src="/js/jquery-3.1.1.min.js"></script>
    <script src="/js/app.js"></script>
    <script src="/js/select2.full.min.js"></script>
    <script src="/js/fileinput.min.js"></script>
    <script src="/themes/fa/theme.js"></script>
    <script src="/js/locales/pt.js"></script>
    <script src="/js/jqueryUsage.js"></script>
    <script src="/js/mindmup-editabletable.js"></script>
    <script src="//js.pusher.com/3.0/pusher.min.js"></script>
    <script src="/js/jquery.orgchart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="/js/metisMenu.min.js"></script>
    <script src="/js/bootstrap-formhelpers.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="/js/raphael.min.js"></script>
    <script src="/js/morris.min.js"></script>
    <script src="/js/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="/js/sb-admin-2.js"></script>

    <!-- include summernote css/js-->
    <script src="/js/summernote.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="/js/datepicker-pt.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js"></script>

    <script>
         var pusher = new Pusher('<?php echo e(env("PUSHER_KEY")); ?>', {
            cluster: 'eu',
        });
    </script>

</head>
<body>
<div class="container">
</div>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default main-navbar navbar-fixed-top" id="main-nav" role="navigation" style="margin-bottom: 0; border: none;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Branding Image -->
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>" style="padding-top: 5px; padding-bottom: 0;">
                    <img src="/images/logo-navbar-white.png" style="width:120px; margin-top: 5px;">
                </a>
            </div>
            <!-- /.navbar-header -->

            
            <ul class="nav navbar-top-links navbar-right">
                <?php if(!Auth::guest()): ?>

                <?php if(Auth::user()->type != 0): ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="time"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-form">
                        
                        <li>
                        <div class="col-xs-10">
                            <form class="form-horizontal randomTaskForm smallForm" action="/saveTaskTime" method="POST" role="form">
                              <div class="form-group">
                                <label for="input1" class="col-xs-3 control-label">Colaborador</label>
                                <div class="col-xs-9">
                                  <select class="form-control" name="assignedTo">
                                        <?php $__currentLoopData = $usersList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(Auth::user()->id == $user->id): ?>
                                            <option selected value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="input1" class="col-xs-3 control-label">Projeto</label>
                                <div class="col-xs-9">
                                  <select class="form-control select2 projectTime" style="width: 100%;" type="text" name="project">
                                        <?php $__currentLoopData = $projectsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($project->id); ?>"><?php echo e(str_pad($project->number, 5, '0', STR_PAD_LEFT)); ?> - <?php echo e($project->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="input2" class="col-xs-3 control-label">Especialidade</label>
                                <div class="col-xs-9">
                                    <select class="form-control expertiseTime" type="text" name="expertise">
                                        
                                    </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="input2" class="col-xs-3 control-label">Fase</label>
                                <div class="col-xs-9">
                                    <select class="form-control phaseTime" type="text" name="phase">
                                        
                                    </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="input2" class="col-xs-3 control-label">Sub-Esp.</label>
                                <div class="col-xs-9">
                                    <select class="form-control subexpertiseTime" type="text" name="subexpertise">
                                        <option value="0">Sem SE</option>
                                    </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="input2" class="col-xs-3 control-label">Tarefa</label>
                                <div class="col-xs-9">
                                    <input required class="form-control" type="text" name="task" placeholder="Nome da tarefa">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="input2" class="col-xs-3 control-label">Data</label>
                                <div class="col-xs-9">
                                    <input class="form-control currentDate" name="date" type="date">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="input2" class="col-xs-3 control-label">Tempo</label>
                                    <div class="col-xs-9">
                                        <input style="float: left; max-width: 60px;" required class="form-control" type="number" min="0" name="hours" value="00" placeholder="horas">
                                        <span style="float: left; margin-right: 2px; margin-left: 2px; padding-top: 2%;"> : </span>
                                        <input style="max-width: 60px;" required class="form-control" type="number" min="0" name="minutes" value="00" placeholder="min">
                                    </div>
                              </div>
                              <div class="form-group">
                                <label for="input2" class="col-xs-3 control-label">%</label>
                                <div class="col-xs-3">
                                    <input class="form-control" name="conclusion" type="number" min="1" max="100" value="1">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-xs-3 pull-right"><button type="submit" class="btn btn-primary">Guardar</button></label>
                              </div>
                              <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                            </form>

                            <form class="form-horizontal hidden programmedTaskForm smallForm" action="/saveProgrammedTaskTime" method="POST" role="form">
                            <div class="form-group">
                                <label for="input1" class="col-xs-3 control-label">Colaborador</label>
                                <div class="col-xs-9">
                                  <select class="form-control assignedToSelect" name="assignedTo">
                                        <?php $__currentLoopData = $usersList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(Auth::user()->id == $user->id): ?>
                                            <option selected value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                              <div class="form-group">
                                <label for="input1" class="col-xs-3 control-label">Projeto</label>
                                <div class="col-xs-9">
                                  <select class="form-control select2 programmedTaskProjectTime" style="width: 100%;" type="text" name="project">
                                        <?php $__currentLoopData = $projectsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($project->id); ?>"><?php echo e(str_pad($project->number, 5, '0', STR_PAD_LEFT)); ?> - <?php echo e($project->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="input2" class="col-xs-3 control-label">Tarefa</label>
                                <div class="col-xs-9">
                                    <select class="form-control programmedTaskChoice" required type="text" name="task">
                                        
                                    </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="input2" class="col-xs-3 control-label">Data</label>
                                <div class="col-xs-9">
                                    <input class="form-control currentDate" name="date" type="date">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="input2" class="col-xs-3 control-label">Tempo</label>
                                <div class="col-xs-9">
                                    <input style="float: left; max-width: 60px;" required class="form-control" type="number" min="0" name="hours" value="00" placeholder="horas">
                                    <span style="float: left; margin-right: 2px; margin-left: 2px; padding-top: 2%;"> : </span>
                                    <input style="max-width: 60px;" required class="form-control" type="number" min="0" name="minutes" value="00" placeholder="min">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="input2" class="col-xs-3 control-label" style="padding-top: 2%;">%</label>
                                <div class="col-xs-3">
                                    <input class="form-control" name="conclusion" type="number" min="1" max="100" value="1">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-xs-3 pull-right"><button type="submit" class="btn btn-primary">Guardar</button></label>
                              </div>
                              <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                            </form>
                        </div>
                        <div class="col-xs-2" style="font-size: 10px;">
                            <div class="row">
                                <label class="clickableLabel"><input type="radio" name="taskType" value="0" checked>Nova</label>
                            </div>
                            <div class="row">
                                <label class="clickableLabel"><input type="radio" name="taskType" value="1">Programada</label>
                            </div>
                        </div>
                        </li>
                        
                    </ul>
                </li>
                <?php endif; ?>
                
                <li class="dropdown">
                    <a class="dropdown-toggle"  href="#">
                        <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i> <?php echo e($tasksPercentageNumber); ?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks" style="width: 800%; max-width: 450px;">

                        <?php $__currentLoopData = $tasksPercentage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <?php if($task->taskType == 'commercial'): ?>
                            <a href="/commercialProject/planningTasks/<?php echo e($task->p_id); ?>">
                            <?php else: ?>
                            <a href="/project/gantt/<?php echo e($task->p_id); ?>">
                            <?php endif; ?>
                                <div>
                                    <span style="line-height: 20px; font-size: 12px;">
                                        <strong>
                                        <?php echo e(str_pad($task->p_number, 5, '0', STR_PAD_LEFT)); ?> - <?php echo e($task->p_name); ?>

                                        <?php if($task->e_sigla != ""): ?>
                                            |<?php echo e($task->e_sigla); ?>| 
                                        <?php endif; ?>
                                        <?php if($task->ph_sigla): ?>
                                            |<?php echo e($task->ph_sigla); ?>|
                                        <?php endif; ?>
                                        </strong>
                                        <span style="font-size: 12px;" class="pull-right text-muted"><?php echo e($task->start_date); ?> - <?php echo e($task->end_date); ?></span>
                                        <br>
                                        <div class="progress progress-striped active" style="float: right; width: 25%; max-height: 15px; margin: 0;">
                                            <?php if($task->done < 25): ?>
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo e($task->done); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo e($task->done); ?>%;">
                                            </div>
                                            <?php elseif($task->done < 75): ?>
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo e($task->done); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo e($task->done); ?>%">
                                            </div>
                                            <?php else: ?>
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo e($task->done); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo e($task->done); ?>%">
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <span style="float:right; margin-right: 4px; font-size: 12px;" class="text-muted"><?php echo e($task->done); ?>%</span>
                                        <span style="font-size: 12px;"><?php echo e($task->name); ?></span>
                                    </span>
                                </div>
                            </a>
                        </li>
                        <li class="divider" style="margin: 2;"></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a class="text-center" href="/planning">
                                <strong>Ver todas as tarefas</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i><span> <?php echo e($notificationNumber); ?> </span> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="/management/hoursApproval" style="margin-top: -4px; height: 30px;">
                                <div style="font-size: 12px; margin-top: 2px;">
                                    Tarefas - <?php echo e($hoursApprovalList); ?>

                                </div>
                            </a>
                        </li>
                        <li class="divider" style="margin: 1;"></li>
                        <li>
                            <a href="/management/absence" style="height: 30px;">
                                <div style="font-size: 12px; margin-top: 2px;">
                                    Ausências - <?php echo e($absenceApprovalList); ?>

                                </div>
                            </a>
                        </li>
                        <li class="divider" style="margin: 1;"></li>
                        <li>
                            <a href="/personal/hoursApproval" style="height: 30px;">
                                <div style="font-size: 12px; margin-top: 2px;">
                                    Horas Não Aprovadas - <?php echo e($hoursNotApproved); ?>

                                </div>
                            </a>
                        </li>
                        <li class="divider" style="margin: 1;"></li>
                        <li>
                            <a class="text-center" href="/management/hoursApproval">
                                <strong>Ver Aprovações</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <?php endif; ?>
                <!-- /.dropdown -->
                <?php if(!Auth::guest()): ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" style="max-height:40px;display:inline;overflow: visible;" href="#">
                        <img src="/uploads/avatars/<?php echo e(Auth::user()->avatar); ?>" style="max-width: 30px; border-radius: 40%; margin-right: 8px;">
                        <span><?php echo e(Auth::user()->name); ?> </span><i class="fa fa-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo e(url('/profile/'. Auth::user()->id)); ?>"><i class="fa fa-btn fa-user"></i>  Perfil</a></li>
                        <li><a href="/personal/absence">Ausências</a></li>
                        <li><a href="/personal/hoursApproval">Registo de Horas</a></li>
                        <li><a href="/management/hoursApproval">Aprovações</a></li>
                        <li>
                            <a href="<?php echo e(url('/logout')); ?>"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                <i class="fa fa-btn fa-sign-out"></i>Logout
                            </a>

                            <form id="logout-form" action="<?php echo e(url('/logout')); ?>" method="POST" style="display: none;">
                                <?php echo e(csrf_field()); ?>

                            </form>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <?php endif; ?>
                <?php if(Auth::guest()): ?>
                <li>
                <a href="/login"> Login </a>
                </li>
                <?php endif; ?>
                <!-- /.dropdown -->
            </ul>

            <div class="col-sm-3 col-xs-3 pull-left">
                <form class="navbar-form" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- /.navbar-top-links -->
            <?php if(!Auth::guest()): ?>
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav ">
                    <ul class="nav" id="side-menu">
                        <li class="dashboard">
                            <a href="#">DASHBOARD</a>
                        </li>
                        <li>
                            <a href="/calendar">Calendário</a>
                        </li>
                        <li>
                            <a href="/contacts">Contactos</a>
                        </li>
                        <li>
                            <a href="/mail">E-mail</a>
                        </li>
                        <li>
                            <a href="#"></i> Área Pessoal <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/profile/<?php echo e(Auth::user()->id); ?>">Perfil</a>
                                </li>
                                <li>
                                    <a href="/personal/absence">Ausências</a>
                                </li>
                                <li>
                                    <a href="/personal/hoursApproval">Registo de Horas</a>
                                </li>
                                <li>
                                    <a href="/management/hoursApproval">Aprovações</a>
                                </li>
                                <li>
                                    <a href="/personal/report">Relatório</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"></i> Empresa <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/structure">Estrutura</a>
                                </li>
                                <li>
                                    <a href="/company/showCompanyMembers/2">Colaboradores</a>
                                </li>
                                <li>
                                    <a href="/company/absence">Mapa de Férias</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"></i> Projetos<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/projects">Operações</a>
                                </li>
                                <li>
                                    <a href="#">Estudos</a>
                                </li>
                                <li>
                                    <a href="#">Desenvolvimentos</a>
                                </li>
                                <li>
                                    <a href="/planning">Planeamento</a>
                                </li>
                                <li>
                                    <a href="#">Relatórios</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <?php if(Auth::user()->type == 2): ?>
                        <li>
                            <a href="#"></i> Definições<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/settings">Utilizadores</a>
                                </li>
                                <li>
                                    <a href="/settings/projects/expertise">Projetos</a>
                                </li>
                                <li>
                                    <a href="/settings/company/absence">Empresa</a>
                                </li>
                                <li>
                                    <a href="/settings/contacts/types">Contactos</a>
                                </li>
                                <li>
                                    <a href="/settings/commercial/iva">Comercial</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"></i> Gestão<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/management/commercial">Comercial</a>
                                </li>
                                <li>
                                    <a href="/management/operations">Operações</a>
                                </li>
                                <li>
                                    <a href="/settings/company/holidays">Empresa</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"></i> Finanças<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Faturas</a>
                                </li>
                                <li>
                                    <a href="#">Despesas</a>
                                </li>
                                <li>
                                    <a href="#">Análise</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <?php if(Request::path() != 'mail'): ?>
                        <li style="display: none;">
                            <iframe src="https://infinito.elementofinito.com/roundcube/" frameBorder="0" style="height: calc(100% - 70px); width: 100%"></iframe>   
                        </li>
                        <?php endif; ?>
                        <?php endif; ?>
                        <hr style="border-color: white;">
                        <li style="font-size: 12px; padding-left: 8px;">Projetos Recentes</li>
                        <?php if(isset($memoryProject)): ?>
                        <?php $__currentLoopData = $memoryProject; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a class="projects" href="/project/gantt/<?php echo e($project->id); ?>"><?php echo e(str_pad($project->number, 5, '0', STR_PAD_LEFT)); ?> - <?php echo e($project->name); ?></a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
            <?php endif; ?>
        </nav>
        <?php if(!Auth::guest()): ?>
            <div id="userEmail" class="hidden"><?php echo e(Auth::user()->email); ?></div>
            <?php echo $__env->make('layouts.skype_sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div id="page-wrapper" style="border-style: none;">
                <div class="row" style="width: 100%">
                    <div class="col-xs-12">
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                    <!-- /.col-xs-12 -->
                </div>
            </div>
        <?php else: ?>
        <div>
            <div class="row">
                <div class="col-xs-offset-3 col-xs-6">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
                <!-- /.col-xs-12 -->
            </div>
        </div>
        <!-- /#page-wrapper -->
        <?php endif; ?>
        

    </div>
    <!-- /#wrapper -->
</div>
</body>

<script>

    $(document).ready(function() {
        $(".select2").select2({ containerCssClass: "smallFontContainer", dropdownCssClass: "smallFont" });
    });

    // Ensure CSRF token is sent with AJAX requests
   $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });

    function refresh() {
        var dt = new Date();   
        var time = ("0" + dt.getHours()).slice(-2) + ":" + ("0" + dt.getMinutes()).slice(-2);
        $('.time').empty().append(time);
        setTimeout(refresh, 1000);
    }

    function addCurrentDate() {
        var now = new Date();

        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);

        var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

        $('.currentDate').each(function() {
            $(this).val(today);
        });
    }

    addCurrentDate();

    refresh();

    <?php if( ! empty($active)): ?>
        $(".home .title").removeClass("active");
        $(".gestao_projetos .title").removeClass("active");
        $(".empresa .title").removeClass("active");
        $(".<?php echo e($active); ?> .title").addClass("active");
    <?php endif; ?>

    <?php if( ! empty($activeL)): ?>
        $(".link-nav .colaborades").removeClass("activeL");
        $(".link-nav .contactos").removeClass("activeL");
        $(".link-nav .estrutura").removeClass("activeL");
        $(".link-nav .calendario").removeClass("activeL");
        $(".link-nav .<?php echo e($activeL); ?>").addClass("activeL");
    <?php endif; ?>

    <?php if( ! empty($activeLL)): ?>
        $(".link-nav .especialidades").removeClass("activeL");
        $(".link-nav .fases").removeClass("activeL");
        $(".link-nav .<?php echo e($activeLL); ?>").addClass("activeL");
    <?php endif; ?>


    <?php if(!Auth::guest()): ?>
        <?php if(Auth::user()->type != 0): ?>

        function appendNeeded() {
            $.ajax({
              type: "POST",
              url: '/getExpertiseFromProject',
              data: {
                'project_id' : $('.projectTime').val()
              },
              success: function(response) {
                $('.phaseTime').empty();
                $('.expertiseTime').empty();
                $('.subexpertiseTime').empty();

                /*for(var i = 0; i < response[0].length; i++) {
                    var id = response[0][i].phase_id;
                    var name = response[0][i].name;
                    $('.phaseTime').append('<option value="' + id + '">' + name + '</option>' );
                }*/
                $('.subexpertiseTime').append('<option value="0">Sem SE</option>');
                for(var i = 0; i < response[0].length; i++) {
                    var id = response[0][i].expertise_id;
                    var name = response[0][i].name;
                    if(response[0][i].parent == 0) {
                        $('.expertiseTime').append('<option value="' + id + '" content="'+ response[0][i].id + '">' + name + '</option>' );
                    }
                    if(response[0][i].parent == $('.expertiseTime').val()) {
                        $('.subexpertiseTime').append('<option value="' + id + '">' + name + '</option>' );
                    }
                }

                appendPhases();
              }
            });
        }

        appendNeeded();

        function appendPhases() {
            var content = $('.expertiseTime').find(":selected").attr('content');
            $.ajax({
              type: "POST",
              url: '/getExpertisePhasesFromProject',
              data: {
                'project_expertise_id' : content
              },
              success: function(response) {
                $('.phaseTime').empty();
                for(var i = 0; i < response.length; i++) {
                    $('.phaseTime').append('<option value="' + response[i].id + '">' + response[i].name + '</option>' );
                }
              }
            });
        }

        $('.projectTime').change(function() {
            appendNeeded();
        });

        $('.expertiseTime').change(function() {
            appendPhases();
            $.ajax({
              type: "POST",
              url: '/getExpertiseFromProject',
              data: {
                'project_id' : $('.projectTime').val()
              },
              success: function(response) {
                $('.subexpertiseTime').empty();
                for(var i = 0; i < response[0].length; i++) {
                    var id = response[0][i].id;
                    var name = response[0][i].name;
                    if(response[0][i].parent == $('.expertiseTime').val()) {
                        $('.subexpertiseTime').append('<option value="' + id + '">' + name + '</option>' );
                    }
                }
              }
            });
        });


        $('input[type=radio][name=taskType]').change(function() {
            if(this.value == 0) {
                $('.programmedTaskForm').addClass('hidden');
                $('.randomTaskForm').removeClass('hidden');
            } else {
                $('.programmedTaskForm').removeClass('hidden');
                $('.randomTaskForm').addClass('hidden');
            }
        });

        function appendProgrammedTask() {
            $.ajax({
              type: "POST",
              url: '/getProgrammedTask',
              data: {
                'assignedTo' : $('.assignedToSelect').val(),
                'project_id' : $('.programmedTaskProjectTime').val()
              },
              success: function(response) {
                $('.programmedTaskChoice').empty();
                for(var i = 0; i < response.length; i++) {
                    $('.programmedTaskChoice').append('<option value="' + response[i].id + '">' + response[i].name + '</option>');
                }
              }
            });
        }

        
        appendProgrammedTask();


        $('.programmedTaskProjectTime').change(function() {
            appendProgrammedTask();
        });
        <?php endif; ?>
    <?php endif; ?>

$('.clickableLabel').click(function(e) {
    e.stopPropagation();
});

$( function() {
    $( ".datepicker" ).datepicker();
    $( ".datepicker" ).datepicker("option", "dateFormat",'yy-mm-dd');
});



</script>

</html>
