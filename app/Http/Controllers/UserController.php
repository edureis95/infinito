<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Image;
use File;
use Input;
use DateTime;
use DB;

class UserController extends Controller
{
    //
    public function profile($id) {
      $userDetails = \App\User_Detail::where('user_id', $id)->first();
    	return view('/profile', array('user' => \App\User::find($id), 'activeL' => 'perfil', 'activeLL' => 'geral', 'userDetails' => $userDetails));
    }

    public function update_avatar(Request $request, $id) {

    	//Handle the user upload of avatar
    	if($request->hasFile('avatar')){
    		$avatar = $request->file('avatar');
    		$user = Auth::user();
    		$path = '/uploads/avatars/';

    		if($user->avatar != 'default.jpg') {
    			File::Delete(public_path($path . $user->avatar));
    		}

    		$filename = Auth::user()->name . time() . '.' . $avatar->getClientOriginalExtension();
    		Image::make($avatar)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save( public_path($path . $filename));

    		$user->avatar = $filename;
    		$user->save();
    	}
    	return view('/profile', array('user' => \App\User::find($id), 'active' => 'empresa'));
    }

    public function edit_profile_form($id) {
        $companies = \App\Company::All();
        $user = \App\User::find($id);
        $user_company = \App\Company::find($user->company);
        $user_details = \App\User_Detail::where('user_id', $id)->first();
        return view('edit_profile', array('user' => $user, 'companies' => $companies, 'user_company' => $user_company, 'active' => 'empresa', 'user_details' => $user_details, 'activeL' => 'geral'));
    }

    public function showEditDetails($id) {
        $user = \App\User::find($id);
        $user_details = \App\User_Detail::where('user_id', $id)->first();
        return view('edit_profile_details', array('user' => $user, 'active' => 'empresa', 'user_details' => $user_details, 'activeL' => 'outra'));
    }

    public function edit_profile(Request $request, $id) {

        $user = \App\User::find($id);
        $user->name = Input::get('name');
        $user->cell_phone = Input::get('cell_phone');
        $user->desk_phone = Input::get('desk_phone');
        $user->skype = Input::get('skype');
        $user->sigla = Input::get('sigla');

        //Handle the user upload of avatar
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $user = Auth::user();
            $path = '/uploads/avatars/';

            if($user->avatar != 'default.jpg') {
                File::Delete(public_path($path . $user->avatar));
            }

            $filename = Auth::user()->name . time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save( public_path($path . $filename));

            $user->avatar = $filename;
        } 
        
        $user->save();

