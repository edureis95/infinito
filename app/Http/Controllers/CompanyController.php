<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Input;
use App\AbsenceEvent;
use Dhtmlx\Connector\SchedulerConnector;

class CompanyController extends Controller
{
    public function company_members($id) {
    	$company = \App\Company::find($id);

        $members = \App\User::join('departments', 'users.function', '=', 'departments.id')
                            ->select('users.*', 'departments.name as department_name')
                            ->get();

        foreach($members as $member) {
            $member->supervisors = \App\Department::where('supervisor', $member->id)->get();
        }

    	return view('company_members', array('members' => $members, 'company' => $company, 'active' => 'empresa', 'activeL' => 'colaboradores'));
    }

    public function company_structure() {
    	$companies = \App\Company::all();
    	$users = \App\User::all();

    	$departments = \App\Department::join('users', 'users.id', '=', 'departments.supervisor')
    						->select('departments.id', 'departments.supervisor','departments.name as department_name', 'departments.parent', 'users.name as user_name', 'users.avatar as user_avatar')
    						->get();

    	foreach($departments as $department) {
    		$department->employees = \App\User::where('function', $department->id)->get();
    	}

        $adjuncts = \App\Adjunct::join('users', 'users.id', '=', 'adjuncts.supervisor')
                                ->select('adjuncts.id', 'adjuncts.supervisor', 'adjuncts.name as adjunct_name', 'adjuncts.parent', 'users.name as user_name', 'users.avatar as user_avatar')
                                ->get();

    	return view('company_structure', array('departments' => $departments, 'companies' => $companies, 'users' => $users, 'active' => 'empresa', 'activeL' => 'estrutura', 'adjuncts' => $adjuncts));
    }

    public function add_department() {
    	$department = new \App\Department();
    	$department->name = Input::get('name');
    	$department->supervisor = Input::get('supervisor');
    	$department->parent = Input::get('parent');
    	$department->save();

    	return redirect('structure');
    }

    public function add_user() {
        $user = \App\User::find(Input::get('user'));
        $user->function = Input::get('department');
        $user->save();

        return redirect('structure');
    }

    public function edit_department() {
        $department = \App\Department::find(Input::get('department'));
        $department->name = Input::get('name');
        $department->supervisor = Input::get('supervisor');
        $department->parent = Input::get('parent');
        $department->save();

        return redirect('structure');
    }

    public function delete_department() {
        $department = \App\Department::find(Input::get('department'));
        $users = \App\User::where('function', $department->id)->withTrashed()->update(['function' => 1]);
        $department->delete();

        return redirect('structure');
    }

    public function showAbsenceCalendar() {
        return view('absenceCalendar', array('activeL' => 'ausências'));
    }

    public function data() {
        $scheduler = new SchedulerConnector(null, "PHPLaravel");
        $scheduler->configure(\App\SchedulerEvent::where('type', 7), "event_id", "start_date, end_date, event_name, user_id, absence_type");
        $scheduler->render();
    }

    public function getAbsenceReasons() {
        return \App\Absence_Reason::all();
    }

    public function getUserName($id) {
        $user = \App\User::find($id);
        return $user->name;
    }

    public function getUserNamesList() {
        $users = \App\User::select('id', 'name')->get();
        return $users;
    }
}
