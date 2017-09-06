<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use stdClass;
use SplQueue;
use Auth;
use DB;

class ManagementController extends Controller
{
    public function getNextUserFromWorkflow($user_id) {
        $user = \App\User::find($user_id);
        $department = \App\Department::find($user->function);

        while($user_id == $department->supervisor) {
            if($department->parent == 0)
                return null;
            else {
                $department = \App\Department::find($department->parent);
            }
        }
        return $department->supervisor;
    }

    public function showManagement() {
    	return view('management', array('activeL' => 'comercial'));
    }

    public function showOperations() {
        $memory = \App\User_Memory::where('user_id', Auth::user()->id)->first();

        if($memory != null) {
            if($memory->management_operations_filter != null) {
                $projects = $this->filterProjectsWithArgs(unserialize($memory->management_operations_filter));
            }
        } 

        if(!isset($projects)) {
            $projects = \App\Project::orderBy('number', 'desc')->get();
            foreach($projects as $project) {
                $event = \App\Executed_Task::where('project_id', $project->id)
                                           ->join('state_types', 'state_types.id', '=', 'executed_tasks.subType')
                                           ->orderBy('start_date', 'desc')
                                           ->first();

                if($event != null) {
                    $project->state_id = $event->id;
                    $project->state = $event->name;
                }
                else {
                   $project->state_id = 0;
                   $project->state = "Sem Estado";
               }
            }  
        }

        $phases = \App\Phase::all();
        $expertise = \App\Expertise::all();
        $states = \App\State_Type::all();
        if($memory != null) {
            if($memory->management_operations_filter != null) {
                return view('operations', array('projects' => $projects, 'active' => 'gestao_projetos', 'activeL' => 'projetos', 'expertise' => $expertise, 'states' => $states, 'phases' => $phases, 'filter' => unserialize($memory->management_operations_filter)));
            } else {
                return view('operations', array('activeL' => 'operações', 'phases' => $phases, 'expertise' => $expertise, 'states' => $states, 'projects' => $projects));
            }
        } else {
            return view('operations', array('activeL' => 'operações', 'phases' => $phases, 'expertise' => $expertise, 'states' => $states, 'projects' => $projects));
        }
    }

    public function showHoursApproval() {
    	$users = \App\User::all();
    	$tasks = \App\TaskTimer::where('approved', 0)
                                ->where('userToApprove', Auth::user()->id)
    							->join('project', 'task_timer.project_id', '=', 'project.id')
    							->leftJoin('phases', 'task_timer.phase_id', '=', 'phases.id')
    							->leftjoin('expertise', 'task_timer.expertise_id', '=', 'expertise.id')
    							->join('users', 'task_timer.user_id', '=', 'users.id')
    							->select('task_timer.task_name as t_name', 'task_timer.hours as t_hours', 'task_timer.minutes as t_min', 'task_timer.created_at as t_created_at', 'project.number as p_number', 'project.name as p_name', 'phases.sigla as ph_sigla', 'expertise.sigla as e_sigla', 'users.name as u_name', 'users.sigla as u_sigla', 'task_timer.id as t_id', 'task_timer.done as done', 'task_timer.date as t_date')
                                ->orderBy('task_timer.date', 'desc')
    							->get();

    	foreach($tasks as $task) {
    		$date = new DateTime($task->t_date);
    		$date = date_format($date, 'd-m-y');
    		$task->date = $date;
    	}
    	$expertise = \App\Expertise::where('parent', 0)->get();
    	$phases = \App\Phase::all();

    	return view('hoursApproval', array('tasks' => $tasks, 'users' => $users, 'phases' => $phases, 'expertise' => $expertise, 'activeL' => 'aprovações', 'activeLL' => 'registoHoras2'));
    }

    public function saveApproval(Request $r) {
    	$tasks = \App\TaskTimer::whereIn('id', $r['obj']['ids'])->get();
    	foreach($tasks as $task) {
            if($r['obj'][$task->id] == "true") {
                $userToApprove = $this->getNextUserFromWorkflow(Auth::user()->id);
                if($userToApprove == null)
                    $task->approved = 1;
                else
                    $task->userToApprove = $userToApprove;
                $task->save();
            } else {
                /*$task->approved = 0;
                $task->save();*/
            }
    	}
    }

    public function saveReject(Request $r) {
        $tasks = \App\TaskTimer::whereIn('id', $r['obj']['ids'])->get();
        foreach($tasks as $task) {
            if($r['obj'][$task->id] == "true") {
                $task->approved = -1;
                $task->save();
            } else {
                /*$task->approved = 0;
                $task->save();*/
            }
        }
    }

