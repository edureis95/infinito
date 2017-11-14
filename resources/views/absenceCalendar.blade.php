@extends('layouts.app')


@section('content')

<div class="col-xs-12 insideContainer">
    @include('layouts.company_nav')
    <div class="row">
        <hr style="margin-top: 0; margin-left: 0; width: 100%; border-color: #DCDCDC;">
    </div>
    <div id="userID" class="hidden">{{Auth::user()->id}}</div>
    <div class="panel panel-default">
        <div class="panel-body scheduler-container">
            <script src="../dhtmlxScheduler/codebase/dhtmlxscheduler.js"   type="text/javascript" charset="utf-8"></script>
            <script src="../dhtmlxScheduler/codebase/ext/dhtmlxscheduler_multisource.js" type="text/javascript" charset="utf-8"></script>
            <script src="../dhtmlxScheduler/codebase/sources/locale/locale_pt.js" charset="utf-8"></script>
            <script src="../dhtmlxScheduler/codebase/ext/dhtmlxscheduler_year_view.js" ></script>
            <script src="../dhtmlxScheduler/codebase/sources/locale/recurring/locale_recurring_pt.js" ></script>
            <link rel="stylesheet" href="../dhtmlxScheduler/codebase/sources/skins/dhtmlxscheduler.css" type="text/css" media="screen" title="no title" charset="utf-8">

            
            <div class="row">
                <div class="col-md-9">
                    <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%; min-width: 300px;'>
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

                            scheduler.config.xml_date="%Y-%m-%d %H:%i";
                            scheduler.config.prevent_cache = true;
                            scheduler.config.details_on_dblclick = true;
                            scheduler.config.details_on_create=true;
                            scheduler.config.include_end_by = true;
                            scheduler.config.time_step = 30;



                            $.ajax({
                              async: false,
                              type: 'GET',
                              url: '/company/absence/getUserNamesList',
                              success: function(response) {
                                    scheduler.attachEvent("onTemplatesReady", function(){
                                      scheduler.templates.event_bar_date = function(start,end,ev){
                                          return "<b style='color: red;'> | </b>";
                                      };
                                      scheduler.templates.event_bar_text = function(start,end,ev){
                                          for(var i = 0; i < response.length; i++) {
                                            if(response[i].id == ev.user_id) {
                                                return ev.text + ' - ' + response[i].name;
                                            }
                                          }
                                      };
                                    });
                              }
                          });


                            scheduler.attachEvent("onEventSave",function(id,data){
                                data.user_id = $('#userID').text();
                                return true;
                            });


                            //scheduler.setLoadMode("month");
                            scheduler.config.show_loading = true;

                            scheduler.attachEvent("onBeforeLightbox", function (id){
                                var event = scheduler.getEvent(id);
                                if(event.text == "Novo evento")
                                    event.text = "Nova ausência";
                                else
                                    return true;
                                return true;
                            });

                            var reasons = [];
                            $.get('/company/absence/getReasons', function(response) {
                                for(var i = 0; i < response.length; i++) {
                                    reasons.push({ key: response[i].id, label: response[i].name});
                                }
                                scheduler.config.lightbox.sections=[
                                    {name:"description", height:70  , map_to:"text", type:"textarea" , focus:true},
                                    {name:"Motivo da ausência", height:40, type:"select", options: reasons, map_to:'absence_type'},
                                    {name:"time", height:72, type:"time", map_to:"auto"}
                                ];
                            })

                            
                            scheduler.init('scheduler_here',new Date(),"month");
                            scheduler.load('../../absence_data');

                            var dp = new dataProcessor("../../absence_data");
                            dp.init(scheduler);

                        </script>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>


</script>

@endsection
