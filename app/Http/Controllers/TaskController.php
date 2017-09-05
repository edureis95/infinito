<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Auth;

class TaskController extends Controller
{
	public function create_task_form() {
		$users = \App\User::all();
		$projects = \App\Project::all();
        $companies = \App\Company::all();
        $activities = \App\Activity::all();
		return view('/create_task', array('users' => $users, 'projects' => $projects, 'companies' => $companies, 'active' => 'gestao_projetos', 'activities' => $activities));
	}

    public function create_task() {
    	$task = new \App\GanttTask();
    	
    	$task->text = Input::get('text');
    	$task->start_date = Input::get('start_date');
    	$task->duration = Input::get('duration');
    	//$task->progress = Input::get('progress');
    	//$task->sortorder = Input::get('sortorder');
    	if(Input::get('parent_task') != "Nenhuma tarefa") {
    		$task->parent = Input::get('parent_task');
            $activity = \App\Activity::where('activity_Task_ID', Input::get('parent_task'))->first();
            $activity->task_counter = $activity->task_counter + 1;
            $activity->save();
            $task->number = $activity->task_counter;
    	}
    	else {
    		$task->parent = Input::get('parent_project');
            $project = \App\Project::where('project_Task_ID', Input::get('parent_project'))->first();
            $project->task_counter = $project->task_counter + 1;
            $project->save();
            $task->number = $project->task_counter;
    	}
    	$task->deadline = Input::get('deadline');
    	$task->planned_start = Input::get('planned_start');
    	//$task->planned_end = Input::get('planned_end');
    	$task->end_date = Input::get('end_date');
        $task->responsible = Input::get('responsible');
        $task->creator = Auth::user()->id;

    	$task->save();
    }
}