    public function filterApproval(Request $r) {
    	if($r['user'] != 0)
    		$userComparison = "=";
    	else
    		$userComparison = ">";
    	if($r['project'] != 0)
    		$projectComparison = "=";
    	else
    		$projectComparison = ">";
    	if($r['phase'] != 0)
    		$phaseComparison = "=";
    	else
    		$phaseComparison = ">";
    	if($r['expertise'] != 0)
    		$expertiseComparison = "=";
    	else
    		$expertiseComparison = ">";
    	if($r['approvedFilter'] == 'true') {
    		$approvedComparison = "=";
            $approvedComparison2 = "=";
    	}
    	else {
    		$approvedComparison = ">=";
            $approvedComparison2 = "<";
    	}

    	if($r['startDateFilter'] != "" && $r['endDateFilter'] != "") {

            if($r['phase'] == 0 && $r['expertise'] == 0) {
                $tasks = \App\TaskTimer::where('user_id', $userComparison, $r['user'])
                                ->where('project_id', $projectComparison, $r['project'])
                                ->where('userToApprove', Auth::user()->id)
                                ->where(function($query) use ($approvedComparison, $approvedComparison2) {
                                    $query->where('approved', $approvedComparison, 0);
                                })
                                ->whereBetween('task_timer.created_at', array($r['startDateFilter'], $r['endDateFilter']))
                                ->join('project', 'task_timer.project_id', '=', 'project.id')
                                ->leftoin('phases', 'task_timer.phase_id', '=', 'phases.id')
                                ->leftJoin('expertise', 'task_timer.expertise_id', '=', 'expertise.id')
                                ->join('users', 'task_timer.user_id', '=', 'users.id')
                                ->select('task_timer.task_name as t_name', 'task_timer.hours as t_hours', 'task_timer.minutes as t_min', 'task_timer.created_at as t_created_at', 'project.number as p_number', 'project.name as p_name', 'phases.sigla as ph_sigla', 'expertise.sigla as e_sigla', 'users.name as u_name', 'task_timer.id as t_id', 'task_timer.approved as t_ap', 'users.sigla as u_sigla', 'task_timer.date as t_date', 'task_timer.done as done')
                                ->orderBy('task_timer.date', 'desc')
                                ->get();
            } else {
                $tasks = \App\TaskTimer::where('user_id', $userComparison, $r['user'])
                                ->where('project_id', $projectComparison, $r['project'])
                                ->where('userToApprove', Auth::user()->id)
                                ->where('expertise_id', $expertiseComparison, $r['expertise'])
                                ->where('phase_id', $phaseComparison, $r['phase'])
                                ->where(function($query) use ($approvedComparison, $approvedComparison2) {
                                    $query->where('approved', $approvedComparison, 0);
                                })
                                ->whereBetween('task_timer.created_at', array($r['startDateFilter'], $r['endDateFilter']))
                                ->join('project', 'task_timer.project_id', '=', 'project.id')
                                ->leftoin('phases', 'task_timer.phase_id', '=', 'phases.id')
                                ->leftJoin('expertise', 'task_timer.expertise_id', '=', 'expertise.id')
                                ->join('users', 'task_timer.user_id', '=', 'users.id')
                                ->select('task_timer.task_name as t_name', 'task_timer.hours as t_hours', 'task_timer.minutes as t_min', 'task_timer.created_at as t_created_at', 'project.number as p_number', 'project.name as p_name', 'phases.sigla as ph_sigla', 'expertise.sigla as e_sigla', 'users.name as u_name', 'task_timer.id as t_id', 'task_timer.approved as t_ap', 'users.sigla as u_sigla', 'task_timer.date as t_date', 'task_timer.done as done')
                                ->orderBy('task_timer.date', 'desc')
                                ->get();
            }
    		
    	} else if($r['startDateFilter'] != "") {

            if($r['phase'] == 0 && $r['expertise'] == 0) {
                $tasks = \App\TaskTimer::where('user_id', $userComparison, $r['user'])
                                ->where('project_id', $projectComparison, $r['project'])
                                ->where('userToApprove', Auth::user()->id)
                                ->where(function($query) use ($approvedComparison, $approvedComparison2) {
                                    $query->where('approved', $approvedComparison, 0);
                                })
                                ->where('task_timer.created_at', '>=', $r['startDateFilter'])
                                ->join('project', 'task_timer.project_id', '=', 'project.id')
                                ->leftJoin('phases', 'task_timer.phase_id', '=', 'phases.id')
                                ->leftJoin('expertise', 'task_timer.expertise_id', '=', 'expertise.id')
                                ->join('users', 'task_timer.user_id', '=', 'users.id')
                                ->select('task_timer.task_name as t_name', 'task_timer.hours as t_hours', 'task_timer.minutes as t_min', 'task_timer.created_at as t_created_at', 'project.number as p_number', 'project.name as p_name', 'phases.sigla as ph_sigla', 'expertise.sigla as e_sigla', 'users.name as u_name', 'task_timer.id as t_id', 'task_timer.approved as t_ap', 'users.sigla as u_sigla', 'task_timer.date as t_date', 'task_timer.done as done')
                                ->orderBy('task_timer.date', 'desc')
                                ->get();
            }else {
                $tasks = \App\TaskTimer::where('user_id', $userComparison, $r['user'])
                                ->where('project_id', $projectComparison, $r['project'])
                                ->where('userToApprove', Auth::user()->id)
                                ->where('expertise_id', $expertiseComparison, $r['expertise'])
                                ->where('phase_id', $phaseComparison, $r['phase'])
                                ->where(function($query) use ($approvedComparison, $approvedComparison2) {
                                    $query->where('approved', $approvedComparison, 0);
                                })
                                ->where('task_timer.created_at', '>=', $r['startDateFilter'])
                                ->join('project', 'task_timer.project_id', '=', 'project.id')
                                ->leftJoin('phases', 'task_timer.phase_id', '=', 'phases.id')
                                ->leftJoin('expertise', 'task_timer.expertise_id', '=', 'expertise.id')
                                ->join('users', 'task_timer.user_id', '=', 'users.id')
                                ->select('task_timer.task_name as t_name', 'task_timer.hours as t_hours', 'task_timer.minutes as t_min', 'task_timer.created_at as t_created_at', 'project.number as p_number', 'project.name as p_name', 'phases.sigla as ph_sigla', 'expertise.sigla as e_sigla', 'users.name as u_name', 'task_timer.id as t_id', 'task_timer.approved as t_ap', 'users.sigla as u_sigla', 'task_timer.date as t_date', 'task_timer.done as done')
                                ->orderBy('task_timer.date', 'desc')
                                ->get();
            }
        } else if($r['endDateFilter'] != "") {
            $tasks = \App\TaskTimer::where('user_id', $userComparison, $r['user'])
                                ->where('project_id', $projectComparison, $r['project'])
                                ->where('userToApprove', Auth::user()->id)
                                ->where('expertise_id', $expertiseComparison, $r['expertise'])
                                ->where('phase_id', $phaseComparison, $r['phase'])
                                ->where(function($query) use ($approvedComparison, $approvedComparison2) {
                                    $query->where('approved', $approvedComparison, 0);
                                })
                                ->where('task_timer.created_at', '<=', $r['endDateFilter'])
                                ->join('project', 'task_timer.project_id', '=', 'project.id')
                                ->leftJoin('phases', 'task_timer.phase_id', '=', 'phases.id')
                                ->leftJoin('expertise', 'task_timer.expertise_id', '=', 'expertise.id')
                                ->join('users', 'task_timer.user_id', '=', 'users.id')
                                ->select('task_timer.task_name as t_name', 'task_timer.hours as t_hours', 'task_timer.minutes as t_min', 'task_timer.created_at as t_created_at', 'project.number as p_number', 'project.name as p_name', 'phases.sigla as ph_sigla', 'expertise.sigla as e_sigla', 'users.name as u_name', 'task_timer.id as t_id', 'task_timer.approved as t_ap', 'users.sigla as u_sigla', 'task_timer.date as t_date', 'task_timer.done as done')
                                ->orderBy('task_timer.date', 'desc')
                                ->get();
        } else {

            if($r['phase'] == 0 && $r['expertise'] == 0) {
                $tasks = \App\TaskTimer::where('user_id', $userComparison, $r['user'])
                                ->where('project_id', $projectComparison, $r['project'])
                                ->where('userToApprove', Auth::user()->id)
                                ->where(function($query) use ($approvedComparison, $approvedComparison2) {
                                    $query->where('approved', $approvedComparison, 0);
                                })
                                ->join('project', 'task_timer.project_id', '=', 'project.id')
                                ->leftJoin('phases', 'task_timer.phase_id', '=', 'phases.id')
                                ->leftJoin('expertise', 'task_timer.expertise_id', '=', 'expertise.id')
                                ->join('users', 'task_timer.user_id', '=', 'users.id')
                                ->select('task_timer.task_name as t_name', 'task_timer.hours as t_hours', 'task_timer.minutes as t_min', 'task_timer.created_at as t_created_at', 'project.number as p_number', 'project.name as p_name', 'phases.sigla as ph_sigla', 'expertise.sigla as e_sigla', 'users.name as u_name', 'task_timer.id as t_id', 'task_timer.approved as t_ap', 'users.sigla as u_sigla', 'task_timer.date as t_date', 'task_timer.done as done')
                                ->orderBy('task_timer.date', 'desc')
                                ->get();

            } else {
                $tasks = \App\TaskTimer::where('user_id', $userComparison, $r['user'])
                                ->where('project_id', $projectComparison, $r['project'])
                                ->where('userToApprove', Auth::user()->id)
                                ->where('expertise_id', $expertiseComparison, $r['expertise'])
                                ->where('phase_id', $phaseComparison, $r['phase'])
                                ->where(function($query) use ($approvedComparison, $approvedComparison2) {
                                    $query->where('approved', $approvedComparison, 0);
                                })
                                ->join('project', 'task_timer.project_id', '=', 'project.id')
                                ->leftJoin('phases', 'task_timer.phase_id', '=', 'phases.id')
                                ->leftJoin('expertise', 'task_timer.expertise_id', '=', 'expertise.id')
                                ->join('users', 'task_timer.user_id', '=', 'users.id')
                                ->select('task_timer.task_name as t_name', 'task_timer.hours as t_hours', 'task_timer.minutes as t_min', 'task_timer.created_at as t_created_at', 'project.number as p_number', 'project.name as p_name', 'phases.sigla as ph_sigla', 'expertise.sigla as e_sigla', 'users.name as u_name', 'task_timer.id as t_id', 'task_timer.approved as t_ap', 'users.sigla as u_sigla', 'task_timer.date as t_date', 'task_timer.done as done')
                                ->orderBy('task_timer.date', 'desc')
                                ->get();
            }
    	}

    	foreach($tasks as $task) {
    		$date = new DateTime($task->t_date);
    		$date = date_format($date, 'd-m-y');
    		$task->date = $date;

            if($task->e_sigla == null)
                $task->e_sigla = '-';
            if($task->ph_sigla == null)
                $task->ph_sigla = '-';
    	}

    	return $tasks;
    }

