<?php
namespace App\Http\Controllers;
use App\GanttTask;
use App\GanttLink;
use Dhtmlx\Connector\GanttConnector;
use Dhtmlx\Connector\JSONGanttConnector;
use Dhtmlx\Connector\JSONDataConnector;
use Auth;

class GanttController extends Controller
{
    public function data() {
        $connector = new GanttConnector(null, "PHPLaravel");
        $connector->mix('open', 1);
        $connector->enable_log('log');
        $connector->render_links(new GanttLink(), "id", "source,target,type");

        $tasks = GanttTask::where('progress', '<', 1)
                          ->where('gantt_tasks.type', 0)
                          ->join('tasks', 'tasks.ganttTask_id', '=', 'gantt_tasks.id')
                          ->join('users', 'users.id', '=', 'tasks.user_id')
                          ->select('gantt_tasks.*', 'tasks.name as t_name', 'users.sigla as u_sigla');

        $executedTasks = GanttTask::where('gantt_tasks.type', 3)
                          ->join('task_timer', 'task_timer.ganttTask_id', '=', 'gantt_tasks.id')
                          ->join('users', 'users.id', '=', 'task_timer.user_id')
                          ->select('gantt_tasks.*', 'task_timer.task_name', 'users.sigla as u_sigla');

        $connector->render_table(GanttTask::where('progress', '<', 1)
                                          ->where('type', '!=', 0)
                                          ->where('type', '!=', 3)
                                          ->select('gantt_tasks.*', 'gantt_tasks.text as t_name', 'gantt_tasks.responsible as u_sigla')
                                          ->union($tasks)
                                          ->union($executedTasks)
                                            ,"id","start_date,duration, t_name,progress,parent,type,number,milestone, u_sigla", "end_date");
    }

    public function project_gantt($projectId) {
    	$project = \App\Project::find($projectId);
    	$task = \App\GanttTask::find($project->project_Task_ID);
        
    	return view('/gantt_project', array('task' => $task, 'project' => $project, 'active' => 'gestao_projetos'));
    }

    public function user_gantt() {
        $gantt_tasks = \App\GanttTask::where('responsible', Auth::user()->id)->get();
        $gantt_tasks->ids = array();
        foreach($gantt_tasks as $gantt_task) {
            if($gantt_task->parent != '0') {
                $gantt_tasks->ids[] = $gantt_task->parent; 
            }
            $gantt_tasks->ids[] = $gantt_task->id;
        }

        return view('/gantt', array('tasks' => $gantt_tasks->ids, 'active' => 'gestao_projetos', 'activeL' => 'planeamento'));
    }

    public function gantt() {
        $gantt_tasks = \App\GanttTask::all();
        $gantt_tasks->ids = array();
        $companyDays = \App\Company_Day::all();
        foreach($gantt_tasks as $gantt_task) {
            if($gantt_task->parent != '0') {
                $gantt_tasks->ids[] = $gantt_task->parent; 
            }
            $gantt_tasks->ids[] = $gantt_task->id;
        }

        return view('/gantt', array('tasks' => $gantt_tasks->ids, 'active' => 'gestao_projetos', 'activeL' => 'planeamento', 'companyDays' => $companyDays));
    }

}
