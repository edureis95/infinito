


<?php $__env->startSection('content'); ?>

<div class="col-lg-11" style=" height:100%;">
    <?php echo $__env->make('layouts.company_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div id="userID" class="hidden"><?php echo e(Auth::user()->id); ?></div>
    <div class="panel panel-default">
        <div class="panel-body scheduler-container">
            <script src="dhtmlxScheduler/codebase/dhtmlxscheduler.js"   type="text/javascript" charset="utf-8"></script>
            <script src="dhtmlxScheduler/codebase/ext/dhtmlxscheduler_recurring.js" type="text/javascript" charset="utf-8"></script>
            <script src="dhtmlxScheduler/codebase/ext/dhtmlxscheduler_multisource.js" type="text/javascript" charset="utf-8"></script>
            <script src="dhtmlxScheduler/codebase/sources/locale/locale_pt.js" charset="utf-8"></script>
            <script src="dhtmlxScheduler/codebase/sources/locale/recurring/locale_recurring_pt.js" ></script>
            <link rel="stylesheet" href="dhtmlxScheduler/codebase/sources/skins/dhtmlxscheduler.css" type="text/css" media="screen" title="no title" charset="utf-8">

            <?php if(Auth::user()->email_password == null): ?>
            <form action="/setMailPassword" method="POST" style="margin-bottom: 5%;">
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                <div class="form-group">
                    <label>Introduz a password do webmail da elementofinito para sincronizares calendários</label>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="password" required  class="form-control" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Sincronizar</button>
                    </div>
                </div>
            </form>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-8">
                    <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%; min-width: 300px;'>
                        <div class="dhx_cal_navline">
                            <div class="dhx_cal_prev_button">&nbsp;</div>
                            <div class="dhx_cal_next_button">&nbsp;</div>
                            <div class="dhx_cal_today_button"></div>
                            <div class="dhx_cal_date"></div>
                            <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
                            <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
                            <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
                        </div>
                        <div class="dhx_cal_header">
                        </div>
                        <div class="dhx_cal_data">
                        </div>
                        <script type="text/javascript" charset="utf-8">

                            function fileExists(url)
                            {
                                var http = new XMLHttpRequest();
                                http.open('HEAD', url, false);
                                http.send();
                                return http.status!=404;
                            }

                            scheduler.config.xml_date="%Y-%m-%d %H:%i";
                            scheduler.config.prevent_cache = true;
                            scheduler.config.details_on_dblclick = true;
                            scheduler.config.details_on_create=true;
                            scheduler.config.include_end_by = true;
                            scheduler.config.first_hour = 8;
                            scheduler.config.last_hour = 20;
                            scheduler.config.time_step = 30;
                            scheduler.config.limit_time_select = true;

                            scheduler.attachEvent("onTemplatesReady", function(){
                              scheduler.templates.event_bar_date = function(start,end,ev){
                                if(ev.user_id == undefined)
                                    return "<b style='color: green;'> | </b>";
                                else
                                  return "<b style='color: red;'> | </b>";
                              };
                              scheduler.templates.event_class = function(start,end,ev){
                                if(ev.user_id == undefined) {
                                    if(start.getDay() == end.getDay() && start.getMonth() == end.getMonth() && start.getYear() == end.getYear()) {
                                        return true;
                                    }
                                    else {
                                        return ev.color = "green";
                                    }
                                }
                              };
                            });

                            scheduler.attachEvent("onEventSave",function(id,data){
                                data.user_id = $('#userID').text();
                                return true;
                            });

                            scheduler.filter_month = scheduler.filter_day = scheduler.filter_week = function(id, event) {
                              if(event.user_id == $('#userID').text() || event.user_id == undefined)
                                  return true;
                              // default, do not display event
                              return false;
                            };

                            //scheduler.setLoadMode("month");
                            scheduler.config.show_loading = true;
                            
                            scheduler.init('scheduler_here',new Date(),"month");
                            if(fileExists('/calendars/<?php echo e(Auth::user()->email); ?>.json')) {
                                scheduler.load('./scheduler_data', function() {
                                    scheduler.load('/calendars/<?php echo e(Auth::user()->email); ?>.json', 'json');
                                });
                            } else {
                                scheduler.load('./scheduler_data');
                            }

                            var dp = new dataProcessor("./scheduler_data");
                            dp.init(scheduler);

                        </script>
                    </div>
                </div>
                <div class="col-md-4 eventsSection">
                    <div class="eventsList" style="display: none;">
                        <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="event">
                            <p class="day"><?php echo e($event->day); ?> </p>
                            <p class="time"><?php echo e($event->time); ?> </p>
                            <p class="name"><?php echo e($event->event_name); ?> </p> 
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!empty($jsonEvents)): ?>
                        <?php $__currentLoopData = $jsonEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jsonEvent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="event">
                            <p class="day"><?php echo e($jsonEvent->day); ?> </p>
                            <p class="time"><?php echo e($jsonEvent->time); ?> </p>
                            <p class="name"><?php echo e($jsonEvent->text); ?> </p> 
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                    <div class="eventsDisplay">
                        <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($day); ?>

                        <ul id="<?php echo e($day); ?>"> 

                        </ul>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    
function groupEvents() {
    $('.eventsList .event').each(function() {
        var day = $(this).find('.day').text();
        var time = $(this).find('.time').text();
        var name = $(this).find('.name').text();
        var event = '<li>' +
                        '<div>' + 
                        '<p>' + time + ' - ' + name + '</p>' +
                        '</div>' +
                    '</li>';

        $('#' + day).append(event);
        
    });
}

groupEvents();


</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>