    public function getAbsenceApproval() {
        $users = \App\User::all();

        $absences = \App\SchedulerEvent::join('users', 'users.id', '=', 'scheduler_events.user_id')
                                       ->where('approved', 0)
                                       ->where('scheduler_events.type', 7)
                                       ->join('absence_reasons', 'absence_reasons.id', '=', 'scheduler_events.absence_type')
                                       ->select('users.name as u_name', 'users.sigla as u_sigla', 'absence_reasons.name as a_name', 'start_date', 'end_date', 'event_name as text', 'scheduler_events.event_id as a_id', 'approved as a_ap')
                                       ->orderBy('start_date', 'desc')
                                       ->get();

        foreach($absences as $absence) {
            $date1 = new DateTime($absence->start_date);
            $date1String = $date1->format('d-m-y');
            //$absence->start_date = $date1->format('d-m-y H:i');
            $date2 = new DateTime($absence->end_date);
            $date2String = $date2->format('d-m-y');
            //$absence->end_date = $date1->format('d-m-y H:i');
            if($date1String == $date2String) {
                $absence->start_date = $date1->format('d-m-y');
                $absence->end_date = $date2->format('H') - 0;
            } else {
                $absence->start_date = $date1->format('d-m-y');
                $absence->end_date = $date2->format('d-m-y');
            }
        }

        return view('absenceApproval', array('activeL' => 'empresa', 'activeLL' => 'ausências2', 'users' => $users, 'absences' => $absences));
    }

    public function filterAbsenceApproval(Request $r) {
        if($r['user'] != 0)
            $userComparison = "=";
        else
            $userComparison = ">";
        if($r['approvedFilter'] == 'true') {
            $approvedComparison = "=";
            $approvedComparison2 = "=";
        }
        else {
            $approvedComparison = ">=";
            $approvedComparison2 = "<=";
        }

        if($r['startDateFilter'] != "" && $r['endDateFilter'] != "") {
            $absences = \App\SchedulerEvent::where('user_id', $userComparison, $r['user'])
                                ->where(function($query) use ($approvedComparison, $approvedComparison2) {
                                    $query->where('approved', $approvedComparison, 0);
                                    $query->orWhere('approved', $approvedComparison2, 0);
                                })
                                ->where('scheduler_events.type', 7)
                                ->whereBetween('scheduler_events.start_date', array($r['startDateFilter'], $r['endDateFilter']))
                                ->join('users', 'users.id', '=', 'scheduler_events.user_id')
                                ->join('absence_reasons', 'absence_reasons.id', '=', 'scheduler_events.absence_type')
                                ->select('users.sigla as u_sigla', 'absence_reasons.name as a_name', 'scheduler_events.start_date as start_date', 'scheduler_events.end_date as end_date', 'scheduler_events.event_name as text', 'scheduler_events.event_id as a_id', 'scheduler_events.approved as a_ap')
                                ->orderBy('start_date', 'desc')
                                ->get();
        } else if($r['startDateFilter'] != "") {
            $absences = \App\SchedulerEvent::where('user_id', $userComparison, $r['user'])
                                ->where(function($query) use ($approvedComparison, $approvedComparison2) {
                                    $query->where('approved', $approvedComparison, 0);
                                    $query->orWhere('approved', $approvedComparison2, 0);
                                })
                                ->where('scheduler_events.type', 7)
                                ->where('scheduler_events.start_date', '>=', $r['startDateFilter'])
                                ->join('users', 'users.id', '=', 'scheduler_events.user_id')
                                ->join('absence_reasons', 'absence_reasons.id', '=', 'scheduler_events.absence_type')
                                ->select('users.sigla as u_sigla', 'absence_reasons.name as a_name', 'scheduler_events.start_date as start_date', 'scheduler_events.end_date as end_date', 'scheduler_events.event_name as text', 'scheduler_events.event_id as a_id', 'scheduler_events.approved as a_ap')
                                ->orderBy('start_date', 'desc')
                                ->get();
        } else if($r['endDateFilter'] != "") {
            $absences = \App\SchedulerEvent::where('user_id', $userComparison, $r['user'])
                                ->where(function($query) use ($approvedComparison, $approvedComparison2) {
                                    $query->where('approved', $approvedComparison, 0);
                                    $query->orWhere('approved', $approvedComparison2, 0);
                                })
                                ->where('scheduler_events.type', 7)
                                ->where('scheduler_events.end_date', '<=', $r['endDateFilter'])
                                ->join('users', 'users.id', '=', 'scheduler_events.user_id')
                                ->join('absence_reasons', 'absence_reasons.id', '=', 'scheduler_events.absence_type')
                                ->select('users.sigla as u_sigla', 'absence_reasons.name as a_name', 'scheduler_events.start_date as start_date', 'scheduler_events.end_date as end_date', 'scheduler_events.event_name as text', 'scheduler_events.event_id as a_id', 'scheduler_events.approved as a_ap')
                                ->orderBy('start_date', 'desc')
                                ->get();
        } else {

            $absences = \App\SchedulerEvent::where('users.id', $userComparison, $r['user'])
                                ->where(function($query) use ($approvedComparison, $approvedComparison2) {
                                    $query->where('approved', $approvedComparison, 0);
                                    $query->orWhere('approved', $approvedComparison2, 0);
                                })
                                ->where('scheduler_events.type', 7)
                                ->join('users', 'users.id', '=', 'scheduler_events.user_id')
                                ->join('absence_reasons', 'absence_reasons.id', '=', 'scheduler_events.absence_type')
                                ->select('users.sigla as u_sigla', 'absence_reasons.name as a_name', 'scheduler_events.start_date as start_date', 'scheduler_events.end_date as end_date', 'scheduler_events.event_name as text', 'scheduler_events.event_id as a_id', 'scheduler_events.approved as a_ap')
                                ->orderBy('start_date', 'desc')
                                ->get();

         
        }

        foreach($absences as $absence) {
            $date1 = new DateTime($absence->start_date);
            $date1String = $date1->format('d-m-y');
            //$absence->start_date = $date1->format('d-m-y H:i');
            $date2 = new DateTime($absence->end_date);
            $date2String = $date2->format('d-m-y');
            //$absence->end_date = $date1->format('d-m-y H:i');
            if($date1String == $date2String) {
                $absence->start_date = $date1->format('d-m-y');
                $absence->end_date = $date2->format('H') - 1;
            } else {
                $absence->start_date = $date1->format('d-m-y');
                $absence->end_date = $date2->format('d-m-y');
            }
        }

        return $absences;
    }

