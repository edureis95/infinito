


<?php $__env->startSection('content'); ?>

<style>
        .overlayContainer {
            position: fixed;
            top: 0%;
            left: 0%;
            z-index: 10001;
        }
        #my_form {
            position: relative;
            display: none;
            z-index: 10001;
            background-color: white;
            border: 2px outset gray;
            padding: 20px;
        }
        .weekend .dhx_month_body {
            background-color: #F6F6F6;
        }

        .weekend .dhx_month_head {
            background-color: #F6F6F6;
        }
        .companyDay .dhx_month_body {
            background-color: #CCE6CC;
        }

        .companyDay .dhx_month_head {
            background-color: #CCE6CC;
        }

        .absence {
            background-color: orange !important;
            border-color: orange !important;
            border-radius: 0 !important;
            color: white !important;
            
            font-family: Arial !important;
            line-height: 17px !important;
        }

        .dhx_cal_event_clear.absence {
            border-style: solid !important;
            font-size: 12px !important;
            padding-left: 5px !important;
        }

        .dhx_cal_date {
            font-weight: bold !important;
        }
</style>

<div class="overlayContainer">
<div id="my_form" class="">
    <table class="table borderless smallFontTable">
        <tr>
            <td><b>Descrição</b></td>
            <td><input type="text" class="form-control descriptionInput"></td>
        </tr>
        <tr>
            <td><b>Tipo</b></td>
            <td>
                <select class="form-control typeSelect" name="type">
                <?php $__currentLoopData = $eventTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <option value="7">Ausência</option>
                </select>
            </td>
        </tr>
        <tr class="projectRow">
            <td><b>Projeto</b></td>
            <td>
                <select class="form-control select2 projectSelect" style="width: 100%;">
                    <?php $__currentLoopData = $projectsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($project->id); ?>"><?php echo e(str_pad($project->number, 5, '0', STR_PAD_LEFT)); ?> - <?php echo e($project->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </td>      
        </tr>
        <tr class="absenceType hidden">
            <td><b>Tipo de ausência</b></td>
            <td>
                <select class="form-control absenceReason">
                <?php $__currentLoopData = $absenceTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>    
            </td>
        </tr>
        <tr class="attendees hidden">
            <td><b>Convidados</b></td>
            <td>
                <select multiple="true" name="attendees[]" class="form-control attendeesOptions" style="width: 100%;">
                <?php $__currentLoopData = $usersList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>    
            </td>
        </tr>
        <tr>
            <td><b>Dia Único</b></td>
            <td><input type="radio" value="0" id="onlyDayRadio" checked name="timeType"></td>
        </tr>
        <tr>
            <td><b>Período</b></td>
            <td><input type="radio" id="periodRadio" name="timeType"></td>
        </tr>
        <tr>
            <td><b>Início</b></td>
            <td><input class="form-control startDate" type="datetime-local"></td>
        </tr>
        <tr class="hidden periodOption">
            <td><b>Fim</b></td>
            <td><input class="form-control endDate" type="datetime-local"></td>
        </tr>
        <tr class="onlyDayOption">
            <td><b>Tempo(h)</b></td>
            <td><input style="width: 30%;" class="form-control timeNumber" type="number" min="1" max="8" value="1"></td>
        </tr>
    </table>
    <input type="button" name="save" value="Guardar" id="save" style='width:100px;' onclick="save_form()">
    <input type="button" name="close" value="Fechar" id="close" style='width:100px;' onclick="close_form()">
    <input type="button" name="delete" value="Eliminar" id="delete" style='width:100px;' onclick="delete_event()">
