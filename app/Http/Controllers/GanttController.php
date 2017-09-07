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
        $connector->sort('number', 'desc');
        $connector->render_links(new GanttLink(), "id", "source,target,type");

        $tasks = GanttTask::where('progress', '<', 1)
                          ->where('gantt_tasks.type', 0)
                          ->join('tasks', 'tasks.ganttTask_id', '=', 'gantt_tasks.id')
                          ->join('users', 'users.id', '=', 'tasks.user_id')
                          ->select('gantt_tasks.*', 'tasks.name as t_name', 'users.sigla as u_sigla');

        $taskTimerTasks = \App\TaskTimer::join('gantt_tasks', 'task_timer.ganttTask_id', '=', 'gantt_tasks.id') 
                                       ->join('users', 'users.id', '=', 'task_timer.user_id')
                                       ->select('gantt_tasks.*', 'task_timer.task_name', 'users.sigla as u_sigla');

        $executedTasks = \App\Executed_Task::join('gantt_tasks', 'executed_tasks.ganttTask_id', '=', 'gantt_tasks.id') 
                                           ->join('users', 'users.id', '=', 'executed_tasks.user_id')
                                           ->select('gantt_tasks.*', 'executed_tasks.name', 'users.sigla as u_sigla');

        $connector->render_table(GanttTask::where('progress', '<', 1)
                                          ->where('type', '!=', 0)
                                          ->where('type', '!=', 3)
                                          ->select('gantt_tasks.*', 'gantt_tasks.text as t_name', 'gantt_tasks.responsible as u_sigla')
                                          ->union($tasks)
                                          ->union($taskTimerTasks)
                                          ->union($executedTasks)
                                            ,"id","start_date,duration, t_name,progress,parent,type,number,milestone, u_sigla", "end_date");
    }

    public function project_gantt($projectId) {
    	$project = \App\Project::find($projectId);
    	$task = \App\GanttTask::find($project->project_Task_ID);
        
    	return view('/gantt_project', array('task' => $task, 'project' => $project, 'active' => 'gestao_projetos'));
    }

    /*public function user_gantt() {
        $gantt_tasks = \App\GanttTask::where('responsible', Auth::user()->id)->get();
        $gantt_tasks->ids = array();
        foreach($gantt_tasks as $gantt_task) {
            if($gantt_task->parent != '0') {
                $gantt_tasks->ids[] = $gantt_task->parent; 
            }
            $gantt_tasks->ids[] = $gantt_task->id;
        }

        
        $companyDays = \App\Company_Day::all();

        return view('/gantt', array('tasks' => $gantt_tasks->ids, 'active' => 'gestao_projetos', 'activeL' => 'planeamento', ));
    }*/

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

        /*$expertise = \App\Project_Expertise::where('project_id', $id)
                                           ->where('parent', 0)
                                           ->join('expertise', 'expertise.id', '=', 'project_expertise.expertise_id')
                                           ->select('expertise_id as id', 'expertise.name as name', 'project_expertise.id as proj_e_id')
                                           ->get();
        $subExpertise = \App\Project_Expertise::where('project_id', $id)
                                           ->where('parent', '!=', 0)
                                           ->join('expertise', 'expertise.id', '=', 'project_expertise.expertise_id')
                                           ->select('expertise_id as id', 'expertise.name as name', 'parent as parent', 'project_expertise.id as proj_e_id')
                                           ->get();

        $phases = \App\Project_Phase::where('project_id', $id)
                                    ->join('phases', 'phases.id', '=', 'project_phase.phase_id')
                                    ->select('phase_id as id', 'phases.name as name')
                                    ->get();*/

        $eventTypes = \App\Project_Event_Type::all();

        return view('/gantt', array('tasks' => $gantt_tasks->ids, 'active' => 'gestao_projetos', 'activeL' => 'planeamento', 'companyDays' => $companyDays, 'eventTypes' => $eventTypes));
    }

}