    public function saveAbsenceApproval(Request $r) {

        $absences = \App\SchedulerEvent::whereIn('event_id', $r['obj']['ids'])->get();

        foreach($absences as $absence) {
            if($r['obj'][$absence->event_id] == "true")
                $absence->approved = 1;
           
            $absence->save();
        }

        /*$absences = \App\SchedulerEvent::whereIn('event_id', $r['rejected']['ids'])->get();

        foreach($absences as $absence) {
            if($r['rejected'][$absence->event_id] == "true")
                $absence->approved = -1;
            else
                $absence->approved = 0;
            $absence->save();
        }*/
    }

    public function saveAbsenceReject(Request $r) {

        $absences = \App\SchedulerEvent::whereIn('event_id', $r['obj']['ids'])->get();

        foreach($absences as $absence) {
            if($r['obj'][$absence->event_id] == "true")
                $absence->approved = -1;
           
            $absence->save();
        }
    }

    public function getProject($id) {
        $project = \App\Project::find($id);
        $project->typeName = \App\Project_Type::find($project->type);
        if($project->typeName != null)
            $project->typeName = $project->typeName->name;

        $projectDetails = \App\Project_Details::where('project_id', $id)->first();
        if($projectDetails != null) {
            $project->projectDetails = $projectDetails;

            $utilizationTypeName = \App\Utilization_Type::find($project->projectDetails->utilizationType);
            if($utilizationTypeName != null)
                $project->projectDetails->utilizationTypeName = $utilizationTypeName->name;

            $constructionTypeName = \App\Construction_Type::find($project->projectDetails->constructionType);
            if($constructionTypeName != null)
                $project->projectDetails->constructionTypeName = $constructionTypeName->name;

            
        }

        $projectTypes = \App\Project_Type::all();
        $constructionTypes = \App\Construction_Type::all();
        $utilizationTypes = \App\Utilization_Type::all();

        return view('managementProject.project', array('project' => $project, 'active' => 'gestao_projetos', 'activeL' => 'informação', 'activeLL' => 'informações', 'projectTypes' => $projectTypes, 'constructionTypes' => $constructionTypes, 'utilizationTypes' => $utilizationTypes));
    }

    public function getProjectTeam($id) {
        $project = \App\Project::find($id);
        $expertise = \App\Project_Expertise::where('project_id', $id)
                                            ->join('expertise', 'expertise_id', '=', 'expertise.id')
                                            ->get();
        $team = \App\Project_Team::where('project_id', $id)
                                 ->join('expertise', 'expertise_id', '=', 'expertise.id')
                                 ->join('users', 'user_id', '=', 'users.id')
                                 ->select('users.name as u_name', 'users.sigla as u_sigla', 'expertise.name as e_name', 'users.email as u_email', 'project_team.id as id')
                                 ->get();

        return view('managementProject.projectTeam', array('team' => $team, 'expertise' => $expertise, 'project' => $project, 'activeLL' => 'equipa', 'activeL' => 'informação'));
    }

    public function getProjectExpertise($id) {
        $projectExpertise = \App\Project_Expertise::where('project_id', $id)
                                           ->where('parent', '=', 0)
                                           ->join('expertise', 'project_expertise.expertise_id', '=', 'expertise.id')
                                           ->select('expertise.id as e_id', 'expertise.name as e_name', 'expertise.parent as e_parent', 'expertise.sigla as e_sigla', 'project_expertise.id as p_e_id')
                                           ->get();
        
        foreach($projectExpertise as $expert) {
            $expert->subExpertise = \App\Project_Expertise::join('expertise', 'project_expertise.expertise_id', '=', 'expertise.id')
                                                          ->where('expertise.parent', $expert->e_id)
                                                          ->where('project_id', $id)
                                                          ->select('expertise.id as e_id', 'expertise.name as e_name', 'expertise.parent as e_parent', 'expertise.sigla as e_sigla', 'project_expertise.id as p_e_id')
                                                          ->get();

            foreach($expert->subExpertise as $subExpert) {
                $subExpert->phases = \App\Project_Expertise_Phase::where('project_expertise_id', $subExpert->p_e_id)->get();
            }

            $expert->phases = \App\Project_Expertise_Phase::where('project_expertise_id', $expert->p_e_id)->get();
        }


        $projectPhases = \App\Project_Phase::where('project_id', $id)
                                           ->join('phases', 'project_phase.phase_id', '=', 'phases.id')
                                           ->select('phases.id as p_id', 'phases.name as p_name', 'phases.sigla as p_sigla', 'project_phase.id as proj_p_id')
                                           ->get();
        $phases = \App\Phase::all();

        $project = \App\Project::find($id);
        $expertise = \App\Expertise::where('parent', '=', 0)->get();
        $subExpertise = \App\Expertise::where('parent', '!=', 0)->get();

        return view('managementProject.projectExpertise', array('project' => $project, 'projectExpertise' => $projectExpertise, 'expertise' => $expertise, 'subExpertise' => $subExpertise, 'activeL' => 'informação', 'activeLL' => 'especialidades', 'projectPhases' => $projectPhases, 'phases' => $phases));
    }

    public function getProjectPhases($id) {
        $projectPhases = \App\Project_Phase::where('project_id', $id)
                                           ->join('phases', 'project_phase.phase_id', '=', 'phases.id')
                                           ->select('phases.id as p_id', 'phases.name as p_name', 'phases.sigla as p_sigla', 'project_phase.id as proj_p_id')
                                           ->get();
        $phases = \App\Phase::all();
        $project = \App\Project::find($id);

        return view('managementProject.projectPhases', array('projectPhase' => $projectPhases, 'phases' => $phases, 'project' => $project, 'activeL' => 'informação', 'activeLL' => 'fases'));
    }

    public function getProjectPlanning($id) {
        $project = \App\Project::find($id);
        $phases = \App\Project_Phase::where('project_id', $id)->get();
        $expertise = \App\Project_Expertise::where('project_id', $id)->get();
        $planningTypes = \App\Planning_Type::all();
        $project_planning = \App\Project_Planning::where('project_id', $id)->get();

        foreach($phases as $phase) {
            $tempPhase = \App\Phase::find($phase->phase_id);
            $phase->name = $tempPhase->name;
        }

        foreach($expertise as $expert) {
            $tempExpert = \App\Expertise::find($expert->expertise_id);
            $expert->name = $tempExpert->name;
        }

        return view('managementProject.projectInformationPlanning', array('project' => $project, 'phases' => $phases, 'expertise' => $expertise, 'activeL' => 'informação', 'activeLL' => 'planeamento', 'planningTypes' => $planningTypes, 'project_planning' => $project_planning));
    }

