<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Image;
use DB;
use DateTime;
use DateInterval;
use Auth;
use stdClass;
use SplQueue;

class ProjectController extends Controller
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

    public function show_projects() {

        $memory = \App\User_Memory::where('user_id', Auth::user()->id)->first();

        if($memory != null) {
            if($memory->operations_filter != null) {
                $projects = $this->filterProjectsWithArgs(unserialize($memory->operations_filter));
            }
        }

        if(!isset($projects)) {
            $projects = \App\Project::orderBy('number', 'desc')->get();
            foreach($projects as $project) {
                $event = \App\Executed_Task::where('project_id', $project->id)
                                       ->where('type', 1)
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
        foreach($projects as $project) {
            $expertise = \App\Project_Expertise::where('project_id', $project->id)
                                                ->where('parent', 0)
                                                ->join('expertise', 'expertise.id', '=', 'expertise_id')
                                                ->select('expertise.sigla')
                                                ->get();

            $project->expertise = "";
            $i = 0;
            $len = count($expertise);
            foreach($expertise as $expert) {
                if($i == $len - 1) {
                    $project->expertise .= $expert->sigla;
                } else {
                    $project->expertise .= $expert->sigla . " | ";
                }
                $i++;
            }
        }
        $expertise = \App\Expertise::all();
        $phases = \App\Phase::all();
        /*$types = \App\Project_Type::all();
        $constructionTypes = \App\Construction_Type::all();
        $utilizationTypes = \App\Utilization_Type::all();*/
        $states = \App\State_Type::all();

        if($memory != null) {
            if($memory->operations_filter != null) {
                return view('show_projects', array('projects' => $projects, 'active' => 'gestao_projetos', 'activeL' => 'projetos', 'expertise' => $expertise, 'states' => $states, 'filter' => unserialize($memory->operations_filter), 'phases' => $phases));
            } else {
                return view('show_projects', array('projects' => $projects, 'active' => 'gestao_projetos', 'activeL' => 'projetos', 'expertise' => $expertise, 'states' => $states, 'phases' => $phases));
            }
        } else {
            return view('show_projects', array('projects' => $projects, 'active' => 'gestao_projetos', 'activeL' => 'projetos', 'expertise' => $expertise, 'states' => $states, 'phases' => $phases));
        }
    }

    public function create_project_form(){
    	$users = \App\User::all();
    	$clients = \App\Client::all();
    	$companies = \App\Company::all();
    	return view('/create_project', array('users' => $users, 'clients' => $clients, 'companies' => $companies, 'active' => 'gestao_projetos'));
    }

    public function create_project(Request $request) {
        $task = new \App\GanttTask();
        $task->text = Input::get('name');
        $task->type = 1;
        $task->parent = 242;
        $task->number = Input::get('code') . Input::get('code2');
        $task->save();

        $taskOperation = new \App\GanttTask();
        $taskOperation->text = Input::get('name');
        $taskOperation->type = 1;
        $taskOperation->parent = 243;
        $taskOperation->number = Input::get('code') . Input::get('code2');
        $taskOperation->save();

        $taskPlanned = new \App\GanttTask();
        $taskPlanned->text = Input::get('name');
        $taskPlanned->type = 1;
        $taskPlanned->parent = 502;
        $taskPlanned->number = Input::get('code') . Input::get('code2');
        $taskPlanned->save();

        $project = new \App\Project();
        $project->number = Input::get('code'). Input::get('code2');;
        $project->commercial_project_Task_ID = $task->id;
        $project->operational_project_Task_ID = $taskOperation->id;
        $project->plannedTask_id = $taskPlanned->id;
        $project->name = Input::get('name');
        //$project->title = Input::get('title');
        //Handle the user upload of avatar
        /*if($request->hasFile('picture')){
            $picture = $request->file('picture');
            $path = '/uploads/projects/';

            $filename = $project->name . time() . '.' . $picture->getClientOriginalExtension();
            Image::make($picture)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save( public_path($path . $filename));

            $project->picture = $filename;
        }*/
       /* $project->zip_code = Input::get('zip_code');
        $project->address = Input::get('address');
        if(Input::get('client') != 0)
            $project->client = Input::get('client');
        
        //$project->responsible = Input::get('responsible');

        $project->coordinator = Input::get('coordinator');
        $project->adjudicacao = Input::get('adjudicacao');
        $project->planner = Input::get('planner');
        $project->sub_contratacao = Input::get('sub_contratacao');*/

        $project->save();

        /*
        $responsibleMember = new \App\Project_Members();
        $responsibleMember->member = $project->responsible;
        $responsibleMember->project = $project->id;
        $responsibleMember->save();

        foreach (Input::get('members') as $member) {
            if($member != $project->responsible) { 
                $newMember = new \App\Project_Members();
                $newMember->member = $member;
                $newMember->project = $project->id;
                $newMember->save();
           }
        }
        */

        foreach(Input::get('phases') as $phase) {
            if($phase != 0) {
                $project_phase = new \App\Project_Phase();
                $project_phase->phase_id = $phase;
                $project_phase->project_id = $project->id;
                $project_phase->save();
            }
        }
        foreach(Input::get('expertise') as $expert) {
            if($expert != 0) {
                $project_expertise = new \App\Project_Expertise();
                $project_expertise->expertise_id = $expert;
                $project_expertise->project_id = $project->id;
                $project_expertise->save();
            }
        }

        return redirect('/projects');
    }

    public function create_client() {
    	$client = new \App\Client();
    	$client->name = Input::get('name');
    	$client->address = Input::get('address');
    	$client->city = Input::get('city');
    	$client->country = Input::get('country');
    	$client->contact = Input::get('contact');
    	$client->representant_name = Input::get('representant_name');
    	$client->representant_contact = Input::get('representant_contact');
    	$client->save();
    	$users = \App\User::all();
    	$clients = \App\Client::all();
    	return redirect('/create_project', array('users' => $users, 'clients' => $clients));
    }

    public function registerProjectSeen($project_id) {
        $memory = \App\User_Memory::where('user_id', Auth::user()->id)->first();

        if($memory != null) {
            if($memory->lastProjectsSeen != null) {
                $queue = unserialize($memory->lastProjectsSeen);
                if(count($queue) >= 10) {

                    $foundIt = false;
                    $keyTemp = false;

                    foreach($queue as $key => $item){
                      if($item != $project_id)
                        continue;

                      $foundIt = true;
                      $keyTemp = $key;
                      break;
                    }

                    if($foundIt) {
                        $queue->offsetUnset($keyTemp);
                        $queue->enqueue($project_id);
                        $memory->lastProjectsSeen = serialize($queue);
                    } else {
                        $queue->dequeue();
                        $queue->enqueue($project_id);
                        $memory->lastProjectsSeen = serialize($queue);
                    }
                } else {
                    $foundIt = false;
                    $keyTemp = false;

                    foreach($queue as $key => $item){
                      if($item != $project_id)
                        continue;

                      $foundIt = true;
                      $keyTemp = $key;
                      break;
                    }

                    if($foundIt) {
                        $queue->offsetUnset($keyTemp);
                        $queue->enqueue($project_id);
                        $memory->lastProjectsSeen = serialize($queue);
                    } else {
                        $queue->enqueue($project_id);
                        $memory->lastProjectsSeen = serialize($queue);
                    }
                }
            } else {
                $queue = new SplQueue();
                $queue->enqueue($project_id);
                $memory->lastProjectsSeen = serialize($queue);
            }

            $memory->save();
        } else {
            $memory = new \App\User_Memory();
            $memory->user_id = Auth::user()->id;
            $queue = new SplQueue();
            $queue->enqueue($project_id);
            $memory->lastProjectsSeen = serialize($queue);
            $memory->save();
        }
    }

    public function show_project($id) {

        $this->registerProjectSeen($id);

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

        return view('/project', array('project' => $project, 'active' => 'gestao_projetos', 'activeL' => 'informação', 'activeLL' => 'informações', 'projectTypes' => $projectTypes, 'constructionTypes' => $constructionTypes, 'utilizationTypes' => $utilizationTypes));
    }

     public function show_project_properties($id) {
        $project = \App\Project::find($id);
        $userResponsible = \App\User::find($project->responsible);
        $members = \App\Project_Members::where('project', $id)->get();
        $userMembers;
        foreach($members as $member) {
            $userMembers[$member->id] = \App\User::find($member->member);
        }
        return view('/project_properties', array('project' => $project, 'userResponsible' => $userResponsible, 'userMembers' => $userMembers, 'active' => 'gestao_projetos'));
    }

    public function getExpertiseFromProject(Request $r) {
        $project_expertise = \App\Project_Expertise::where('project_id', $r['project_id'])->get();
        
        
        foreach($project_expertise as $project_expert) {
            $expert = \App\Expertise::find($project_expert->expertise_id);
            $project_expert->name = $expert->name;
            $project_expert->parent = $expert->parent;
        }

        return array($project_expertise);
    }

    public function getExpertisePhasesFromProject(Request $r) {
        return $projectExpertisePhase = \App\Project_Expertise_Phase::where('project_expertise_id', $r['project_expertise_id'])
                                                                    ->join('phases', 'phases.id', '=', 'project_expertise_phases.phase_id')
                                                                    ->select('phases.name as name', 'phases.id as id')
                                                                    ->get();
    }

    public function saveTaskTime(Request $r) {
        DB::transaction(function () use($r) {
            $project_id = $r['project'];
            $expertise = $r['expertise'];
            $phase = $r['phase'];
            $subexpertise = $r['subexpertise'];
            $companyDays = \App\Company_Day::all();
            if($subexpertise == 0) {
                $subexpertise = null;
            }
            $taskName = $r['task'];
            $min = $r['minutes'];
            $hours = $r['hours'];
            $date = $r['date'];
            $conclusion = $r['conclusion'];
            $assignedTo = $r['assignedTo'];

            $project = \App\Project::find($project_id);

            //Executado
            $taskExecuted = new \App\GanttTask();
            $taskExecuted->number = 0;
            $taskExecuted->type = 3;
            $taskExecuted->text = $taskName;
            $taskExecuted->start_date = $r['date'];

            $totalTime = $r['hours'] + ($r['minutes'] / 60);
            
            $taskExecuted->duration = ceil($totalTime);

            if($r['expertise'] != 0) {
                $expertiseTask = \App\GanttTask::where('expertise_id', $r['expertise'])
                                            ->where('parent', $project->operational_project_Task_ID)
                                            ->first();
                if(!count($expertiseTask)) {
                    $expertise = \App\Expertise::find($r['expertise']);
                    $expertiseTask = new \App\GanttTask();
                    $expertiseTask->text = $expertise->name;
                    $expertiseTask->number = $expertise->code;
                    $expertiseTask->parent = $project->operational_project_Task_ID;
                    $expertiseTask->type = 2;
                    $expertiseTask->expertise_id = $r['expertise'];
                    $expertiseTask->save();
                }
                if($r['phase'] != 0) {
                    $phaseTask = \App\GanttTask::where('phase_id', $r['phase'])->where('parent', $expertiseTask->id)->first();
                    if(!count($phaseTask)) {
                        $phaseTask = new \App\GanttTask();
                        $phase = \App\Phase::find($r['phase']);
                        $phaseTask->text = $phase->name;
                        $phaseTask->number = $phase->code;
                        $phaseTask->parent = $expertiseTask->id;
                        $phaseTask->type = 2;
                        $phaseTask->phase_id = $r['phase'];
                        $phaseTask->save();
                    }
                    $taskExecuted->parent = $phaseTask->id;
                } else {
                    $taskExecuted->parent = $expertiseTask->id;
                }

            } else {
                if($r['phase'] == 0)
                    $taskExecuted->parent = $project->operational_project_Task_ID;
                else {
                    $phaseTask = new \App\GanttTask();
                    $phase = \App\Phase::find($r['phase']);
                    $phaseTask->text = $phase->name;
                    $phaseTask->number = $phase->code;
                    $phaseTask->parent = $project->operational_project_Task_ID;
                    $phaseTask->type = 2;
                    $phaseTask->phase_id = $r['phase'];
                    $phaseTask->save();
                    $taskExecuted->parent = $phaseTask->id;
                }
            }

            $taskExecuted->responsible = Auth::user()->sigla;
            $taskExecuted->save();

            if($conclusion < 100) {
                
                $remainingPercentage = 100 - $conclusion;
                $minutesToHours = $min/60;
                $totalTime = $hours + $minutesToHours;
                $remainingTime = ($totalTime * $remainingPercentage) / $conclusion;
                $remainingDays = $remainingTime / 8;

                $dateStart = new DateTime($date);
                $date1 = new DateTime($date);
                $date1->add(new DateInterval('P' . ceil($remainingDays) . 'D'));
                
                for($i = $dateStart; $i <= $date1; $i->modify('+1 day')) {
                    if(date('w', $i->getTimestamp()) == 6 || date('w', $i->getTimestamp()) == 0) {
                        $date1 = $date1->modify('+1 day');
                        continue;
                    }
                    foreach($companyDays as $companyDay) {
                        if($companyDay->start_date == $i->format('Y-m-d')) {
                            $date1 = $date1->modify('+1 day');
                            break;
                        }
                    }
                }
                $end_date = $date1->format('Y-m-d');

                //Planeado
                $task = new \App\GanttTask();
                $task->number = 0;
                $task->text = $taskName;
                $task->start_date = $date;
                $date1 = new DateTime($date);
                $date2 = new DateTime($end_date);
                $interval = $date1->diff($date2);
                $task->duration = ($interval->d + 1) * 24;

               if($r['expertise'] != 0) {
                    $expertiseTask = \App\GanttTask::where('expertise_id', $r['expertise'])
                                                ->where('parent', $project->commercial_project_Task_ID)
                                                ->first();
                    if(!count($expertiseTask)) {
                        $expertise = \App\Expertise::find($r['expertise']);
                        $expertiseTask = new \App\GanttTask();
                        $expertiseTask->text = $expertise->name;
                        $expertiseTask->number = $expertise->code;
                        $expertiseTask->parent = $project->commercial_project_Task_ID;
                        $expertiseTask->type = 2;
                        $expertiseTask->expertise_id = $r['expertise'];
                        $expertiseTask->save();
                    }
                    if($r['phase'] != 0) {
                        $phaseTask = \App\GanttTask::where('phase_id', $r['phase'])->where('parent', $expertiseTask->id)->first();
                        if(!count($phaseTask)) {
                            $phaseTask = new \App\GanttTask();
                            $phase = \App\Phase::find($r['phase']);
                            $phaseTask->text = $phase->name;
                            $phaseTask->number = $phase->code;
                            $phaseTask->parent = $expertiseTask->id;
                            $phaseTask->type = 2;
                            $phaseTask->phase_id = $r['phase'];
                            $phaseTask->save();
                        }
                        $task->parent = $phaseTask->id;
                    } else {
                        $task->parent = $expertiseTask->id;
                    }

                } else {
                    if($r['phase'] == 0)
                        $task->parent = $project->commercial_project_Task_ID;
                    else {
                        $phaseTask = new \App\GanttTask();
                        $phase = \App\Phase::find($r['phase']);
                        $phaseTask->text = $phase->name;
                        $phaseTask->number = $phase->code;
                        $phaseTask->parent = $project->commercial_project_Task_ID;
                        $phaseTask->type = 2;
                        $phaseTask->phase_id = $r['phase'];
                        $phaseTask->save();
                        $task->parent = $phaseTask->id;
                    }
                }

                $task->responsible = Auth::user()->sigla;
                $task->progress = $r['conclusion'] / 100;
                $task->save();

                $plannedTask = new \App\Task();
                $plannedTask->ganttTask_id = $task->id;
                $plannedTask->user_id = $assignedTo;
                $plannedTask->project_id = $project_id;
                $plannedTask->phase_id = $r['phase'] != 0 ? $r['phase'] : null;
                $plannedTask->expertise_id = $r['expertise'] != 0 ? $r['expertise'] : null;
                $plannedTask->subExpertise_id = $r['subexpertise'] != 0 ? $r['subexpertise'] : null;
                $plannedTask->type = 6;
                $plannedTask->name = $taskName;
                $plannedTask->start_date = $date;
                $plannedTask->end_date = $end_date;
                $plannedTask->save();

                $taskTimer = new \App\TaskTimer();
                $taskTimer->user_id = Auth::user()->id;
                $taskTimer->assignedTo = $assignedTo;
                $taskTimer->project_id = $project_id;
                $taskTimer->expertise_id = $r['expertise'];
                $taskTimer->subexpertise_id = $r['subexpertise'];
                $taskTimer->phase_id = $r['phase'];
                $taskTimer->task_name = $taskName;
                $taskTimer->minutes = $min;
                $taskTimer->hours = $hours;
                $taskTimer->date = $date;
                $taskTimer->programmedTask_id = $plannedTask->id;
                $taskTimer->ganttTask_id = $taskExecuted->id;
                $taskTimer->done = $conclusion;
                $userToApprove = $this->getNextUserFromWorkflow(Auth::user()->id);
                if($userToApprove != null)
                    $taskTimer->userToApprove = $userToApprove;
                else
                    $taskTimer->approved = 1;
                $taskTimer->save();
            } else {
                $taskTimer = new \App\TaskTimer();
                $taskTimer->user_id = Auth::user()->id;
                $taskTimer->assignedTo = $assignedTo;
                $taskTimer->project_id = $project_id;
                $taskTimer->expertise_id = $r['expertise'];
                $taskTimer->subexpertise_id = $r['subexpertise'];
                $taskTimer->phase_id = $r['phase'];
                $taskTimer->task_name = $taskName;
                $taskTimer->minutes = $min;
                $taskTimer->ganttTask_id = $taskExecuted->id;
                $taskTimer->hours = $hours;
                $taskTimer->date = $date;
                $taskTimer->done = $conclusion;
                $userToApprove = $this->getNextUserFromWorkflow(Auth::user()->id);
                if($userToApprove != null)
                    $taskTimer->userToApprove = $userToApprove;
                else
                    $taskTimer->approved = 1;
                $taskTimer->save();
            }
        });

        return redirect()->back();
    }

    public function saveProgrammedTaskTime(Request $r) {
        DB::transaction(function () use($r) {
            $assignedTo = $r['assignedTo'];
            $project_id = $r['project'];
            $project = \App\Project::find($project_id);

            $taskTemp = \App\Task::find($r['task']);

            $executedTask = \App\TaskTimer::where('programmedTask_id', $r['task'])->first();
            if($executedTask != null) {
                $executedTaskGantt = \App\GanttTask::where('id', $executedTask->ganttTask_id)->first();
                $end_date = new DateTime($r['date']);
                $start_date = new DateTime($executedTask->start_date);
                $diff = $start_date->diff($end_date);
                $executedTaskGantt->duration = ($diff->d + 1) * 24;
                $executedTaskGantt->duration += $r['hours'] + ($r['minutes'] / 60);
                $executedTaskGantt->save();
            } else {
                //Executado
                $task = new \App\GanttTask();
                $task->number = 0;
                $task->type = 3;
                $task->text = $taskTemp->name;
                $task->start_date = $r['date'];
                $totalTime = $r['hours'] + ($r['minutes'] / 60);
            
                $task->duration = ceil($totalTime);

                if($taskTemp->expertise_id != 0) {
                    $expertiseTask = \App\GanttTask::where('expertise_id', $taskTemp->expertise_id)
                                                ->where('parent', $project->operational_project_Task_ID)
                                                ->first();
                    if(!count($expertiseTask)) {
                        $expertise = \App\Expertise::find($taskTemp->expertise_id);
                        $expertiseTask = new \App\GanttTask();
                        $expertiseTask->text = $expertise->name;
                        $expertiseTask->number = $expertise->code;
                        $expertiseTask->parent = $project->operational_project_Task_ID;
                        $expertiseTask->type = 2;
                        $expertiseTask->expertise_id = $taskTemp->expertise_id;
                        $expertiseTask->save();
                    }
                    if($taskTemp->phase_id != 0) {
                        $phaseTask = \App\GanttTask::where('phase_id', $taskTemp->phase_id)->where('parent', $expertiseTask->id)->first();
                        if(!count($phaseTask)) {
                            $phaseTask = new \App\GanttTask();
                            $phase = \App\Phase::find($taskTemp->phase_id);
                            $phaseTask->text = $phase->name;
                            $phaseTask->number = $phase->code;
                            $phaseTask->parent = $expertiseTask->id;
                            $phaseTask->type = 2;
                            $phaseTask->phase_id = $taskTemp->phase_id;
                            $phaseTask->save();
                        }
                        $task->parent = $phaseTask->id;
                    } else {
                        $task->parent = $expertiseTask->id;
                    }

                } else {
                    if($taskTemp->phase_id == 0)
                        $task->parent = $project->operational_project_Task_ID;
                    else {
                        $phaseTask = new \App\GanttTask();
                        $phase = \App\Phase::find($taskTemp->phase_id);
                        $phaseTask->text = $phase->name;
                        $phaseTask->number = $phase->code;
                        $phaseTask->parent = $project->operational_project_Task_ID;
                        $phaseTask->type = 2;
                        $phaseTask->phase_id = $taskTemp->phase_id;
                        $phaseTask->save();
                        $task->parent = $phaseTask->id;
                    }
                }

                $task->responsible = Auth::user()->sigla;
                $task->save();
            }

            $taskTimer = new \App\TaskTimer();
            $taskTimer->user_id = Auth::user()->id;
            $taskTimer->assignedTo = $assignedTo;
            $taskTimer->project_id = $taskTemp->project_id;
            $taskTimer->expertise_id = $taskTemp->expertise_id;
            $taskTimer->phase_id = $taskTemp->phase_id;
            $taskTimer->subexpertise_id = $taskTemp->subExpertise_id;
            $taskTimer->task_name = $taskTemp->name;
            $taskTimer->minutes = $r['minutes'];
            $taskTimer->hours = $r['hours'];
            $taskTimer->date = $r['date'];
            $taskTimer->programmedTask_id = $taskTemp->id;
            if($executedTask != null) {
                $taskTimer->ganttTask_id = \App\GanttTask::where('id', $executedTask->ganttTask_id)->first()->id;
            } else
                $taskTimer->ganttTask_id = $task->id;

            $taskTimer->done = $r['conclusion'];
            $userToApprove = $this->getNextUserFromWorkflow(Auth::user()->id);
                if($userToApprove != null)
                    $taskTimer->userToApprove = $userToApprove;
                else
                    $taskTimer->approved = 1;

            $taskTimer->save();

            $ganttTask = \App\GanttTask::find($taskTemp->ganttTask_id);
            $ganttTask->progress = $r['conclusion'] / 100;
            $ganttTask->save(); 
        });
        
        return redirect()->back();
    }

    public function editProject(Request $r) {
        $project = \App\Project::find($r['projectId']);
        if($r['name'] != "")
            $project->name = $r['name'];
        if($r['title'] != "")
            $project->title = $r['title'];
        if($r['address'] != "")
            $project->address = $r['address'];
        if($r['zip_code'] != "") 
            $project->zip_code = $r['zip_code'];
        if($r['local'] != "") 
            $project->local = $r['local'];
        if($r['constructionArea'] != "")
            $project->constructionArea = $r['constructionArea'];
        if($r['totalArea'] != "")
            $project->totalArea = $r['totalArea'];
        if($r['value'] != "")
            $project->value = $r['value'];
        if($r['type'] != 0)
            $project->type = $r['type'];

        $project->save();

        $projectDetails = \App\Project_Details::where('project_id', $r['projectId'])->first();

        if($projectDetails == null) {
            $projectDetails = new \App\Project_Details();
            $projectDetails->project_id = $r['projectId'];
        }

        if($r['constructionType'] != 0)
            $projectDetails->constructionType = $r['constructionType'];
        if($r['utilizationType'] != 0)
            $projectDetails->utilizationType = $r['utilizationType'];
        if($r['totalNumberFloors'] != "")
            $projectDetails->totalNumberFloors = $r['totalNumberFloors'];
        if($r['numberBuriedFloors'] != 0)
            $projectDetails->numberBuriedFloors = $r['numberBuriedFloors'];

        $projectDetails->save();

        return redirect()->back();
    }

    public function removeProject(Request $r) {
        \App\Project::find($r['id'])->delete();
    }

    public function getPlanning($id) {
        $this->registerProjectSeen($id);
        $project = \App\Project::find($id);
        $phases = \App\Project_Phase::where('project_id', $id)->get();
        $expertise = \App\Project_Expertise::where('project_id', $id)->get();
        $planningTypes = \App\Planning_Type::all();
        $project_planning = \App\Project_Planning::where('project_id', $id)
                                                 ->join('expertise', 'expertise.id', '=', 'project_planning.expertise')
                                                 ->join('phases', 'phases.id', '=', 'project_planning.phase')
                                                 ->join('planning_types', 'planning_types.id', '=', 'project_planning.type')
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

        return view('projectInformationPlanning', array('project' => $project, 'phases' => $phases, 'expertise' => $expertise, 'activeL' => 'informação', 'activeLL' => 'planeamento', 'planningTypes' => $planningTypes, 'project_planning' => $project_planning));
    }

    public function addPlanning(Request $r, $id) {

        $project = \App\Project::find($id);


        $task = new \App\GanttTask();
        $task->number = 0;
        $task->text = \App\Planning_Type::find($r['type'])->name;
        $task->start_date = $r['startDate'];
        $task->milestone = 1;
        $task->duration = 24;
        $task->type = 7;

       if($r['expertise'] != 0) {
            $expertiseTask = \App\GanttTask::where('expertise_id', $r['expertise'])
                                        ->where('parent', $project->plannedTask_id)
                                        ->first();
            if(!count($expertiseTask)) {
                $expertise = \App\Expertise::find($r['expertise']);
                $expertiseTask = new \App\GanttTask();
                $expertiseTask->text = $expertise->name;
                $expertiseTask->number = $expertise->code;
                $expertiseTask->parent = $project->plannedTask_id;
                $expertiseTask->type = 2;
                $expertiseTask->expertise_id = $r['expertise'];
                $expertiseTask->save();
            }
            if($r['phase'] != 0) {
                $phaseTask = \App\GanttTask::where('phase_id', $r['phase'])->where('parent', $expertiseTask->id)->first();
                if(!count($phaseTask)) {
                    $phaseTask = new \App\GanttTask();
                    $phase = \App\Phase::find($r['phase']);
                    $phaseTask->text = $phase->name;
                    $phaseTask->number = $phase->code;
                    $phaseTask->parent = $expertiseTask->id;
                    $phaseTask->type = 2;
                    $phaseTask->phase_id = $r['phase'];
                    $phaseTask->save();
                }
                $task->parent = $phaseTask->id;
            } else {
                $task->parent = $expertiseTask->id;
            }

        } else {
            if($r['phase'] == 0)
                $task->parent = $project->plannedTask_id;
            else {
                $phaseTask = new \App\GanttTask();
                $phase = \App\Phase::find($r['phase']);
                $phaseTask->text = $phase->name;
                $phaseTask->number = $phase->code;
                $phaseTask->parent = $project->plannedTask_id;
                $phaseTask->type = 2;
                $phaseTask->phase_id = $r['phase'];
                $phaseTask->save();
                $task->parent = $phaseTask->id;
            }
        }

        $task->save();

        $planning = new \App\Project_Planning();
        $planning->project_id = $id;
        $planning->type = $r['type'];
        $planning->phase = $r['phase'];
        $planning->expertise = $r['expertise'];
        $planning->startDate = $r['startDate'];
        $planning->milestone = 1;
        $planning->ganttTask_id = $task->id;
        $planning->save();

        return redirect()->back();
    }

    public function deletePlanning($id) {
        $planning = \App\Project_Planning::find($id);
        \App\GanttTask::find($planning->task_id)->delete();
        $planning->delete();
    }

    public function getGantt($id) {
        $this->registerProjectSeen($id);
        $project = \App\Project::find($id);
        $gantt_tasks = \App\GanttTask::all();
        $gantt_tasks->ids = array();
        foreach($gantt_tasks as $gantt_task) {
            if($gantt_task->parent != '0') {
                $gantt_tasks->ids[] = $gantt_task->parent; 
            }
            $gantt_tasks->ids[] = $gantt_task->id;
        }
        $expertise = \App\Project_Expertise::where('project_id', $id)
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
                                    ->get();

        $eventTypes = \App\Project_Event_Type::all();
        $companyDays = \App\Company_Day::all();
        return view('gantt_project', array('project' => $project, 'activeL' => 'gestão', 'activeLL' => 'gantt', 'tasks' => $gantt_tasks->ids, 'companyDays' => $companyDays, 'eventTypes' => $eventTypes, 'phases' => $phases, 'expertise' => $expertise, 'subExpertise' => $subExpertise));
    }

    public function getTeam($id) {
        $this->registerProjectSeen($id);
        $project = \App\Project::find($id);
        $functions = \App\Project_User_Function::all();
        $expertise = \App\Project_Expertise::where('project_id', $id)
                                            ->where('parent', 0)
                                            ->join('expertise', 'expertise_id', '=', 'expertise.id')
                                            ->get();

        $subExpertise = \App\Project_Expertise::where('project_id', $id)
                                              ->where('parent', '!=', 0)
                                              ->join('expertise', 'expertise_id', '=', 'expertise.id')
                                              ->get();

        $team = \App\Project_Team::where('project_id', $id)
                                 ->join('expertise', 'expertise_id', '=', 'expertise.id')
                                 ->join('users', 'user_id', '=', 'users.id')
                                 ->join('departments', 'departments.id', '=', 'users.function')
                                 ->join('project_user_function', 'project_user_function.id', '=', 'function_id')
                                 ->select('users.name as u_name', 'expertise.name as e_name', 'expertise.id as e_id','users.email as u_email', 'project_team.id as id', 'users.sigla as u_sigla', 'subExpertise_id as subExpertise_id', 'departments.name as u_department', 'project_user_function.name as u_function', 'project_user_function.id as u_function_id')
                                 ->get();

        foreach($team as $member) {
            $subExpert = \App\Expertise::find($member->subExpertise_id);
            if($subExpert != null)
                $member->subExpert_name = $subExpert->name;
            else
                $member->subExpert_name = '-';
        }

        return view('projectTeam', array('team' => $team, 'expertise' => $expertise, 'project' => $project, 'activeLL' => 'equipa', 'activeL' => 'informação', 'subExpertise' => $subExpertise, 'functions' => $functions));
    }

    public function getOutsideTeam($id) {
        $this->registerProjectSeen($id);
        $project = \App\Project::find($id);
        $functions = \App\Project_General_User_Function::all();
        $expertise = \App\General_Expertise::all();

        $team = \App\Project_Outside_Team::where('project_id', $id)
                                 ->join('general_expertise', 'expertise_id', '=', 'general_expertise.id')
                                 ->leftJoin('contacts', 'coordinator_id', '=', 'contacts.id')
                                 ->leftJoin('company_contacts', 'company_id', '=', 'company_contacts.id')
                                 ->join('project_general_user_function', 'project_general_user_function.id', '=', 'function_id')
                                 ->select('contacts.firstName as u_firstName', 'contacts.lastName as u_lastName', 'general_expertise.name as e_name', 'general_expertise.id as e_id','contacts.email as u_email', 'company_contacts.name as c_name', 'company_contacts.id as c_id','contacts.phoneNumber as u_phone', 'project_general_user_function.name as u_function', 'project_general_user_function.id as u_function_id','project_outside_team.id as id')
                                 ->get();

        $contacts = \App\Contact::all();

        $companyContacts = \App\Company_Contact::all();

        return view('projectOutsideTeam', array('team' => $team, 'expertise' => $expertise, 'project' => $project, 'activeLL' => 'equipaFora', 'activeL' => 'informação', 'contacts' => $contacts, 'companyContacts' => $companyContacts, 'functions' => $functions));
    }

    public function addMember(Request $r, $id) {
        $member = new \App\Project_Team();
        $member->project_id = $id;
        $member->user_id = $r['user'];
        if($r['support'] != 0)
            $member->support_id = $r['support'];
        $member->expertise_id = $r['expertise'];
        if($r['subExpertise'] != 0)
            $member->subExpertise_id = $r['subExpertise'];
        $member->function_id = $r['function'];
        $member->save();

        return redirect()->back();
    }

    public function addOutsideMember(Request $r, $id) {
        $member = new \App\Project_Outside_Team();
        $member->project_id = $id;
        $member->coordinator_id = $r['coordinator'] != 0 ? $r['coordinator'] : null;
        $member->company_id = $r['company'] != 0 ? $r['company'] : null;
        $member->expertise_id = $r['expertise'];
        $member->function_id = $r['function'];
        $member->save();

        return redirect()->back();
    }

    public function deleteTeamMember($id) {
        \App\Project_Team::find($id)->delete();
    }

    public function deleteOutsideTeamMember($id) {
        \App\Project_Outside_Team::find($id)->delete();
    }

    public function getExpertise($id) {
        $this->registerProjectSeen($id);
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

        $project = \App\Project::find($id);
        $phases = \App\Phase::all();
        $expertise = \App\Expertise::where('parent', '=', 0)->get();
        $subExpertise = \App\Expertise::where('parent', '!=', 0)->get();
        $projectPhases = \App\Project_Phase::where('project_id', $id)
                                           ->join('phases', 'project_phase.phase_id', '=', 'phases.id')
                                           ->select('phases.id as p_id', 'phases.name as p_name', 'phases.sigla as p_sigla', 'project_phase.id as proj_p_id')
                                           ->get();

        return view('projectExpertise', array('project' => $project, 'projectExpertise' => $projectExpertise, 'expertise' => $expertise, 'subExpertise' => $subExpertise, 'activeL' => 'informação', 'activeLL' => 'especialidades', 'projectPhases' => $projectPhases, 'phases' => $phases));
    }

    public function addExpertise(Request $r, $id) {
        $expertise = new \App\Project_Expertise();
        $expertise->expertise_id = $r['expertise'];
        $expertise->project_id = $id;
        $expertise->save();

        return redirect()->back();
    }

    public function deleteExpertise($id) {
        \App\Project_Expertise::find($id)->delete();
    }

    public function getPhases($id) {
        $this->registerProjectSeen($id);
        $projectPhases = \App\Project_Phase::where('project_id', $id)
                                           ->join('phases', 'project_phase.phase_id', '=', 'phases.id')
                                           ->select('phases.id as p_id', 'phases.name as p_name', 'phases.sigla as p_sigla', 'project_phase.id as proj_p_id')
                                           ->get();
        $phases = \App\Phase::all();
        $project = \App\Project::find($id);

        return view('projectPhases', array('projectPhase' => $projectPhases, 'phases' => $phases, 'project' => $project, 'activeL' => 'informação', 'activeLL' => 'fases'));
    }

    public function addPhase(Request $r, $id) {
        $phase = new \App\Project_Phase();
        $phase->phase_id = $r['phase'];
        $phase->project_id = $id;
        $phase->save();

        return redirect()->back();
    }

    public function deletePhase($id) {
        \App\Project_Phase::find($id)->delete();
    }

    public function getProjectDetails($id) {
        return \App\Project::where('project.id', $id)
                           ->leftJoin('project_details', 'project_details.project_id', '=', 'project.id')
                           ->first();
    }

    public function filterProjects(Request $r) {
        $obj = new stdClass();
        $obj->state = $r['state'];
        $obj->year = $r['year'];
        $obj->expertise = $r['expertise'];

        $memory = \App\User_Memory::where('user_id', Auth::user()->id)->first();

        if($memory != null) {
            $memory->operations_filter = serialize($obj);
            $memory->save();
        } else {
            $memory = new \App\User_Memory();
            $memory->user_id = Auth::user()->id;
            $memory->operations_filter = serialize($obj);
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

           $expertise = \App\Project_Expertise::where('project_id', $project->id)
                                                ->where('parent', 0)
                                                ->join('expertise', 'expertise.id', '=', 'expertise_id')
                                                ->select('expertise.sigla')
                                                ->get();

            $project->expertise = "";
            $i = 0;
            $len = count($expertise);
            foreach($expertise as $expert) {
                if($i == $len - 1) {
                    $project->expertise .= $expert->sigla;
                } else {
                    $project->expertise .= $expert->sigla . " | ";
                }
                $i++;
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
                                       ->where('type', 1)
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

    public function getProjectTasks($id) {
        $this->registerProjectSeen($id);
        $tasks = \App\Task::where('project_id', $id)
                          ->join('users', 'users.id', '=', 'tasks.user_id')
                          ->leftJoin('expertise', 'expertise_id', '=', 'expertise.id')
                          ->leftJoin('phases', 'phase_id', '=', 'phases.id')
                          ->join('project_event_types', 'tasks.type', 'project_event_types.id')
                          ->select('expertise.sigla as e_sigla', 'phases.sigla as p_sigla', 'tasks.name as t_name', 'tasks.id as t_id', 'start_date as start_date', 'end_date as end_date', 'users.sigla as u_sigla', 'subExpertise_id as subExpertise_id', 'project_event_types.sigla as ev_sigla', 'tasks.notes as notes')
                          ->get();

        foreach ($tasks as $task) {
            $subExpertise = \App\Expertise::find($task->subExpertise_id);
            if($subExpertise != null)
                $task->subExpertiseName = $subExpertise->name;
            else
                $task->subExpertiseName = '-';

            $task_timer = \App\TaskTimer::where('programmedTask_id', $task->t_id)
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

        $project = \App\Project::find($id);

        $expertise = \App\Project_Expertise::where('project_id', $id)
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
                                    ->get();

        $eventTypes = \App\Project_Event_Type::all();

        return view('projectTasks', array('tasks' => $tasks, 'activeL' => 'gestão', 'activeLL' => 'planeamento', 'project' => $project, 'phases' => $phases, 'expertise' => $expertise, 'subExpertise' => $subExpertise, 'eventTypes' => $eventTypes));
    }

    public function getProjectExecutedTasks($id) {
        $this->registerProjectSeen($id);
        $states = \App\State_Type::all();
        $tasks = \App\Executed_Task::where('project_id', $id)
                          ->join('users', 'users.id', '=', 'executed_tasks.user_id')
                          ->leftJoin('expertise', 'expertise_id', '=', 'expertise.id')
                          ->leftJoin('phases', 'phase_id', '=', 'phases.id')
                          ->leftJoin('state_types', 'executed_tasks.subType', 'state_types.id')
                          ->join('project_event_types', 'executed_tasks.type', 'project_event_types.id')
                          ->select('expertise.sigla as e_sigla', 'phases.sigla as p_sigla', 'executed_tasks.name as t_name', 'executed_tasks.id as t_id', 'start_date as start_date', 'users.sigla as u_sigla', 'subExpertise_id as subExpertise_id', 'project_event_types.sigla as ev_type', 'notes as notes', DB::raw("'-' AS state"), 'executed_tasks.hours as hours', 'executed_tasks.minutes as minutes', DB::raw('"-" as programmedTask_id'));

        /*$states = \App\Executed_Task::where('project_id', $id)
                          ->where('executed_tasks.type', 1)
                          ->join('users', 'users.id', '=', 'executed_tasks.user_id')
                          ->leftJoin('expertise', 'expertise_id', '=', 'expertise.id')
                          ->leftJoin('phases', 'phase_id', '=', 'phases.id')
                          ->leftJoin('state_types', 'executed_tasks.name', 'state_types.id')
                          ->join('project_event_types', 'executed_tasks.type', 'project_event_types.id')
                          ->select('expertise.sigla as e_sigla', 'phases.sigla as p_sigla', 'state_types.name as t_name', 'executed_tasks.id as t_id', 'start_date as start_date', 'users.sigla as u_sigla', 'subExpertise_id as subExpertise_id', 'project_event_types.name as ev_name', 'notes as notes', DB::raw("'-' AS state"), 'executed_tasks.hours as hours', 'executed_tasks.minutes as minutes');*/


        $executedTasks = \App\TaskTimer::where('task_timer.project_id', $id)
                                       ->join('users', 'users.id', '=', 'task_timer.user_id')
                                       ->leftJoin('expertise', 'task_timer.expertise_id', '=', 'expertise.id')
                                       ->leftJoin('phases', 'task_timer.phase_id', '=', 'phases.id')    
                                       ->select('expertise.sigla as e_sigla', 'phases.sigla as p_sigla', 'task_timer.task_name as t_name', 'task_timer.id as t_id', 'date as start_date', 'users.sigla as u_sigla', 'task_timer.subExpertise_id as subExpertise_id', DB::raw("'TF' AS ev_sigla"), 'task_timer.notes as notes', 'task_timer.done as state', 'task_timer.hours as hours', 'task_timer.minutes as minutes', 'task_timer.programmedTask_id as programmedTask_id')
                                       ->union($tasks)
                                       ->orderBy('start_date', 'desc')
                                       ->orderBy('t_id', 'desc')
                                       ->get();

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
                if($task->programmedTask_id != null) {
                    $task_temp = \App\TaskTimer::where('programmedTask_id', $task->programmedTask_id)->orderBy('id', 'desc')->first();
                    if($task->t_id == $task_temp->id) {
                        $task->outdated = 0;
                    } else
                        $task->outdated = 1;
                }
            }
        }

        $project = \App\Project::find($id);

        $expertise = \App\Project_Expertise::where('project_id', $id)
                                           ->where('parent', 0)
                                           ->join('expertise', 'expertise.id', '=', 'project_expertise.expertise_id')
                                           ->select('expertise_id as id', 'expertise.name as name', 'project_expertise.id as proj_e_id')
                                           ->get();
        $subExpertise = \App\Project_Expertise::where('project_id', $id)
                                           ->where('parent', '!=', 0)
                                           ->join('expertise', 'expertise.id', '=', 'project_expertise.expertise_id')
                                           ->select('expertise_id as id', 'expertise.name as name', 'parent as parent')
                                           ->get();

        $phases = \App\Project_Phase::where('project_id', $id)
                                    ->join('phases', 'phases.id', '=', 'project_phase.phase_id')
                                    ->select('phase_id as id', 'phases.name as name')
                                    ->get();

        $eventTypes = \App\Project_Event_Type::all();

        $plannedEvents = \App\Task::where('project_id', $id)->orderBy('start_date', 'desc')->get();

        $plannedTasks = \App\Task::where('project_id', $id)->where('type', 6)->get();
        foreach($plannedTasks as $key => $task) {
            $task_timer = \App\TaskTimer::where('programmedTask_id', $task->id)
                                        ->where('done', 100)
                                        ->first();
            if($task_timer != null) {
                $plannedTasks->forget($key);
            }
        }

        $plannedTasks = $plannedTasks->values();

        $states = \App\State_Type::all();

        return view('projectExecutedTasks', array('tasks' => $tasks, 'activeL' => 'gestão', 'activeLL' => 'tarefasExecutadas', 'project' => $project, 'phases' => $phases, 'expertise' => $expertise, 'subExpertise' => $subExpertise, 'eventTypes' => $eventTypes, 'plannedTasks' => $plannedTasks, 'executedTasks' => $executedTasks, 'states' => $states, 'plannedEvents' => $plannedEvents));
    }

    public function addProjectExecutedTask(Request $r, $id) {
        DB::transaction(function () use($r, $id) {
            $project = \App\Project::find($id);

            if($r['type'] == 6) {

                $taskTemp = \App\Task::find($r['task']);

                $task = new \App\GanttTask();
                $task->number = 0;
                $task->type = 3;
                $task->text = $taskTemp->name;
                $task->start_date = $r['start_date'];

                $totalTime = $r['hours'] + ($r['minutes'] / 60);

                $task->duration = ceil($totalTime);

                if($taskTemp->expertise_id != 0) {
                    $expertiseTask = \App\GanttTask::where('expertise_id', $taskTemp->expertise_id)
                                                ->where('parent', $project->operational_project_Task_ID)
                                                ->first();
                    if(!count($expertiseTask)) {
                        $expertise = \App\Expertise::find($taskTemp->expertise_id);
                        $expertiseTask = new \App\GanttTask();
                        $expertiseTask->text = $expertise->name;
                        $expertiseTask->number = $expertise->code;
                        $expertiseTask->parent = $project->operational_project_Task_ID;
                        $expertiseTask->type = 2;
                        $expertiseTask->expertise_id = $taskTemp->expertise_id;
                        $expertiseTask->save();
                    }
                    if($taskTemp->phase_id != 0) {
                        $phaseTask = \App\GanttTask::where('phase_id', $taskTemp->phase_id)->where('parent', $expertiseTask->id)->first();
                        if(!count($phaseTask)) {
                            $phaseTask = new \App\GanttTask();
                            $phase = \App\Phase::find($taskTemp->phase_id);
                            $phaseTask->text = $phase->name;
                            $phaseTask->number = $phase->code;
                            $phaseTask->parent = $expertiseTask->id;
                            $phaseTask->type = 2;
                            $phaseTask->phase_id = $taskTemp->phase_id;
                            $phaseTask->save();
                        }
                        $task->parent = $phaseTask->id;
                    } else {
                        $task->parent = $expertiseTask->id;
                    }

                } else {
                    if($taskTemp->phase_id == 0)
                        $task->parent = $project->operational_project_Task_ID;
                    else {
                        $phaseTask = new \App\GanttTask();
                        $phase = \App\Phase::find($taskTemp->phase_id);
                        $phaseTask->text = $phase->name;
                        $phaseTask->number = $phase->code;
                        $phaseTask->parent = $project->operational_project_Task_ID;
                        $phaseTask->type = 2;
                        $phaseTask->phase_id = $taskTemp->phase_id;
                        $phaseTask->save();
                        $task->parent = $phaseTask->id;
                    }
                }

                $task->responsible = \App\User::find($r['user'])->sigla;
                $task->save();

                $taskTimer = new \App\TaskTimer();
                $taskTimer->user_id = $r['user'];
                $taskTimer->project_id = $id;
                $taskTimer->expertise_id = $taskTemp->expertise_id;
                $taskTimer->subexpertise_id = $taskTemp->subExpertise_id;
                $taskTimer->phase_id = $taskTemp->phase_id;
                $taskTimer->task_name = $taskTemp->name;
                $taskTimer->minutes = $r['minutes'];
                $taskTimer->hours = $r['hours'];
                $taskTimer->date = $r['start_date'];
                $taskTimer->done = $r['statePercentage'];
                $taskTimer->programmedTask_id = $taskTemp->id;
                $taskTimer->ganttTask_id = $task->id;
                $userToApprove = $this->getNextUserFromWorkflow(Auth::user()->id);
                if($userToApprove != null)
                    $taskTimer->userToApprove = $userToApprove;
                else
                    $taskTimer->approved = 1;
                $taskTimer->save();

                $ganttTask = \App\GanttTask::find($taskTemp->ganttTask_id);
                $ganttTask->progress = $r['statePercentage'] / 100;
                $ganttTask->save(); 
            } else if($r['type'] == 1) {

                $task = new \App\GanttTask();
                $task->number = 0;
                $task->milestone = 1;
                $task->type = 3;
                $task->text = \App\State_Type::find($r['state'])->name;
                $task->start_date = $r['start_date'];

                $task->duration = 24;

                if($r['expertise'] != 0) {
                    $expertiseTask = \App\GanttTask::where('expertise_id', $r['expertise'])
                                                ->where('parent', $project->operational_project_Task_ID)
                                                ->first();
                    if(!count($expertiseTask)) {
                        $expertise = \App\Expertise::find($r['expertise']);
                        $expertiseTask = new \App\GanttTask();
                        $expertiseTask->text = $expertise->name;
                        $expertiseTask->number = $expertise->code;
                        $expertiseTask->parent = $project->operational_project_Task_ID;
                        $expertiseTask->type = 2;
                        $expertiseTask->expertise_id = $r['expertise'];
                        $expertiseTask->save();
                    }
                    if($r['phase'] != 0) {
                        $phaseTask = \App\GanttTask::where('phase_id', $r['phase'])->where('parent', $expertiseTask->id)->first();
                        if(!count($phaseTask)) {
                            $phaseTask = new \App\GanttTask();
                            $phase = \App\Phase::find($r['phase']);
                            $phaseTask->text = $phase->name;
                            $phaseTask->number = $phase->code;
                            $phaseTask->parent = $expertiseTask->id;
                            $phaseTask->type = 2;
                            $phaseTask->phase_id = $r['phase'];
                            $phaseTask->save();
                        }
                        $task->parent = $phaseTask->id;
                    } else {
                        $task->parent = $expertiseTask->id;
                    }

                } else {
                    if($r['phase'] == 0)
                        $task->parent = $project->operational_project_Task_ID;
                    else {
                        $phaseTask = new \App\GanttTask();
                        $phase = \App\Phase::find($r['phase']);
                        $phaseTask->text = $phase->name;
                        $phaseTask->number = $phase->code;
                        $phaseTask->parent = $project->operational_project_Task_ID;
                        $phaseTask->type = 2;
                        $phaseTask->phase_id = $r['phase'];
                        $phaseTask->save();
                        $task->parent = $phaseTask->id;
                    }
                }

                $task->responsible = \App\User::find($r['user'])->sigla;
                $task->save();


                $projectTask = new \App\Executed_Task();
                $projectTask->project_id = $id;
                if($r['phase'] != 0)
                    $projectTask->phase_id = $r['phase'];
                if($r['expertise'] != 0)
                    $projectTask->expertise_id = $r['expertise'];
                if($r['subExpertise'] != 0)
                    $projectTask->subExpertise_id = $r['subExpertise'];

                $projectTask->name = \App\State_Type::find($r['state'])->name;
                $projectTask->subType = $r['state'];
                $projectTask->start_date = $r['start_date'];
                $projectTask->user_id = $r['user'];
                $projectTask->hours = $r['hours'];
                $projectTask->minutes = $r['minutes'];
                $projectTask->notes = $r['notes'];
                $projectTask->ganttTask_id = $task->id;
                $projectTask->type = $r['type'];

                $projectTask->save();
            } else {

                $task = new \App\GanttTask();
                $task->number = 0;
                $task->milestone = 1;
                $task->type = 3;
                $task->text = \App\Task::find($r['name'])->name;
                $task->start_date = $r['start_date'];

                $task->duration = 24;

                if($r['expertise'] != 0) {
                    $expertiseTask = \App\GanttTask::where('expertise_id', $r['expertise'])
                                                ->where('parent', $project->operational_project_Task_ID)
                                                ->first();
                    if(!count($expertiseTask)) {
                        $expertise = \App\Expertise::find($r['expertise']);
                        $expertiseTask = new \App\GanttTask();
                        $expertiseTask->text = $expertise->name;
                        $expertiseTask->number = $expertise->code;
                        $expertiseTask->parent = $project->operational_project_Task_ID;
                        $expertiseTask->type = 2;
                        $expertiseTask->expertise_id = $r['expertise'];
                        $expertiseTask->save();
                    }
                    if($r['phase'] != 0) {
                        $phaseTask = \App\GanttTask::where('phase_id', $r['phase'])->where('parent', $expertiseTask->id)->first();
                        if(!count($phaseTask)) {
                            $phaseTask = new \App\GanttTask();
                            $phase = \App\Phase::find($r['phase']);
                            $phaseTask->text = $phase->name;
                            $phaseTask->number = $phase->code;
                            $phaseTask->parent = $expertiseTask->id;
                            $phaseTask->type = 2;
                            $phaseTask->phase_id = $r['phase'];
                            $phaseTask->save();
                        }
                        $task->parent = $phaseTask->id;
                    } else {
                        $task->parent = $expertiseTask->id;
                    }

                } else {
                    if($r['phase'] == 0)
                        $task->parent = $project->operational_project_Task_ID;
                    else {
                        $phaseTask = new \App\GanttTask();
                        $phase = \App\Phase::find($r['phase']);
                        $phaseTask->text = $phase->name;
                        $phaseTask->number = $phase->code;
                        $phaseTask->parent = $project->operational_project_Task_ID;
                        $phaseTask->type = 2;
                        $phaseTask->phase_id = $r['phase'];
                        $phaseTask->save();
                        $task->parent = $phaseTask->id;
                    }
                }

                $task->responsible = \App\User::find($r['user'])->sigla;
                $task->save();

                $projectTask = new \App\Executed_Task();
                $projectTask->project_id = $id;
                if($r['phase'] != 0)
                    $projectTask->phase_id = $r['phase'];
                if($r['expertise'] != 0)
                    $projectTask->expertise_id = $r['expertise'];
                if($r['subExpertise'] != 0)
                    $projectTask->subExpertise_id = $r['subExpertise'];

                $plannedTask = \App\Task::find($r['name']);
                $ganttPlannedTask = \App\GanttTask::find($plannedTask->ganttTask_id);
                $ganttPlannedTask->planned_executed = 1;
                $ganttPlannedTask->save();

                $projectTask->name = $plannedTask->name;
                $projectTask->start_date = $r['start_date'];
                $projectTask->user_id = $r['user'];
                $projectTask->hours = $r['hours'];
                $projectTask->minutes = $r['minutes'];
                $projectTask->notes = $r['notes'];
                $projectTask->type = $r['type'];
                $projectTask->ganttTask_id = $task->id;
                if($r['subType'] != 0)
                    $projectTask->subType = $r['subType'];

                $projectTask->save();
            }
        });

        return redirect()->back();
    }

    public function addTask(Request $r, $id) {

        DB::transaction(function () use($r, $id) {
            $project = \App\Project::find($id);

            if($r['type'] == 6) {
                $task = new \App\GanttTask();
                $task->number = 0;
                $task->text = $r['name'];
                $task->start_date = $r['start_date'];
                $date1 = new DateTime($r['startDate']);
                $date2 = new DateTime($r['end_date']);
                $interval = $date1->diff($date2);
                $task->duration = ($interval->d + 1) * 24;

               if($r['expertise'] != 0) {
                    $expertiseTask = \App\GanttTask::where('expertise_id', $r['expertise'])
                                                ->where('parent', $project->commercial_project_Task_ID)
                                                ->first();
                    if(!count($expertiseTask)) {
                        $expertise = \App\Expertise::find($r['expertise']);
                        $expertiseTask = new \App\GanttTask();
                        $expertiseTask->text = $expertise->name;
                        $expertiseTask->number = $expertise->code;
                        $expertiseTask->parent = $project->commercial_project_Task_ID;
                        $expertiseTask->type = 2;
                        $expertiseTask->expertise_id = $r['expertise'];
                        $expertiseTask->save();
                    }
                    if($r['phase'] != 0) {
                        $phaseTask = \App\GanttTask::where('phase_id', $r['phase'])->where('parent', $expertiseTask->id)->first();
                        if(!count($phaseTask)) {
                            $phaseTask = new \App\GanttTask();
                            $phase = \App\Phase::find($r['phase']);
                            $phaseTask->text = $phase->name;
                            $phaseTask->number = $phase->code;
                            $phaseTask->parent = $expertiseTask->id;
                            $phaseTask->type = 2;
                            $phaseTask->phase_id = $r['phase'];
                            $phaseTask->save();
                        }
                        $task->parent = $phaseTask->id;
                    } else {
                        $task->parent = $expertiseTask->id;
                    }

                } else {
                    if($r['phase'] == 0)
                        $task->parent = $project->commercial_project_Task_ID;
                    else {
                        $phaseTask = new \App\GanttTask();
                        $phase = \App\Phase::find($r['phase']);
                        $phaseTask->text = $phase->name;
                        $phaseTask->number = $phase->code;
                        $phaseTask->parent = $project->commercial_project_Task_ID;
                        $phaseTask->type = 2;
                        $phaseTask->phase_id = $r['phase'];
                        $phaseTask->save();
                        $task->parent = $phaseTask->id;
                    }
                }

                $task->responsible = \App\User::find($r['user'])->sigla;
                $task->save();

                $projectTask = new \App\Task();
                $projectTask->project_id = $id;
                $projectTask->ganttTask_id = $task->id;
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

                /*$event = new \App\SchedulerEvent();
                $event->start_date = $projectTask->start_date;
                $event->end_date = $projectTask->end_date;
                $event->event_name = $projectTask->name;
                $event->type = $r['type'];
                $event->plannedTask_id = $projectTask->id;
                $event->user_id = $projectTask->user_id;
                $event->project_id = $projectTask->project_id;
                $event->save();*/
            } else {
                $task = new \App\GanttTask();
                $task->number = 0;
                $task->text = $r['name'];
                $task->start_date = $r['start_date'];
                $task->duration = 24;
                $task->milestone = 1;

               if($r['expertise'] != 0) {
                    $expertiseTask = \App\GanttTask::where('expertise_id', $r['expertise'])
                                                ->where('parent', $project->commercial_project_Task_ID)
                                                ->first();
                    if(!count($expertiseTask)) {
                        $expertise = \App\Expertise::find($r['expertise']);
                        $expertiseTask = new \App\GanttTask();
                        $expertiseTask->text = $expertise->name;
                        $expertiseTask->number = $expertise->code;
                        $expertiseTask->parent = $project->commercial_project_Task_ID;
                        $expertiseTask->type = 2;
                        $expertiseTask->expertise_id = $r['expertise'];
                        $expertiseTask->save();
                    }
                    if($r['phase'] != 0) {
                        $phaseTask = \App\GanttTask::where('phase_id', $r['phase'])->where('parent', $expertiseTask->id)->first();
                        if(!count($phaseTask)) {
                            $phaseTask = new \App\GanttTask();
                            $phase = \App\Phase::find($r['phase']);
                            $phaseTask->text = $phase->name;
                            $phaseTask->number = $phase->code;
                            $phaseTask->parent = $expertiseTask->id;
                            $phaseTask->type = 2;
                            $phaseTask->phase_id = $r['phase'];
                            $phaseTask->save();
                        }
                        $task->parent = $phaseTask->id;
                    } else {
                        $task->parent = $expertiseTask->id;
                    }

                } else {
                    if($r['phase'] == 0)
                        $task->parent = $project->commercial_project_Task_ID;
                    else {
                        $phaseTask = new \App\GanttTask();
                        $phase = \App\Phase::find($r['phase']);
                        $phaseTask->text = $phase->name;
                        $phaseTask->number = $phase->code;
                        $phaseTask->parent = $project->commercial_project_Task_ID;
                        $phaseTask->type = 2;
                        $phaseTask->phase_id = $r['phase'];
                        $phaseTask->save();
                        $task->parent = $phaseTask->id;
                    }
                }

                $task->responsible = \App\User::find($r['user'])->sigla;
                $task->save();

                $projectTask = new \App\Task();
                $projectTask->project_id = $id;
                $projectTask->ganttTask_id = $task->id;
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

                /*$event = new \App\SchedulerEvent();
                $event->start_date = $projectTask->start_date;
                $event->end_date = $projectTask->start_date;
                $event->event_name = $projectTask->name;
                $event->type = $r['type'];
                $event->plannedTask_id = $projectTask->id;
                $event->user_id = $projectTask->user_id;
                $event->project_id = $projectTask->project_id;
                $event->save();*/
            }
        });

        return redirect()->back();

    }

    public function removeTask($id) {
        $task = \App\Task::find($id);

        if($task == null)
            $task = \App\Executed_Task::find($id);

        \App\GanttTask::find($task->ganttTask_id)->delete();
        $task->delete();
    }

    public function getProgrammedTask(Request $r) {
        $tasks = \App\Task::where('project_id', $r['project_id'])
                          ->where('user_id', $r['assignedTo'])
                          ->get();
        foreach($tasks as $key => $task) {
            $task_timer = \App\TaskTimer::where('programmedTask_id', $task->id)
                                        ->where('done', 100)
                                        ->first();
            if($task_timer != null) {
                $tasks->forget($key);
            }
        }

        $tasks = $tasks->values();

        return $tasks;
    }

    public function getProjectEvents($id) {
        $this->registerProjectSeen($id);
        $events = \App\Project_Event::where('project_id', $id)
                                    ->join('users', 'users.id', '=', 'project_events.user_id')
                                    ->join('project_event_types', 'project_event_types.id', '=', 'project_events.type_id')
                                    ->leftJoin('state_types', 'state_types.id', '=', 'project_events.state_id')
                                    ->select('project_events.id as id', 'users.name as u_name','users.sigla as u_sigla', 'state_types.name as s_name', 'project_event_types.name as t_name', 'project_events.date as date', 'project_events.observations as observations')
                                    ->orderBy('project_events.date', 'desc')
                                    ->get();
        $project = \App\Project::find($id);

        $states = \App\State_Type::all();
        $eventTypes = \App\Project_Event_Type::all();

        return view('projectEvents', array('events' => $events, 'activeL' => 'gestão', 'activeLL' => 'acontecimentos', 'project' => $project, 'states' => $states, 'eventTypes' => $eventTypes));
    }

    public function addEvent(Request $r, $id) {
        $event = new \App\Project_Event();

        $event->project_id = $id;
        $event->user_id = $r['user'];
        $event->insertedBy_id = Auth::user()->id;
        $event->type_id = $r['type'];
        $event->date = $r['date'];
        $event->observations = $r['observations'];
        if($r['subType'] != 0)
            $event->state_id = $r['subType'];

        $event->save();

        return redirect()->back();
    }

    public function removeEvent($id) {
        \App\Project_Event::find($id)->delete();
    }

    public function getProjectReport($id) {
        $this->registerProjectSeen($id);
        $project = \App\Project::find($id);

        $events = \App\Project_Event::where('project_id', $id)
                                   ->join('project_event_types', 'project_event_types.id', '=', 'project_events.type_id')
                                   ->select('date as date', 'project_event_types.name as type', 'observations as description')
                                   ->orderBy('date', 'desc');

        $tasks = \App\TaskTimer::where('project_id', $id)
                               ->select('date as date', DB::raw("'Tarefa' AS type"), 'task_name as description')
                               ->orderBy('date', 'desc');

        $project_planning = \App\Project_Planning::where('project_id', $id)
                                                 ->join('planning_types', 'planning_types.id', '=', 'project_planning.type')
                                                 ->select('startDate as date', 'planning_types.name as type', 'planning_types.name as description')
                                                 ->union($events)
                                                 ->union($tasks)
                                                 ->orderBy('date', 'desc')
                                                 ->get();

        $task_timer_hours = \App\TaskTimer::where('project_id', $id)
                                          ->sum('hours');

        $task_timer_min = \App\TaskTimer::where('project_id', $id)
                                        ->sum('minutes');

        $task_timer_hours = $task_timer_hours + ($task_timer_min / 60);

        $numberTaskTimer = \App\TaskTimer::where('project_id', $id)
                                         ->count();

        $numberExecutedTasks = \App\Executed_Task::where('project_id', $id)
                                                 ->count();

        $obj = [];

        $obj['Tarefa'] = $numberTaskTimer;

        $taskTypes = \App\Executed_Task::groupBy('type', 'project_event_types.name')
                                       ->where('project_id', $id)
                                       ->join('project_event_types', 'project_event_types.id', '=', 'executed_tasks.type')
                                       ->select(DB::raw('count(*) as counter'), 'project_event_types.name as name')
                                       ->havingRaw('count(*) > 0')
                                       ->get();

        foreach($taskTypes as $task) {
            $obj[$task->name] = $task->counter;
        }

        $members = \App\TaskTimer::groupBy('users.id', 'users.sigla')
                                 ->where('project_id', $id)
                                 ->join('users', 'users.id', 'user_id')
                                 ->select(DB::raw('sum(hours) + ceil(sum(minutes/60)) as time'), 'users.sigla as sigla')
                                 ->get();

        $membersObj = [];
        foreach($members as $member) {
            $membersObj[$member->sigla] = $member->time;
        }

        $expertise = \App\TaskTimer::groupBy('expertise_id', 'expertise.sigla')
                                ->where('project_id', $id)
                                ->join('expertise', 'expertise.id', '=', 'expertise_id')
                                ->select(DB::raw('sum(hours) + ceil(sum(minutes/60)) as time'), 'expertise.sigla as sigla')
                                ->get();
        $expertiseObj = [];

        foreach($expertise as $expert) {
            $expertiseObj[$expert->sigla] = $expert->time;
        } 

        $phases = \App\TaskTimer::groupBy('phase_id', 'phases.sigla')
                                ->where('project_id', $id)
                                ->join('phases', 'phases.id', '=', 'phase_id')
                                ->select(DB::raw('sum(hours) + ceil(sum(minutes/60)) as time'), 'phases.sigla as sigla')
                                ->get();

        $phasesObj = [];

        foreach($phases as $phase) {
            $phasesObj[$phase->sigla] = $phase->time;
        } 



        return view('projectReport', array('project' => $project, 'activeL' => 'gestão', 'activeLL' => 'relatório', 'events' => $project_planning, 'task_timer_hours' => $task_timer_hours, 'totalNumberTasks' => $numberTaskTimer + $numberExecutedTasks, 'pieDataTaskType' => json_encode($obj), 'pieDataMembers' => json_encode($membersObj), 'pieDataExpertise' => json_encode($expertiseObj), 'pieDataPhases' => json_encode($phasesObj)));
    }

    public function editProjectCaracterization(Request $r) {
        $project = \App\Project::find($r['id']);
        if($r['projectType'] != 0)
            $project->type = $r['projectType'];

        if(is_numeric($r['constructionArea']))
            $project->constructionArea = $r['constructionArea'];

        if(is_numeric($r['totalArea']))
            $project->totalArea = $r['totalArea'];

        if(is_numeric($r['value']))
            $project->value = $r['value'];

        $project->save();

        $projectDetails = \App\Project_Details::where('project_id', $r['id'])->first();

        if($projectDetails == null) {
            $projectDetails = new \App\Project_Details();
            $projectDetails->project_id = $r['id'];
        } 

        if($r['constructionType'] != 0)
            $projectDetails->constructionType = $r['constructionType'];
        if($r['utilizationType'] != 0)
            $projectDetails->utilizationType = $r['utilizationType'];
        if(is_numeric($r['totalNumberFloors']))
            $projectDetails->totalNumberFloors = $r['totalNumberFloors'];
        if(is_numeric($r['numberBuriedFloors']))
            $projectDetails->numberBuriedFloors = $r['numberBuriedFloors'];
        
        $projectDetails->save();
    }

    public function editDescription(Request $r) {
        $project = \App\Project::find($r['id']);
        if(is_numeric($r['code']))
            $project->number = $r['code'];
        if($r['name'] != "")
            $project->name = $r['name'];
        if($r['title'] != "")
            $project->title = $r['title'];
        if($r['address'] != "")
            $project->address = $r['address'];
        if($r['zip_code'] != "")
            $project->zip_code = $r['zip_code'];
        if($r['local'] != "")
            $project->local = $r['local'];

        $project->save();

    }

    public function editProjectTaskTime(Request $r) {
        $task = \App\Task::where('ganttTask_id', $r['task_id'])->first();

        if($task != null) {
            $task->start_date = $r['start_date'];
            $task->end_date = $r['end_date'];
            $task->save();   
        }
    }

    public function editExecutedTaskNote(Request $r) {
        $task = \App\Executed_Task::find($r['id']);
        $task->notes = $r['notes'];
        $task->save();
    }

    public function editPlannedTaskNote(Request $r) {
        $task = \App\Task::find($r['id']);
        $task->notes = $r['notes'];
        $task->save();
    }

    public function editTaskTimerNote(Request $r) {
        $task = \App\TaskTimer::find($r['id']);
        $task->notes = $r['notes'];
        $task->save();
    }

    public function getProject($id) {
        return \App\Project::find($id);
    }

    public function editProjectExpertisePhases(Request $r) {
        foreach($r['obj'] as $key => $obj) {
            $project_expertise_id = \App\Project_Expertise::where('expertise_id', $key)->where('project_id', $r['project_id'])->first()->id;
            for($i = 0; $i < count($obj); $i++) {
                if($obj[$i][0] == '-') {
                    $projectExpertisePhase = \App\Project_Expertise_Phase::where('project_expertise_id', $project_expertise_id)
                                                                         ->where('phase_id', substr($obj[$i], 1))
                                                                         ->forceDelete();
                } else {
                    $projectExpertisePhase = \App\Project_Expertise_Phase::where('project_expertise_id', $project_expertise_id)
                                                                     ->where('phase_id', $obj[$i])
                                                                     ->first();
                    if($projectExpertisePhase == null) {
                        $projectExpertisePhase = new \App\Project_Expertise_Phase();
                        $projectExpertisePhase->project_expertise_id = $project_expertise_id;
                        $projectExpertisePhase->phase_id = $obj[$i];
                        $projectExpertisePhase->save();
                    }
                }
            }
        }
    }

    public function editProjectExecutedTask(Request $r) {
        DB::transaction(function () use($r) {
            $project = \App\Project::find($r['project_id']);


            if($r['taskType'] == 'TF') {
                $task = \App\TaskTimer::find($r['id']);
                $task->approved = 0;
                if($r['subExpertise'] != 0)
                    $task->subexpertise_id = $r['subExpertise'];
                else 
                    $task->subexpertise_id = null;
                $task->date = $r['date'];
            } else {
                $task = \App\Executed_Task::find($r['id']);
                if($r['subExpertise'] != 0)
                    $task->subExpertise_id = $r['subExpertise'];
                else
                    $task->subExpertise_id = null;
                $task->start_date = $r['date'];
            }

            $task->user_id = $r['user'];
            $task->notes = $r['notes'];

            if($r['expertise'] != 0)
                $task->expertise_id = $r['expertise'];
            else
                $task->expertise_id = null;
            if($r['phase'] != 0)
                $task->phase_id = $r['phase'];
            else
                $task->phase_id = null;
            if($task->ganttTask_id != null) {
                $ganttTask = \App\GanttTask::find($task->ganttTask_id);
                $ganttTask->start_date = $r['date'];

                if($r['expertise'] != 0) {
                    $expertiseTask = \App\GanttTask::where('expertise_id', $r['expertise'])
                                                ->where('parent', $project->operational_project_Task_ID)
                                                ->first();
                    if(!count($expertiseTask)) {
                        $expertise = \App\Expertise::find($r['expertise']);
                        $expertiseTask = new \App\GanttTask();
                        $expertiseTask->text = $expertise->name;
                        $expertiseTask->number = $expertise->code;
                        $expertiseTask->parent = $project->operational_project_Task_ID;
                        $expertiseTask->type = 2;
                        $expertiseTask->expertise_id = $r['expertise'];
                        $expertiseTask->save();
                    }
                    if($r['phase'] != 0) {
                        $phaseTask = \App\GanttTask::where('phase_id', $r['phase'])->where('parent', $expertiseTask->id)->first();
                        if(!count($phaseTask)) {
                            $phaseTask = new \App\GanttTask();
                            $phase = \App\Phase::find($r['phase']);
                            $phaseTask->text = $phase->name;
                            $phaseTask->number = $phase->code;
                            $phaseTask->parent = $expertiseTask->id;
                            $phaseTask->type = 2;
                            $phaseTask->phase_id = $r['phase'];
                            $phaseTask->save();
                        }
                        $ganttTask->parent = $phaseTask->id;
                    } else {
                        $ganttTask->parent = $expertiseTask->id;
                    }

                } else {
                    if($r['phase'] == 0)
                        $ganttTask->parent = $project->operational_project_Task_ID;
                    else {
                        $phaseTask = new \App\GanttTask();
                        $phase = \App\Phase::find($r['phase']);
                        $phaseTask->text = $phase->name;
                        $phaseTask->number = $phase->code;
                        $phaseTask->parent = $project->operational_project_Task_ID;
                        $phaseTask->type = 2;
                        $phaseTask->phase_id = $r['phase'];
                        $phaseTask->save();
                        $ganttTask->parent = $phaseTask->id;
                    }
                }

                $ganttTask->responsible = \App\User::find($r['user'])->sigla;
                $ganttTask->save();
            }
            $task->save();
        });
    }

    public function editPlannedTask(Request $r) {
        DB::transaction(function () use($r) {
            $project = \App\Project::find($r['project_id']);
            $task = \App\Task::find($r['id']);
            $task->user_id = $r['user'];
            $task->start_date = $r['start_date'];
            $task->end_date = $r['end_date'];
            $task->notes = $r['notes'];
            if($r['expertise'] != 0)
                $task->expertise_id = $r['expertise'];
            else
                $task->expertise_id = null;

            if($r['subExpertise'] != 0)
                $task->subExpertise_id = $r['subExpertise'];
            else
                $task->subExpertise_id = null;

            if($r['phase'] != 0)
                $task->phase_id = $r['phase'];
            else
                $task->phase_id = null;

            if($task->ganttTask_id != null) {
                $ganttTask = \App\GanttTask::find($task->ganttTask_id);
                $ganttTask->start_date = $r['start_date'];
                $ganttTask->end_date = $r['end_date'];
                if($r['expertise'] != 0) {
                    $expertiseTask = \App\GanttTask::where('expertise_id', $r['expertise'])
                                                ->where('parent', $project->commercial_project_Task_ID)
                                                ->first();
                    if(!count($expertiseTask)) {
                        $expertise = \App\Expertise::find($r['expertise']);
                        $expertiseTask = new \App\GanttTask();
                        $expertiseTask->text = $expertise->name;
                        $expertiseTask->number = $expertise->code;
                        $expertiseTask->parent = $project->commercial_project_Task_ID;
                        $expertiseTask->type = 2;
                        $expertiseTask->expertise_id = $r['expertise'];
                        $expertiseTask->save();
                    }
                    if($r['phase'] != 0) {
                        $phaseTask = \App\GanttTask::where('phase_id', $r['phase'])->where('parent', $expertiseTask->id)->first();
                        if(!count($phaseTask)) {
                            $phaseTask = new \App\GanttTask();
                            $phase = \App\Phase::find($r['phase']);
                            $phaseTask->text = $phase->name;
                            $phaseTask->number = $phase->code;
                            $phaseTask->parent = $expertiseTask->id;
                            $phaseTask->type = 2;
                            $phaseTask->phase_id = $r['phase'];
                            $phaseTask->save();
                        }
                        $ganttTask->parent = $phaseTask->id;
                    } else {
                        $ganttTask->parent = $expertiseTask->id;
                    }

                } else {
                    if($r['phase'] == 0) {
                        $ganttTask->parent = $project->commercial_project_Task_ID;
                    }
                    else {
                        $phaseTask = new \App\GanttTask();
                        $phase = \App\Phase::find($r['phase']);
                        $phaseTask->text = $phase->name;
                        $phaseTask->number = $phase->code;
                        $phaseTask->parent = $project->commercial_project_Task_ID;
                        $phaseTask->type = 2;
                        $phaseTask->phase_id = $r['phase'];
                        $phaseTask->save();
                        $ganttTask->parent = $phaseTask->id;
                    }
                }

                $ganttTask->responsible = \App\User::find($r['user'])->sigla;
                $ganttTask->save();
            }

            $task->save();
        });
    }

    public function getExecutedTaskDetails(Request $r) {
        if($r['task'] == 'TF') {
            $task = \App\TaskTimer::join('users', 'users.id', '=', 'task_timer.user_id')
                                  ->leftJoin('expertise', 'expertise.id', '=', 'expertise_id')
                                  ->leftJoin('phases', 'phases.id', '=', 'phase_id')
                                  ->where('task_timer.id', $r['id'])
                                  ->select('task_name as name', 'phases.name as phaseSigla', 'expertise.name as expertiseSigla', 'date as start_date', DB::raw('"Tarefa" as type'), 'users.name as userName', 'subexpertise_id as subexpertise_id', 'user_id as user_id', DB::raw('"6" as type_id'), 'expertise_id as expertise_id', 'phase_id as phase_id', 'notes as notes')
                                  ->first();

        } else {
            $task = \App\Executed_Task::join('users', 'users.id', '=', 'user_id')
                                  ->leftJoin('expertise', 'expertise.id', '=', 'expertise_id')
                                  ->leftJoin('phases', 'phases.id', '=', 'phase_id')
                                  ->leftJoin('project_event_types', 'project_event_types.id', '=', 'executed_tasks.type')
                                  ->where('executed_tasks.id', $r['id'])
                                  ->select('executed_tasks.name as name', 'phases.name as phaseSigla', 'expertise.name as expertiseSigla', 'start_date as start_date', 'users.name as userName', 'subExpertise_id as subexpertise_id', 'user_id as user_id', 'expertise_id as expertise_id', 'phase_id as phase_id', 'executed_tasks.type as type_id', 'project_event_types.name as type', 'notes as notes')
                                  ->first();

        }

        $subExpertise = \App\Expertise::where('id', $task->subexpertise_id)->first();
            if($subExpertise != null)
                $task->subExpertiseSigla = $subExpertise->name;

        return $task;
    }

    public function getPlannedTaskDetails(Request $r) {
        $task = \App\Task::join('users', 'users.id', '=', 'user_id')
                          ->leftJoin('expertise', 'expertise.id', '=', 'expertise_id')
                          ->leftJoin('phases', 'phases.id', '=', 'phase_id')
                          ->leftJoin('project_event_types', 'project_event_types.id', '=', 'tasks.type')
                          ->where('tasks.id', $r['id'])
                          ->select('tasks.name as name', 'phases.sigla as phaseSigla', 'expertise.sigla as expertiseSigla', 'start_date as start_date', 'users.name as userName', 'subExpertise_id as subexpertise_id', 'user_id as user_id', 'expertise_id as expertise_id', 'phase_id as phase_id', 'tasks.type as type_id', 'project_event_types.name as type', 'end_date as end_date', 'notes as notes')
                          ->first();

        $subExpertise = \App\Expertise::where('id', $task->subexpertise_id)->first();
            if($subExpertise != null)
                $task->subExpertiseSigla = $subExpertise->sigla;

        return $task;
    }

    public function getPlannedTaskDetailsFromGantt(Request $r) {
        $task = \App\Task::join('users', 'users.id', '=', 'user_id')
                          ->leftJoin('expertise', 'expertise.id', '=', 'expertise_id')
                          ->leftJoin('phases', 'phases.id', '=', 'phase_id')
                          ->leftJoin('project_event_types', 'project_event_types.id', '=', 'tasks.type')
                          ->where('tasks.ganttTask_id', $r['id'])
                          ->select('tasks.name as name', 'phases.sigla as phaseSigla', 'expertise.sigla as expertiseSigla', 'start_date as start_date', 'users.name as userName', 'subExpertise_id as subexpertise_id', 'user_id as user_id', 'expertise_id as expertise_id', 'phase_id as phase_id', 'tasks.type as type_id', 'project_event_types.name as type', 'end_date as end_date', 'notes as notes')
                          ->first();

        $subExpertise = \App\Expertise::where('id', $task->subexpertise_id)->first();
            if($subExpertise != null)
                $task->subExpertiseSigla = $subExpertise->sigla;

        return $task;
    }

    public function editPlannedTaskFromGantt(Request $r) {
        DB::transaction(function () use($r) {
            $project = \App\Project::find($r['project_id']);
            $task = \App\Task::where('ganttTask_id', $r['id'])->first();
            $task->name = $r['task_name'];
            $task->user_id = $r['user'];
            $task->start_date = $r['start_date'];
            $task->end_date = $r['end_date'];
            $task->notes = $r['notes'];
            if($r['expertise'] != 0)
                $task->expertise_id = $r['expertise'];
            else
                $task->expertise_id = null;

            if($r['subExpertise'] != 0)
                $task->subExpertise_id = $r['subExpertise'];
            else
                $task->subExpertise_id = null;

            if($r['phase'] != 0)
                $task->phase_id = $r['phase'];
            else
                $task->phase_id = null;

            if($task->ganttTask_id != null) {
                $ganttTask = \App\GanttTask::find($task->ganttTask_id);
                $ganttTask->start_date = $r['start_date'];
                $ganttTask->end_date = $r['end_date'];
                $date1 = new DateTime($r['start_date']);
                $date2 = new DateTime($r['end_date']);
                $interval = $date1->diff($date2);
                $ganttTask->duration = ($interval->d) * 24;
                if($r['expertise'] != 0) {
                    $expertiseTask = \App\GanttTask::where('expertise_id', $r['expertise'])
                                                ->where('parent', $project->commercial_project_Task_ID)
                                                ->first();
                    if(!count($expertiseTask)) {
                        $expertise = \App\Expertise::find($r['expertise']);
                        $expertiseTask = new \App\GanttTask();
                        $expertiseTask->text = $expertise->name;
                        $expertiseTask->number = $expertise->code;
                        $expertiseTask->parent = $project->commercial_project_Task_ID;
                        $expertiseTask->type = 2;
                        $expertiseTask->expertise_id = $r['expertise'];
                        $expertiseTask->save();
                    }
                    if($r['phase'] != 0) {
                        $phaseTask = \App\GanttTask::where('phase_id', $r['phase'])->where('parent', $expertiseTask->id)->first();
                        if(!count($phaseTask)) {
                            $phaseTask = new \App\GanttTask();
                            $phase = \App\Phase::find($r['phase']);
                            $phaseTask->text = $phase->name;
                            $phaseTask->number = $phase->code;
                            $phaseTask->parent = $expertiseTask->id;
                            $phaseTask->type = 2;
                            $phaseTask->phase_id = $r['phase'];
                            $phaseTask->save();
                        }
                        $ganttTask->parent = $phaseTask->id;
                    } else {
                        $ganttTask->parent = $expertiseTask->id;
                    }

                } else {
                    if($r['phase'] == 0) {
                        $ganttTask->parent = $project->commercial_project_Task_ID;
                    }
                    else {
                        $phaseTask = new \App\GanttTask();
                        $phase = \App\Phase::find($r['phase']);
                        $phaseTask->text = $phase->name;
                        $phaseTask->number = $phase->code;
                        $phaseTask->parent = $project->commercial_project_Task_ID;
                        $phaseTask->type = 2;
                        $phaseTask->phase_id = $r['phase'];
                        $phaseTask->save();
                        $ganttTask->parent = $phaseTask->id;
                    }
                }

                $ganttTask->responsible = \App\User::find($r['user'])->sigla;
                $ganttTask->save();
            }

            $task->save();
        });
    }

    public function editPlannedTaskFromGeneralGantt(Request $r) {
        DB::transaction(function () use($r) {
            $task = \App\Task::where('ganttTask_id', $r['id'])->first();
            $task->name = $r['task_name'];
            $task->user_id = $r['user'];
            $task->start_date = $r['start_date'];
            $task->end_date = $r['end_date'];
            $task->notes = $r['notes'];

            $ganttTask = \App\GanttTask::find($r['id']);
            $date1 = new DateTime($r['start_date']);
            $date2 = new DateTime($r['end_date']);
            $interval = $date1->diff($date2);
            $ganttTask->duration = ($interval->d) * 24;
            $ganttTask->save();

            $task->save();

        });
    }

    public function getEmailAndDepartmentFromUser($id) {
        $user = \App\User::where('users.id', $id)
                         ->join('departments', 'function', '=', 'departments.id')
                         ->select('departments.name as d_name', 'users.email as u_email')
                         ->first();

        return $user;
    }

    public function getEmailAndPhoneFromContact($id) {
        $contact = \App\Contact::find($id);

        return $contact;
    }

    public function editProjectOutsideTeamMember(Request $r) {
        $member = \App\Project_Outside_Team::find($r['id']);
        $member->function_id = $r['memberFunction'];
        $member->expertise_id = $r['expertise'];
        $member->save();
    }

    public function removeProjectTask(Request $r) {
        DB::transaction(function () use($r) {
            $ganttTask = \App\GanttTask::find($r['id']);
            $ganttTask->delete();

            $task = \App\Task::where('ganttTask_id', $r['id'])->first();
            if($task != null) {
                $executedTasks = \App\Executed_Task::where('plannedTask_id', $task->id)->get();
                foreach($executedTasks as $taskTemp) {
                    $taskTempToDelete = \App\GanttTask::find($taskTemp->ganttTask_id);
                    if($taskTempToDelete != null)
                        $taskTempToDelete->delete();
                    $taskTemp->delete();
                }
                $taskTimer = \App\TaskTimer::where('programmedTask_id', $task->id)->get();
                foreach($taskTimer as $taskTemp) {
                    $taskTempToDelete = \App\GanttTask::find($taskTemp->ganttTask_id);
                    if($taskTempToDelete != null)
                        $taskTempToDelete->delete();
                    $taskTemp->delete();
                }
                $task->delete();
            }
            
        });
    }

    public function editTeamMember(Request $r) {
        $member = \App\Project_Team::find($r['id']);
        $member->expertise_id = $r['expertise_id'];
        $member->subExpertise_id = $r['subExpertise_id'];
        $member->function_id = $r['function_id'];
        $member->save();
    }

   /* public function cenas() {
         DB::transaction(function (){
        $ganttTask = \App\GanttTask::find(869);
        $ganttTask->delete();

        $task = \App\Task::where('ganttTask_id', 869)->first();
        if($task != null) {
            $executedTasks = \App\Executed_Task::where('plannedTask_id', $task->id)->get();
            foreach($executedTasks as $taskTemp) {
                $taskTempToDelete = \App\GanttTask::find($taskTemp->ganttTask_id);
                if($taskTempToDelete != null)
                    $taskTempToDelete->delete();
                $taskTemp->delete();
            }
            $taskTimer = \App\TaskTimer::where('programmedTask_id', $task->id)->get();
            foreach($taskTimer as $taskTemp) {
                $taskTempToDelete = \App\GanttTask::find($taskTemp->ganttTask_id);
                if($taskTempToDelete != null)
                    $taskTempToDelete->delete();
                $taskTemp->delete();
            }
            $task->delete();
        }
    });
    }*/


}