</div>
</div>
<div class="col-md-12" style=" height:100%; width: 98%;">
    <div id="userID" class="hidden"><?php echo e(Auth::user()->id); ?></div>
    <div class="panel panel-default borderless">
        <div class="panel-body scheduler-container">
            <script src="dhtmlxScheduler/codebase/dhtmlxscheduler.js"   type="text/javascript" charset="utf-8"></script>
            <script src="dhtmlxScheduler/codebase/ext/dhtmlxscheduler_recurring.js" type="text/javascript" charset="utf-8"></script>
            <script src="dhtmlxScheduler/codebase/ext/dhtmlxscheduler_multisource.js" type="text/javascript" charset="utf-8"></script>
            <script src="dhtmlxScheduler/codebase/sources/locale/locale_pt.js" charset="utf-8"></script>
            <script src="dhtmlxScheduler/codebase/sources/locale/recurring/locale_recurring_pt.js" ></script>
            <script src="../dhtmlxScheduler/codebase/ext/dhtmlxscheduler_year_view.js" ></script>
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
                <div class="col-xs-9">
                    <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:88%; min-width: 300px;'>
                        <div class="dhx_cal_navline">
                            <div class="dhx_cal_prev_button">&nbsp;</div>
                            <div class="dhx_cal_next_button">&nbsp;</div>
                            <div class="dhx_cal_today_button"></div>
                            <div class="dhx_cal_date"></div>
                            <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
                            <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
                            <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
                            <div class="dhx_cal_tab" name="year_tab" style="right:280px;"></div>
                        </div>
                        <div class="dhx_cal_header">
                        </div>
                        <div class="dhx_cal_data">
                        </div>
                        <script type="text/javascript" charset="utf-8">

                            $('input[type=radio][name=timeType]').change(function() {
                                if(this.value == 0) {
                                    $('.periodOption').addClass('hidden');
                                    $('.onlyDayOption').removeClass('hidden');
                                } else {
                                    $('.periodOption').removeClass('hidden');
                                    $('.onlyDayOption').addClass('hidden');
                                }
                            });

                            $('.typeSelect').change(function() {
                                if(this.value == 7) {
                                    $('.absenceType').removeClass('hidden');
                                    $('.projectRow').addClass('hidden');
                                    $('.attendees').addClass('hidden');
                                } else if(this.value == 3) {
                                    $('.absenceType').addClass('hidden');
                                    $('.projectRow').removeClass('hidden');
                                    $('.attendees').removeClass('hidden');
                                } else {
                                    $('.absenceType').addClass('hidden');
                                    $('.projectRow').removeClass('hidden');
                                    $('.attendees').addClass('hidden');
                                }
                            });

                            function fileExists(url)
                            {
                                var http = new XMLHttpRequest();
                                http.open('HEAD', url, false);
                                http.send();
                                return http.status!=404;
                            }

                            var html = function(id) { return document.getElementById(id); }; //just a helper

                            scheduler.showLightbox = function(id) {
                                $('.absenceType').addClass('hidden');
                                $('.typeSelect option[value="1"]').prop('selected', true);
                                $('#onlyDayRadio').prop('checked', true);
                                $('.periodOption').addClass('hidden');
                                $('.onlyDayOption').removeClass('hidden');
                                var ev = scheduler.getEvent(id);
                                scheduler.startLightbox(id, html("my_form"));
                                $('.descriptionInput').val(ev.text);
                                var month = ('0' + (ev.start_date.getMonth()+1)).slice(-2)
                                var day = ('0' + (ev.start_date.getDate())).slice(-2)
                                var hours = ('0' + (ev.start_date.getHours())).slice(-2)
                                var minutes = ('0' + (ev.start_date.getMinutes())).slice(-2)
                                $('.startDate').val(ev.start_date.getFullYear() + "-" + month + "-" + day + 'T' + hours + ':' + minutes);
                                $('.typeSelect option[value="'+ ev.type + '"]').prop('selected', true);
                                if(ev.type == 3)
                                    $('.attendees').removeClass('hidden');
                            };

                            function save_form() {
                                var ev = scheduler.getEvent(scheduler.getState().lightbox_id);
                                //console.log($('.attendeesOptions').val());
                                ev.approved = 0;
                                ev.text = $('.descriptionInput').val();
                                ev.user_id = <?php echo e(Auth::user()->id); ?>;
                                ev.type = $('.typeSelect').val();
                                if(ev.type == 7)
                                    ev.absence_type = $('.absenceReason').val();
                                else
                                    ev.absence_type = 3;
                                
                                ev.start_date = new Date($('.startDate').val());
                                var project_id = $('.projectSelect').val();
                                if($("#periodRadio").is(':checked')) {
                                    ev.end_date = new Date($('.endDate').val());
                                } else {
                                    ev.end_date = new Date($('.startDate').val());
                                    ev.end_date.setTime(ev.end_date.getTime() + ($('.timeNumber').val()*60*60*1000));
                                }
                                /*ev.custom1 = html("custom1").value;
                                ev.custom2 = html("custom2").value;*/

                                scheduler.endLightbox(true, html("my_form"));
                                setTimeout(function() {
                                    $.ajax({
                                      type: "POST",
                                      url: '/scheduler/addEventToCalDav',
                                      data: {
                                        'id' : ev.id,
                                        'text' : ev.text,
                                        'start_date' : ev.start_date.toLocaleString(),
                                        'end_date' : ev.end_date.toLocaleString()
                                      },
                                      success: function(response) {
                                        console.log(response);
                                      }
                                    });
                                }, 2000);
                            }
                            function close_form() {
                                scheduler.endLightbox(false, html("my_form"));
                            }

                            function delete_event() {
                                var event_id = scheduler.getState().lightbox_id;
                                scheduler.endLightbox(false, html("my_form"));
                                scheduler.deleteEvent(event_id);
                            }

                            function getWeekNumber(d) {
                                // Copy date so don't modify original
                                d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
                                // Set to nearest Thursday: current date + 4 - current day number
                                // Make Sunday's day number 7
                                d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay()||7));
                                // Get first day of year
                                var yearStart = new Date(Date.UTC(d.getUTCFullYear(),0,1));
                                // Calculate full weeks to nearest Thursday
                                var weekNo = Math.ceil(( ( (d - yearStart) / 86400000) + 1)/7);
                                // Return array of year and week number
                                return [d.getUTCFullYear(), weekNo];
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
                                scheduler.templates.month_date_class=function(date,today){
                                    var currentDate = new Date();
                                    var month = date.getMonth() + 1;
                                    <?php $__currentLoopData = $companyDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        if('<?php echo e($day->start_date); ?>' == (date.getFullYear() + '-' + ("0" + month).slice(-2) + '-' + ("0" + date.getDate()).slice(-2))) {
                                            return 'companyDay';
                                        }
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    if(date.getDay() == 0 || date.getDay() == 6) {
                                        return 'weekend';
                                    }
                                };

                                scheduler.templates.week_date = function(start, end){
                                    return 'Semana ' + getWeekNumber(start)[1];
                                };

                              scheduler.templates.event_class = function(start,end,ev){
                                if(ev.type == 7) {
                                    return 'absence';
                                }
                              };

                              scheduler.templates.year_tooltip = function(start,end,ev){
                                    if(ev.type == 7)
                                        return '<span style="background-color: orange; color: white;">' + ev.text + '</span>';
                                    return ev.text;
                                };

                              scheduler.templates.event_bar_text = function(start,end,ev){
                                 if(ev.user_id != undefined) {
                                    if(ev.u_sigla !=  undefined)
                                        return ev.u_sigla + ' - ' + ev.text;
                                    else
                                        return '<?php echo e(Auth::user()->sigla); ?>' + ' - ' + ev.text;
                                 } else
                                    return ev.text; 
                              };

                              scheduler.templates.event_bar_date = function(start,end,ev){
                                return "";
                              };
                            });

                            scheduler.attachEvent("onEventSave",function(id,data){
                               console.log(id);
                            });

                            scheduler.filter_month = scheduler.filter_day = scheduler.filter_week = function(id, event) {
                              if(event.type == 7 && $('.absenceFilter').is(':checked') != true) {
                                return false;
                              }
                              return true;
                            };

                            //scheduler.setLoadMode("month");
                            scheduler.config.show_loading = true;
                            
                            scheduler.init('scheduler_here',new Date(),"month");
                            if(fileExists('/calendars/<?php echo e(Auth::user()->email); ?>.json')) {
                                scheduler.load('./scheduler_data', 'json', function() {
                                    scheduler.load('/calendars/<?php echo e(Auth::user()->email); ?>.json', 'json');
                                });
                            } else {
                                scheduler.load('./scheduler_data', 'json');
                            }

                            var dp = new dataProcessor("./scheduler_data", 'json');
                            dp.init(scheduler);

                        </script>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="row">
                        <input checked type="checkbox" class="absenceFilter">
                        <span>Ausências</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>

$('.absenceFilter').change(function() {
    scheduler.setCurrentView();
});

    
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