    public function getCommercial() {
        $projects = \App\Commercial_Project::all();
        $expertise = \App\Expertise::all();
        $phases = \App\Phase::all();

        return view('commercialProposals', array('projects' => $projects, 'activeL' => 'comercial', 'activeLL' => 'propostas', 'phases' => $phases, 'expertise' => $expertise));
    }

    public function createCommercialProject(Request $r) {
        $project = new \App\Commercial_Project();
        $project->number = str_pad($r['code'], 2, '0', STR_PAD_LEFT);

        $projectTemp = \App\Commercial_Project::orderBy('sequentialNumber', 'desc')->first();

        if($projectTemp != null)
            $project->number = $project->number . str_pad($projectTemp->sequentialNumber + 1, 3, '0', STR_PAD_LEFT);
        else 
            $project->number = $project->number . str_pad(1, 3, '0', STR_PAD_LEFT);

        $project->name = $r['name'];
        $project->save();

        return redirect()->back();
    }

    public function getCommercialProject($id) {
        $project = \App\Commercial_Project::find($id);
        $projectTypes = \App\Project_Type::all();
        $utilizationTypes = \App\Utilization_Type::all();
        $constructionTypes = \App\Construction_Type::all();

        $projectDetails = \App\Commercial_Project_Details::where('project_id', $project->id)->first();

        if($projectDetails != null) {
            $project->projectDetails = $projectDetails;
            $project->projectDetails->constructionTypeName = \App\Construction_Type::find($projectDetails->constructionType)->name;
            $project->projectDetails->utilizationTypeName = \App\Utilization_Type::find($projectDetails->utilizationType)->name;
            $project->projectDetails->typeName = \App\Project_Type::find($projectDetails->type)->name;
        }

        return view('commercialProject', array('project' => $project, 'projectTypes' => $projectTypes, 'utilizationTypes' => $utilizationTypes, 'constructionTypes' => $constructionTypes, 'activeL' => 'informação', 'activeLL' => 'informações'));
    }

    public function editCommercialProjectCaracterization(Request $r) {
        $projectDetails = \App\Commercial_Project_Details::where('project_id', $r['id'])->first();

        if($projectDetails == null) {
            $projectDetails = new \App\Commercial_Project_Details();
            $projectDetails->project_id = $r['id'];
        }

        if($r['projectType'] != 0)
            $projectDetails->type = $r['projectType'];
        if($r['constructionType'] != 0)
            $projectDetails->constructionType = $r['constructionType'];
        if($r['utilizationType'] != 0)
            $projectDetails->utilizationType = $r['utilizationType'];
        if(is_numeric($r['totalNumberFloors']))
            $projectDetails->totalNumberFloors = $r['totalNumberFloors'];
        if(is_numeric($r['numberBuriedFloors']))
            $projectDetails->numberBuriedFloors = $r['numberBuriedFloors'];
        if(is_numeric($r['constructionArea']))
            $projectDetails->constructionArea = $r['constructionArea'];
        if(is_numeric($r['value']))
            $projectDetails->value = $r['value'];
        if(is_numeric($r['priceBySquareMeter']))
            $projectDetails->priceBySquareMeter = $r['priceBySquareMeter'];
        if(is_numeric($r['estimatedValue']))
            $projectDetails->estimatedValue = $r['estimatedValue'];

        $projectDetails->save();
    }

    public function editCommercialProjectDescription(Request $r) {
        $project = \App\Commercial_Project::find($r['id']);
        $projectDetails = \App\Commercial_Project_Details::where('project_id', $r['id'])->first();

        if($projectDetails == null) {
            $projectDetails = new \App\Commercial_Project_Details();
            $projectDetails->project_id = $r['id'];
        }

        if(is_numeric($r['code']))
            $project->number = $r['code'];
        if($r['name'] != "")
            $project->name = $r['name'];
        if($r['address'] != "")
            $projectDetails->address = $r['address'];
        if($r['title'] != "")
            $projectDetails->title = $r['title'];
        if($r['zip_code'] != "")
            $projectDetails->zip_code = $r['zip_code'];
        if($r['local'] != "")
            $projectDetails->local = $r['local'];

        $projectDetails->save();
        $project->save();

    }

    public function filterProjects(Request $r) {
        $obj = new stdClass();
        $obj->state = $r['state'];
        $obj->year = $r['year'];
        $obj->expertise = $r['expertise'];

        $memory = \App\User_Memory::where('user_id', Auth::user()->id)->first();

        if($memory != null) {
            $memory->management_operations_filter = serialize($obj);
            $memory->save();
        } else {
            $memory = new \App\User_Memory();
            $memory->user_id = Auth::user()->id;
            $memory->management_operations_filter = serialize($obj);
            $memory->save();
        }

        $state = $r['state'];
        if($r['year'] != 0 && $r['expertise'] != 0) {
            $year = substr($r['year'], 2, 2);
            $projects = \App\Project::where(DB::raw('substr(LPAD(project.number, 5, 0), 1, 2)'), $year)
                                    ->where('project_expertise.expertise_id', $r['expertise'])
                                    ->join('project_expertise', 'project_expertise.project_id', '=', 'project.id')
                                    ->select('project.*')
                                    ->whereNull('project_expertise.deleted_at')
                                    ->distinct()
                                    ->orderBy('number', 'desc')->get();
        } else if($r['expertise'] != 0 && $r['year'] != 0) {
            $year = substr($r['year'], 2, 2);
            $projects = \App\Project::where(DB::raw('substr(LPAD(project.number, 5, 0), 1, 2)'), $year)
                                    ->where('project_expertise.expertise_id', $r['expertise'])
                                    ->join('project_expertise', 'project_expertise.project_id', '=', 'project.id')
                                    ->select('project.*')
                                    ->whereNull('project_expertise.deleted_at')
                                    ->distinct()
                                    ->orderBy('number', 'desc')->get();
        } else if($r['expertise'] != 0) {
            $year = substr($r['year'], 2, 2);
            $projects = \App\Project::where('project_expertise.expertise_id', $r['expertise'])
                                    ->join('project_expertise', 'project_expertise.project_id', '=', 'project.id')
                                    ->select('project.*')
                                    ->whereNull('project_expertise.deleted_at')
                                    ->distinct()
                                    ->orderBy('number', 'desc')->get();
        } else if($r['year'] != 0) {
            $year = substr($r['year'], 2, 2);
            $projects = \App\Project::where(DB::raw('substr(LPAD(number, 5, 0), 1, 2)'), $year)->orderBy('number', 'desc')->get();
        } else {
            $projects = \App\Project::orderBy('number', 'desc')->get();
        }


        foreach($projects as $project) {
            $event = \App\Executed_Task::where('project_id', $project->id)
                                       ->join('state_types', 'state_types.id', '=', 'executed_tasks.subType')
                                       ->orderBy('start_date', 'desc')
                                       ->first();

            if($event != null) {
                $project->state_id = $event->id;
                $project->state = $event->name;
            }
            else {
               $project->state_id = 0;
               $project->state = "Sem Estado";
           }
        }

        if($state != 0) {
            $projects = $projects->filter(function ($project) use ($state) {
                return $project->state_id == $state;
            })->values();
        }
 
        return $projects;   
    }

