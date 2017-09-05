<?php

namespace App\Http\Controllers;
use App\SchedulerEvent;
use Dhtmlx\Connector\SchedulerConnector;
use Dhtmlx\Connector\JSONSchedulerConnector;
use Dhtmlx\Connector\JSONDataConnector;
use DB;
use DateTime;

use Illuminate\Http\Request;
use Auth;

date_default_timezone_set('Europe/London');

class SchedulerController extends Controller
{
	
	public function data() {
        $scheduler = new JSONSchedulerConnector(null, "PHPLaravel");       
        $scheduler->enable_log('log');
        $scheduler->render_table(SchedulerEvent::join('users', 'users.id', '=', 'user_id')
                                               ->select('scheduler_events.*', 'users.sigla as u_sigla')
                                               , "event_id", "start_date, end_date, event_name, rec_type,event_pid,event_length, user_id, type, absence_type, approved", "u_sigla, plannedTask_id", "");
    }

    public function showCalendar() {
    	$currentDate = date("y-m-d");
        $companyDays = \App\Company_Day::all();
    	$events = \App\SchedulerEvent::where(function ($query) use ($currentDate) {
    		$query->where('start_date', '>=', $currentDate);
    	})->where('user_id', Auth::user()->id)->orderBy('start_date', 'asc')->get();
    	foreach ($events as $event) {
    		$date = date_create($event->start_date);
    		$event->day = date_format($date, 'd-m-y');
    		$event->time = date_format($date, 'H:i');
    	}

    	$days = \App\SchedulerEvent::select('start_date')->where(function ($query) use ($currentDate) {
    		$query->where('start_date', '>=', $currentDate);
    	})->where('user_id', Auth::user()->id)->orderBy('start_date', 'asc')->get()->groupBy(function($event) {
    		$date = date_create($event->start_date);
    		return date_format($date, 'd-m-y');
    	});
    	$daysList = array();
    	foreach ($days as $key => $day) {
    		array_push($daysList, $key);
    	}

        $eventTypes = \App\Project_Event_Type::where('id', '!=', 1)->get();
        $absenceTypes = \App\Absence_Reason::all();

        if(file_exists('calendars/' . Auth::user()->email .'.json')) {
            $str = file_get_contents('calendars/' . Auth::user()->email .'.json');
            $json = json_decode($str);
            foreach($json as $event) {
                $date = date_create($event->start_date);
                $date = $date->format('d-m-y');
                $event->day = $date;
                array_push($daysList, $date);

                $time = date_create($event->start_date);
                $time = $time->format('H:i');
                $event->time = $time;
            }
            return view('scheduler', array('active' => 'empresa', 'activeL' => 'calendario', 'events' => $events, 'days' => $daysList, 'jsonEvents' => $json, 'eventTypes' => $eventTypes, 'absenceTypes' => $absenceTypes, 'companyDays' => $companyDays));
        }
    	return view('scheduler', array('active' => 'empresa', 'activeL' => 'calendario', 'events' => $events, 'days' => $daysList, 'eventTypes' => $eventTypes, 'absenceTypes' => $absenceTypes, 'companyDays' => $companyDays));
    }

    public function addPlannedTask(Request $r) {
            
            $project = \App\Project::find($r['project_id']);
            $task = new \App\GanttTask();
            $task->number = 0;
            $task->text = $r['name'];
            $task->start_date = $r['start_date'];
            $date1 = new DateTime($r['startDate']);
            $date2 = new DateTime($r['end_date']);
            $interval = $date1->diff($date2);
            $task->duration = ($interval->d + 1) * 24;
            if($r['type'] != 6)
                $task->milestone = 1;

           
            $task->parent = $project->commercial_project_Task_ID;
                

            $task->responsible = Auth::user()->sigla;
            $task->save();


            $projectTask = new \App\Task();
            $projectTask->project_id = $r['project_id'];
            $projectTask->ganttTask_id = $task->id;
            
            $projectTask->name = $r['name'];
            $projectTask->start_date = $r['start_date'];
            $projectTask->end_date = $r['end_date'];
            $projectTask->user_id = Auth::user()->id;
            $projectTask->type = $r['type'];
            $projectTask->save();

            return $projectTask->id;
    }
}