        return redirect('profile/' . $id);
    }

    public function edit_profile_details(Request $r, $id) {
      $user = \App\User_Detail::where('user_id', $id)->first();
      if($user == null)
        $user = new \App\User_Detail();

      if($r['nif'] != "")
        $user->nif = $r['nif'];
      if($r['niss'] != "")
        $user->niss = $r['niss'];
      if($r['iban'] != "")
        $user->iban = $r['iban'];
      if($r['bank'] != "")
        $user->bank = $r['bank'];
      if($r['address'] != "")
        $user->address = $r['address'];
      if($r['zip_code'] != "")
        $user->zip_code = $r['zip_code'];
      if($r['local'] != "")
        $user->local = $r['local'];
      if($r['insurance'] != "")
        $user->insurance = $r['insurance'];
      $user->user_id = $id;

      $user->save();  

      return redirect()->back();

    }

    public function getPersonalHoursApproval() {
        $tasks = \App\TaskTimer::where('user_id', Auth::user()->id)
                               ->join('project', 'task_timer.project_id', '=', 'project.id')
                               ->leftJoin('phases', 'task_timer.phase_id', '=', 'phases.id')
                               ->leftjoin('expertise', 'task_timer.expertise_id', '=', 'expertise.id')
                               ->join('users', 'task_timer.user_id', '=', 'users.id')
                               ->select('task_timer.task_name as t_name', 'task_timer.hours as t_hours', 'task_timer.minutes as t_min', 'task_timer.created_at as t_created_at', 'project.number as p_number', 'project.name as p_name', 'phases.sigla as ph_sigla', 'expertise.sigla as e_sigla', 'users.name as u_name', 'users.sigla as u_sigla', 'task_timer.id as t_id', 'task_timer.done as done', DB::raw('Date_Format(task_timer.date, "%d-%m-%y") as t_date'), 'task_timer.approved as approved', 'task_timer.programmedTask_id as programmedTask_id')
                               ->orderBy('task_timer.date', 'desc')
                               ->orderBy('task_timer.id', 'desc')
                               ->get();

        foreach($tasks as $task) {
            if($task->programmedTask_id != null) {
                $task_temp = \App\TaskTimer::where('programmedTask_id', $task->programmedTask_id)->orderBy('id', 'desc')->first();
                if($task->t_id == $task_temp->id) {
                    $task->outdated = 0;
                } else
                    $task->outdated = 1;
            }
        }

        $expertise = \App\Project_Expertise::where('parent', 0)
                                           ->join('expertise', 'expertise.id', '=', 'project_expertise.expertise_id')
                                           ->select('expertise_id as id', 'expertise.name as name', 'project_expertise.id as proj_e_id')
                                           ->get();
        $subExpertise = \App\Project_Expertise::where('parent', '!=', 0)
                                           ->join('expertise', 'expertise.id', '=', 'project_expertise.expertise_id')
                                           ->select('expertise_id as id', 'expertise.name as name', 'parent as parent')
                                           ->get();

        $phases = \App\Project_Phase::join('phases', 'phases.id', '=', 'project_phase.phase_id')
                                    ->select('phase_id as id', 'phases.name as name')
                                    ->get();
    
        return view('personalHoursApproval', array('tasks' => $tasks, 'activeL' => 'registoHoras', 'expertise' => $expertise, 'phases' => $phases, 'subExpertise' => $subExpertise));
    }

    public function getPersonalAbsence() {
        $absencesTemp = \App\AbsenceEvent::join('users', 'users.id', '=', 'absence.user_id')
                                     ->where('users.id', Auth::user()->id)
                                     ->join('absence_reasons', 'absence_reasons.id', '=', 'absence.type')
                                     ->select('users.name as u_name', 'users.sigla as u_sigla', 'absence_reasons.name as a_name', 'absence.start_date as start_date', 'absence.end_date as end_date', 'absence.text as text', 'absence.event_id as a_id', 'absence.approved as a_ap');

        $absences = \App\SchedulerEvent::join('users', 'users.id', '=', 'scheduler_events.user_id')
                                       ->where('users.id', Auth::user()->id)
                                       ->where('scheduler_events.type', 7)
                                       ->join('absence_reasons', 'absence_reasons.id', '=', 'scheduler_events.absence_type')
                                       ->select('users.name as u_name', 'users.sigla as u_sigla', 'absence_reasons.name as a_name', 'start_date', 'end_date', 'event_name as text', 'scheduler_events.event_id as a_id', 'approved as a_ap')
                                       ->union($absencesTemp)
                                       ->get();

        foreach ($absences as $absence) {
            $date1 = new DateTime($absence->start_date);
            $date1String = $date1->format('d-m-y');
            //$absence->start_date = $date1->format('d-m-y H:i');
            $date2 = new DateTime($absence->end_date);
            $date2String = $date2->format('d-m-y');
            //$absence->end_date = $date1->format('d-m-y H:i');
            if($date1String == $date2String) {
                $absence->start_date = $date1->format('d-m-y');
                $absence->end_date = $date2->format('H') - $date1->format('H');
            } else {
                $absence->start_date = $date1->format('d-m-y');
                $absence->end_date = $date2->format('d-m-y');
            }
        }

        return view('personalAbsence', array('absences' => $absences, 'activeL' => 'ausências'));
    }

    public function getApprovalDetail(Request $r) {
        $task = \App\TaskTimer::leftJoin('expertise', 'expertise.id', '=', 'expertise_id')
                                  ->leftJoin('phases', 'phases.id', '=', 'phase_id')
                                  ->where('task_timer.id', $r['id'])
                                  ->select('task_name as name', 'phases.sigla as phaseSigla', 'expertise.sigla as expertiseSigla', 'date as start_date', 'subexpertise_id as subexpertise_id', 'expertise_id as expertise_id', 'phase_id as phase_id', 'hours', 'minutes', 'approved')
                                  ->first();

        $subExpertise = \App\Expertise::where('id', $task->subexpertise_id)->first();
        if($subExpertise != null)
            $task->subExpertiseSigla = $subExpertise->sigla;

        return $task;
    }

    public function editApproval(Request $r) {
        $task = \App\TaskTimer::find($r['id']);

        $task->date = $r['date'];
        $task->hours = $r['hours'];
        $task->minutes = $r['minutes'];
        $task->approved = 0;
        $task->save();
    }

    public function removeTaskTimer(Request $r) {
        $taskTimer = \App\TaskTimer::find($r['id']);
        $ganttTask = \App\GanttTask::find($taskTimer->ganttTask_id);

        $taskTimers = \App\TaskTimer::where('ganttTask_id', $taskTimer->ganttTask_id)->get();
        if(count($taskTimers) > 1) {
            $duration = ceil($taskTimer->hours + ($taskTimer->minutes / 60));
            $ganttTask->duration -= $duration;
            $ganttTask->save();
            $taskTimer->delete();
        } else {
            $ganttTask->delete();
            $taskTimer->delete();
        }
    }
}