    public function filterProjectsWithArgs($r) {
        $r = json_decode(json_encode($r), true);
        $state = $r['state'];
        if($r['year'] != 0 && $r['expertise'] != 0) {
            $year = substr($r['year'], 2, 2);
            $projects = \App\Project::where(DB::raw('substr(LPAD(project.number, 5, 0), 1, 2)'), $year)
                                    ->where('project_expertise.expertise_id', $r['expertise'])
                                    ->join('project_expertise', 'project_expertise.project_id', '=', 'project.id')
                                    ->select('project.*')
                                    ->whereNull('project_expertise.deleted_at')
                                    ->distinct()
                                    ->orderBy('number', 'desc')->get();
        } else if($r['expertise'] != 0 && $r['year'] != 0) {
            $year = substr($r['year'], 2, 2);
            $projects = \App\Project::where(DB::raw('substr(LPAD(project.number, 5, 0), 1, 2)'), $year)
                                    ->where('project_expertise.expertise_id', $r['expertise'])
                                    ->join('project_expertise', 'project_expertise.project_id', '=', 'project.id')
                                    ->select('project.*')
                                    ->whereNull('project_expertise.deleted_at')
                                    ->distinct()
                                    ->orderBy('number', 'desc')->get();
        } else if($r['expertise'] != 0) {
            $year = substr($r['year'], 2, 2);
            $projects = \App\Project::where('project_expertise.expertise_id', $r['expertise'])
                                    ->join('project_expertise', 'project_expertise.project_id', '=', 'project.id')
                                    ->select('project.*')
                                    ->whereNull('project_expertise.deleted_at')
                                    ->distinct()
                                    ->orderBy('number', 'desc')->get();
        } else if($r['year'] != 0) {
            $year = substr($r['year'], 2, 2);
            $projects = \App\Project::where(DB::raw('substr(LPAD(number, 5, 0), 1, 2)'), $year)->orderBy('number', 'desc')->get();
        } else {
            $projects = \App\Project::orderBy('number', 'desc')->get();
        }


        foreach($projects as $project) {
            $event = \App\Executed_Task::where('project_id', $project->id)
                                       ->join('state_types', 'state_types.id', '=', 'executed_tasks.subType')
                                       ->orderBy('start_date', 'desc')
                                       ->first();

            if($event != null) {
                $project->state_id = $event->id;
                $project->state = $event->name;
            }
            else {
               $project->state_id = 0;
               $project->state = "Sem Estado";
           }
        }

        if($state != 0) {
            $projects = $projects->filter(function ($project) use ($state) {
                return $project->state_id == $state;
            })->values();
        }
 
        return $projects;
    }

    public function getCommercialProjectClient($id) {
        $contacts = \App\Contact::orderBy('firstName')->get();
        $companyContacts = \App\Company_Contact::all();
        $project = \App\Commercial_Project::find($id);
        $client = \App\Commercial_Project_Client::where('commercial_project_id', $id)->first();

        if($client != null) {
            if($client->contact_id != null) {
                $client->contact = \App\Contact::find($client->contact_id);
                $client->r_name = \App\User::find($client->responsible_id)->name;
            }
        }

        return view('commercial_project_client', array('activeL' => 'informação', 'activeLL' => 'cliente', 'contacts' => $contacts, 'companyContacts' => $companyContacts, 'project' => $project, 'client' => $client));
    }

    public function saveCommercialProjectPersonalClient(Request $r) {
        $contact = \App\Commercial_Project_Client::where('commercial_project_id', $r['project_id'])->first();
        if($contact == null)
            $contact = new \App\Commercial_Project_Client();

        $contact->commercial_project_id = $r['project_id'];
        $contact->contact_id = $r['client_id'];
        $contact->company_contact_id = null;
        $contact->responsible_id = $r['responsible_id'];
        $contact->save();
    }

    public function getCommercialProjectExpertise($id) {
        $project = \App\Commercial_Project::find($id);
        $projectExpertise = \App\Commercial_Project_Expertise::where('commercial_project_id', $id)
                                                           ->where('parent', '=', 0)
                                                           ->join('expertise', 'commercial_project_expertise.expertise_id', '=', 'expertise.id')
                                                           ->select('expertise.id as e_id', 'expertise.name as e_name', 'expertise.parent as e_parent', 'expertise.sigla as e_sigla', 'commercial_project_expertise.id as p_e_id', 'value as e_value')
                                                           ->get();
        $projectPhases = \App\Commercial_Project_Phase::where('commercial_project_id', $id)
                                                   ->join('phases', 'commercial_project_phase.phase_id', '=', 'phases.id')
                                                   ->select('phases.id as p_id', 'phases.name as p_name', 'phases.sigla as p_sigla', 'commercial_project_phase.id as proj_p_id')
                                                   ->get();

        foreach($projectExpertise as $expert) {
            $expert->subExpertise = \App\Commercial_Project_Expertise::join('expertise', 'commercial_project_expertise.expertise_id', '=', 'expertise.id')
                                                          ->where('expertise.parent', $expert->e_id)
                                                          ->where('commercial_project_id', $id)
                                                          ->select('expertise.id as e_id', 'expertise.name as e_name', 'expertise.parent as e_parent', 'expertise.sigla as e_sigla', 'commercial_project_expertise.id as p_e_id')
                                                          ->get();

            foreach($expert->subExpertise as $subExpert) {
                $subExpert->phases = \App\Commercial_Project_Expertise_Phase::where('commercial_project_expertise_id', $subExpert->p_e_id)->get();
            }

            $expert->phases = \App\Commercial_Project_Expertise_Phase::where('commercial_project_expertise_id', $expert->p_e_id)->get();
        }

        $phases = \App\Phase::all();
        $expertise = \App\Expertise::where('parent', '=', 0)->get();
        $subExpertise = \App\Expertise::where('parent', '!=', 0)->get();
        $iva = \App\Iva::orderBy('percentage')->get();
        $hourlyRate = \App\Commercial_Hourly_Rate::orderBy('value')->get();


        return view('commercial_project_expertise', array('activeL' => "informação", 'activeLL' => 'especialidades', 'project' => $project, 'projectExpertise' => $projectExpertise, 'projectPhases' => $projectPhases, 'phases' => $phases, 'expertise' => $expertise, 'subExpertise' => $subExpertise, 'iva' => $iva, 'hourlyRate' => $hourlyRate));
    }

    public function addCommercialProjectExpertise(Request $r, $id) {
        $expertise = new \App\Commercial_Project_Expertise();
        $expertise->expertise_id = $r['expertise'];
        $expertise->commercial_project_id = $id;
        $expertise->save();

        return redirect()->back();
    }

    public function addCommercialProjectPhase(Request $r, $id) {
        $phase = new \App\Commercial_Project_Phase();
        $phase->phase_id = $r['phase'];
        $phase->commercial_project_id = $id;
        $phase->save();

        return redirect()->back();
    }

