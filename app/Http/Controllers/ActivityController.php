<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Auth;

class ActivityController extends Controller
{

	public function create_activity_form() {
		$users = \App\User::all();
		$projects = \App\Project::all();
        $companies = \App\Company::all();
		return view('/create_activity', array('users' => $users, 'projects' => $projects, 'companies' => $companies, 'active' => 'gestao_projetos'));
	}

    public function create_activity() {
    	$project = \App\Project::where('project_Task_ID', Input::get('parent_project'))->first();
    	$project->activity_counter = $project->activity_counter + 1;
    	$project->save();

    	$task = new \App\GanttTask();
        $task->text = Input::get('name');
        $task->type = 2;
        $task->parent = Input::get('parent_project');
        $task->number = $project->activity_counter;
        $task->responsible = Input::get('responsible');
        $task->creator = Auth::user()->id;
        $task->save();

    	$activity = new \App\Activity();
    	$activity->name = Input::get('name');
    	$activity->activity_task_id = $task->id;
    	$activity->description = Input::get('description');
    	$activity->project = $project->id;
    	$activity->responsible = Input::get('responsible');
    	$activity->save();
    }
}