    public function editCommercialProjectExpertisePhases(Request $r) {
        foreach($r['obj'] as $key => $obj) {
            $project_expertise_id = \App\Commercial_Project_Expertise::where('expertise_id', $key)->where('commercial_project_id', $r['project_id'])->first()->id;
            for($i = 0; $i < count($obj); $i++) {
                if($obj[$i][0] == '-') {
                    $projectExpertisePhase = \App\Commercial_Project_Expertise_Phase::where('commercial_project_expertise_id', $project_expertise_id)
                                                                         ->where('phase_id', substr($obj[$i], 1))
                                                                         ->forceDelete();
                } else {
                    $projectExpertisePhase = \App\Commercial_Project_Expertise_Phase::where('commercial_project_expertise_id', $project_expertise_id)
                                                                     ->where('phase_id', $obj[$i])
                                                                     ->first();
                    if($projectExpertisePhase == null) {
                        $projectExpertisePhase = new \App\Commercial_Project_Expertise_Phase();
                        $projectExpertisePhase->commercial_project_expertise_id = $project_expertise_id;
                        $projectExpertisePhase->phase_id = $obj[$i];
                        $projectExpertisePhase->save();
                    }
                }
            }
        }

        foreach($r['expertValues'] as $key => $value) {

            $project_expertise = \App\Commercial_Project_Expertise::find($key);
            $project_expertise->value = $value;
            $project_expertise->save();
        }

        foreach($r['percentages'] as $key => $value) {
            for($i = 0; $i < count($value); $i++) {
                $projectExpertisePhase = \App\Commercial_Project_Expertise_Phase::where('commercial_project_expertise_id', $key)
                                                                                ->where('phase_id', $value[$i][0])
                                                                                ->first();
                if($projectExpertisePhase != null && $value[$i][1] > 0) {
                    $projectExpertisePhase->percentage = $value[$i][1];
                    $projectExpertisePhase->save();
                }
            }
        }
    }

    public function getCommercialProjectPlannedTasks($id) {
        $project = \App\Commercial_Project::find($id);
        $phases = \App\Commercial_Project_Phase::where('commercial_project_id', $id)->get();
        $expertise = \App\Commercial_Project_Expertise::where('commercial_project_id', $id)->get();
        $planningTypes = \App\Planning_Type::all();
        $project_planning = \App\Commercial_Planned_Task::where('project_id', $id)
                                                 ->join('expertise', 'expertise.id', '=', 'commercial_planned_tasks.expertise')
                                                 ->join('phases', 'phases.id', '=', 'commercial_planned_tasks.phase')
                                                 ->join('planning_types', 'planning_types.id', '=', 'commercial_planned_tasks.type')
                                                 ->select('expertise.name as e_name', 'phases.name as ph_name', 'planning_types.name as pl_name', 'startDate')
                                                 ->get();

        foreach($phases as $phase) {
            $tempPhase = \App\Phase::find($phase->phase_id);
            $phase->name = $tempPhase->name;
        }

        foreach($expertise as $expert) {
            $tempExpert = \App\Expertise::find($expert->expertise_id);
            $expert->name = $tempExpert->name;
        }

        return view('commercial_project_planned_tasks', array('project' => $project, 'phases' => $phases, 'expertise' => $expertise, 'activeL' => 'informação', 'activeLL' => 'planeado', 'planningTypes' => $planningTypes, 'project_planning' => $project_planning));
    }

    public function addCommercialProjectPlannedTask(Request $r, $id) {

        $plannedTasks = new \App\Commercial_Planned_Task();
        $plannedTasks->project_id = $id;
        $plannedTasks->type = $r['type'];
        $plannedTasks->phase = $r['phase'];
        $plannedTasks->expertise = $r['expertise'];
        $plannedTasks->startDate = $r['startDate'];
        $plannedTasks->milestone = 1;
        $plannedTasks->save();

        return redirect()->back();
    }

    public function getCommercialProjectPlanningTasks($id) {
        $project = \App\Commercial_Project::find($id);

        $tasks = \App\Commercial_Task::where('project_id', $id)
                          ->join('users', 'users.id', '=', 'commercial_tasks.user_id')
                          ->leftJoin('expertise', 'expertise_id', '=', 'expertise.id')
                          ->leftJoin('phases', 'phase_id', '=', 'phases.id')
                          ->join('project_event_types', 'commercial_tasks.type', 'project_event_types.id')
                          ->select('expertise.sigla as e_sigla', 'phases.sigla as p_sigla', 'commercial_tasks.name as t_name', 'commercial_tasks.id as t_id', 'start_date as start_date', 'end_date as end_date', 'users.sigla as u_sigla', 'subExpertise_id as subExpertise_id', 'project_event_types.sigla as ev_sigla', 'commercial_tasks.notes as notes')
                          ->get();

        foreach ($tasks as $task) {
            $subExpertise = \App\Expertise::find($task->subExpertise_id);
            if($subExpertise != null)
                $task->subExpertiseName = $subExpertise->name;
            else
                $task->subExpertiseName = '-';

            $task_timer = \App\Commercial_Executed_Task::where('plannedTask_id', $task->t_id)
                                        ->orderBy('id', 'desc')
                                        ->first();

            if($task_timer == null)
                $task->state = 0;
            else {
                $task->state = $task_timer->done;
            }

            if($task->subExpertise_id > 0)
                $task->se_sigla = \App\Expertise::find($task->subExpertise_id)->sigla;

            $date1 = new DateTime($task->start_date);
            $task->start_date = $date1->format('d-m-y');
            $date1 = new DateTime($task->end_date);
            $task->end_date = $date1->format('d-m-y');
        }

        $tasks = $tasks->sortByDesc(function($task, $key) {
            if($task['state'] != 100)
                return $task['state'];
            else
                return -1;
        });               

        $expertise = \App\Commercial_Project_Expertise::where('commercial_project_id', $id)
                                           ->where('parent', 0)
                                           ->join('expertise', 'expertise.id', '=', 'commercial_project_expertise.expertise_id')
                                           ->select('expertise_id as id', 'expertise.name as name', 'commercial_project_expertise.id as proj_e_id')
                                           ->get();
        $subExpertise = \App\Commercial_Project_Expertise::where('commercial_project_id', $id)
                                           ->where('parent', '!=', 0)
                                           ->join('expertise', 'expertise.id', '=', 'commercial_project_expertise.expertise_id')
                                           ->select('expertise_id as id', 'expertise.name as name', 'parent as parent', 'commercial_project_expertise.id as proj_e_id')
                                           ->get();

        $phases = \App\Commercial_Project_Phase::where('commercial_project_id', $id)
                                    ->join('phases', 'phases.id', '=', 'commercial_project_phase.phase_id')
                                    ->select('phase_id as id', 'phases.name as name')
                                    ->get();

        $eventTypes = \App\Project_Event_Type::all();

        return view('commercialProjectTasks', array('tasks' => $tasks, 'activeL' => 'informação', 'activeLL' => 'planeamento', 'project' => $project, 'phases' => $phases, 'expertise' => $expertise, 'subExpertise' => $subExpertise, 'eventTypes' => $eventTypes));
    }

    public function addCommercialProjectPlanningTask(Request $r, $id) {

        $projectTask = new \App\Commercial_Task();
        $projectTask->project_id = $id;
        if($r['phase'] != 0)
            $projectTask->phase_id = $r['phase'];
        if($r['expertise'] != 0)
            $projectTask->expertise_id = $r['expertise'];
        if($r['subExpertise'] != 0)
            $projectTask->subExpertise_id = $r['subExpertise'];
        
        $projectTask->name = $r['name'];
        $projectTask->start_date = $r['start_date'];
        $projectTask->end_date = $r['end_date'];
        $projectTask->user_id = $r['user'];
        $projectTask->type = $r['type'];
        $projectTask->notes = $r['notes'];

        $projectTask->save();

        return redirect()->back();
    }

    public function getCommercialProjectExecutedTasks($id) {
        $project = \App\Commercial_Project::find($id);
        $states = \App\State_Type::all();
        $executedTasks = \App\Commercial_Executed_Task::where('project_id', $id)
                          ->join('users', 'users.id', '=', 'commercial_executed_tasks.user_id')
                          ->leftJoin('expertise', 'expertise_id', '=', 'expertise.id')
                          ->leftJoin('phases', 'phase_id', '=', 'phases.id')
                          ->leftJoin('state_types', 'commercial_executed_tasks.subType', 'state_types.id')
                          ->join('project_event_types', 'commercial_executed_tasks.type', 'project_event_types.id')
                          ->select('expertise.sigla as e_sigla', 'phases.sigla as p_sigla', 'commercial_executed_tasks.name as t_name', 'commercial_executed_tasks.id as t_id', 'start_date as start_date', 'users.sigla as u_sigla', 'subExpertise_id as subExpertise_id', 'project_event_types.sigla as ev_type', 'notes as notes', 'done as state', 'commercial_executed_tasks.hours as hours', 'commercial_executed_tasks.minutes as minutes', 'plannedTask_id')
                          ->orderBy('start_date', 'desc')
                          ->orderBy('t_id', 'desc')
                          ->get();


        /*$executedTasks = \App\TaskTimer::where('task_timer.project_id', $id)
                                       ->join('users', 'users.id', '=', 'task_timer.user_id')
                                       ->leftJoin('expertise', 'task_timer.expertise_id', '=', 'expertise.id')
                                       ->leftJoin('phases', 'task_timer.phase_id', '=', 'phases.id')    
                                       ->select('expertise.sigla as e_sigla', 'phases.sigla as p_sigla', 'task_timer.task_name as t_name', 'task_timer.id as t_id', 'date as start_date', 'users.sigla as u_sigla', 'task_timer.subExpertise_id as subExpertise_id', DB::raw("'TF' AS ev_sigla"), 'task_timer.notes as notes', 'task_timer.done as state', 'task_timer.hours as hours', 'task_timer.minutes as minutes', 'task_timer.programmedTask_id as programmedTask_id')
                                       ->union($tasks)
                                       ->orderBy('start_date', 'desc')
                                       ->orderBy('t_id', 'desc')
                                       ->get();*/

        foreach($executedTasks as $task) {

            if($task->subType == null)
                $task->subType = '-';
            if($task->subExpertise_id > 0)
                $task->se_sigla = \App\Expertise::find($task->subExpertise_id)->sigla;
            else
                $task->se_sigla = '-';

            $date1 = new DateTime($task->start_date);
            $task->start_date = $date1->format('d-m-y');

            if(is_numeric($task->state)) {
                if($task->plannedTask_id != null) {
                    $task_temp = \App\Commercial_Executed_Task::where('plannedTask_id', $task->plannedTask_id)->orderBy('id', 'desc')->first();
                    if($task->t_id == $task_temp->id) {
                        $task->outdated = 0;
                    } else
                        $task->outdated = 1;
                }
            }
        }

        $expertise = \App\Commercial_Project_Expertise::where('commercial_project_id', $id)
                                           ->where('parent', 0)
                                           ->join('expertise', 'expertise.id', '=', 'commercial_project_expertise.expertise_id')
                                           ->select('expertise_id as id', 'expertise.name as name', 'commercial_project_expertise.id as proj_e_id')
                                           ->get();
        $subExpertise = \App\Commercial_Project_Expertise::where('commercial_project_id', $id)
                                           ->where('parent', '!=', 0)
                                           ->join('expertise', 'expertise.id', '=', 'commercial_project_expertise.expertise_id')
                                           ->select('expertise_id as id', 'expertise.name as name', 'parent as parent')
                                           ->get();

        $phases = \App\Commercial_Project_Phase::where('commercial_project_id', $id)
                                    ->join('phases', 'phases.id', '=', 'commercial_project_phase.phase_id')
                                    ->select('phase_id as id', 'phases.name as name')
                                    ->get();

        $eventTypes = \App\Project_Event_Type::all();

        $plannedEvents = \App\Commercial_Task::where('project_id', $id)->orderBy('start_date', 'desc')->get();

        $plannedTasks = \App\Commercial_Task::where('project_id', $id)->where('type', 6)->get();
        foreach($plannedTasks as $key => $task) {
            $task = \App\Commercial_Executed_Task::where('plannedTask_id', $task->id)
                                        ->where('done', 100)
                                        ->first();
            if($task != null) {
                $plannedTasks->forget($key);
            }
        }

        $plannedTasks = $plannedTasks->values();

        return view('commercial_executed_tasks', array('activeL' => 'informação', 'activeLL' => 'executado', 'project' => $project, 'phases' => $phases, 'expertise' => $expertise, 'subExpertise' => $subExpertise, 'eventTypes' => $eventTypes, 'plannedTasks' => $plannedTasks, 'executedTasks' => $executedTasks, 'states' => $states, 'plannedEvents' => $plannedEvents));

    }

    public function addCommercialProjectExecutedTask(Request $r, $id) {
        $task = new \App\Commercial_Executed_Task();
        $task->project_id = $id;
        $task->user_id = $r['user'];
        if($r['type'] == 6) {
            $taskTemp = \App\Commercial_Task::find($r['task']);
            $task->expertise_id = $taskTemp->expertise_id;
            $task->subExpertise_id = $taskTemp->subExpertise_id;
            $task->phase_id = $taskTemp->phase_id;
            $task->name = $taskTemp->name;
            $task->minutes = $r['minutes'];
            $task->hours = $r['hours'];
            $task->start_date = $r['start_date'];
            $task->done = $r['statePercentage'];
            $task->plannedTask_id = $taskTemp->id;
            $task->type = $r['type'];
            $task->notes = $r['notes'];

            $task->save();
        } else if($r['type'] == 1) {
            $task->name = \App\State_Type::find($r['state'])->name;
            $task->subType = $r['state'];
            $task->start_date = $r['start_date'];
            $task->hours = $r['hours'];
            $task->minutes = $r['minutes'];
            $task->notes = $r['notes'];
            $task->type = $r['type'];

            $task->save();
        } else {
            $plannedTask = \App\Commercial_Task::find($r['name']);
            $task->plannedTask_id = $plannedTask->id;
            $task->name = $plannedTask->name;
            $task->start_date = $r['start_date'];
            $task->hours = $r['hours'];
            $task->minutes = $r['minutes'];
            $task->notes = $r['notes'];
            $task->type = $r['type'];

            $task->save();
        }

        return redirect()->back();
    }

}
