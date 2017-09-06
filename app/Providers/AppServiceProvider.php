<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use DB;

class LaravelLoggerProxy {
        public function log( $msg ) {
            Log::info($msg);
        }
    }

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $pusher = $this->app->make('pusher');
        $pusher->set_logger( new LaravelLoggerProxy() );

        view()->composer('*', function ($view) 
        {
            if(Auth::user()) {

                $users = \App\User::orderBy('name')->get();
                $projects = \App\Project::orderBy('number', 'desc')->get();

                foreach($users as $user) {
                  $result1 = \App\Chat::where('userID_1', Auth::user()->id)
                                      ->where('userID_2', $user->id)
                                      ->first();
                  $result2 = \App\Chat::where('userID_2', Auth::user()->id)
                                      ->where('userID_1', $user->id)
                                      ->first();
                  if($result1 != null) {
                    $user->chat = $result1;
                  } else if($result2 != null) {
                    $user->chat = $result2;
                  } else {
                    $user->chat = 'chatNull';
                  }
                }

                $chats = \App\Chat::where('userID_1', Auth::user()->id)
                                  ->orWhere('userID_2', Auth::user()->id)
                                  ->get();

                foreach ($chats as $chat) {
                    $chat->lastMessage = \App\Message::where('chatID', $chat->id)
                                                      ->orderBy('id', 'desc')
                                                      ->first();

                    if($chat->userID_1 == Auth::user()->id)
                        $chat->user = \App\User::find($chat->userID_2);
                    else
                        $chat->user = \App\User::find($chat->userID_1);

                    if($chat->name == null) {
                      if($chat->userID_1 == Auth::user()->id)
                        $chat->name = \App\User::find($chat->userID_2)->name;
                      else
                        $chat->name = \App\User::find($chat->userID_1)->name;
                    }

                }

                $generalChats = \App\Chat::where('userID_1', null)
                                  ->Where('userID_2', null)
                                  ->get();

                foreach ($generalChats as $chat) {
                    $chat->lastMessage = \App\Message::where('chatID', $chat->id)
                                                      ->orderBy('id', 'desc')
                                                      ->first();
                }

                $memory = \App\User_Memory::where('user_id', Auth::user()->id)->first();

                View::share('chats', $chats);
                View::share('generalChats', $generalChats);
                View::share('usersList', $users);
                View::share('projectsList', $projects);
                if($memory != null) {
                  if($memory->lastProjectsSeen != null) {
                    $lastProjectsSeen = [];
                    foreach(unserialize($memory->lastProjectsSeen) as $project) {
                      $projectObject = \App\Project::find($project);
                      array_push($lastProjectsSeen, $projectObject);
                    }
                    View::share('memoryProject', array_reverse($lastProjectsSeen));
                  }
                }

                $commercialTasks = \App\Commercial_Task::join('commercial_projects', 'commercial_projects.id', '=', 'commercial_tasks.project_id')
                                            ->leftJoin('phases', 'phases.id', '=', 'commercial_tasks.phase_id')
                                            ->leftJoin('expertise', 'expertise.id', '=', 'commercial_tasks.expertise_id')
                                            ->select('commercial_tasks.name as name', 'commercial_projects.number as p_number', 'commercial_tasks.id as id', 'commercial_tasks.type as type', 'commercial_projects.name as p_name', 'commercial_tasks.start_date as start_date', 'commercial_tasks.end_date as end_date', 'expertise.sigla as e_sigla', 'phases.sigla as ph_sigla', 'commercial_projects.id as p_id', DB::raw('"commercial" as taskType'));

                $tasksPercentage = \App\Task::join('project', 'project.id', '=', 'tasks.project_id')
                                            ->leftJoin('phases', 'phases.id', '=', 'tasks.phase_id')
                                            ->leftJoin('expertise', 'expertise.id', '=', 'tasks.expertise_id')
                                            ->select('tasks.name as name', 'project.number as p_number', 'tasks.id as id', 'tasks.type as type', 'project.name as p_name', 'tasks.start_date as start_date', 'tasks.end_date as end_date', 'expertise.sigla as e_sigla', 'phases.sigla as ph_sigla', 'project.id as p_id', DB::raw('"operations" as taskType'))
                                            ->where('tasks.user_id', Auth::user()->id)
                                            ->union($commercialTasks)
                                            ->get();

                foreach($tasksPercentage as $key => $task) {
                  if($task->taskType == 'operations') {
                    $task_timer = \App\TaskTimer::where('programmedTask_id', $task->id)
                                               ->orderBy('id', 'desc')
                                               ->first();
                  } else {
                    $task_timer = \App\Commercial_Executed_Task::where('plannedTask_id', $task->id)
                                                               ->orderBy('id', 'desc')
                                                               ->first();
                  }
                  if($task_timer == null) {
                      if($task->type == '6') {
                        $task->done = 0;
                      } else {
                        $tasksPercentage->forget($key);
                      }
                  } else if($task_timer->done == 100) {
                      $tasksPercentage->forget($key);
                  } else
                      $task->done = $task_timer->done;
                }
                $tasksPercentage = $tasksPercentage->values();

                $tasksPercentage = $tasksPercentage->sortByDesc(function($task, $key) {
                    if($task['done'] != 100)
                      return $task['done'];
                    else 
                      return -1;
                });

                $tasksPercentageNumber = $tasksPercentage->count();

                View::share('tasksPercentageNumber', $tasksPercentageNumber);
                View::share('tasksPercentage', $tasksPercentage);

                $hoursApproval = \App\TaskTimer::where('approved', '==', 0)->where('userToApprove', Auth::user()->id)->get();

                View::share('hoursApprovalList', $hoursApproval);

                if(Auth::user()->type == 2)
                  $absenceApproval = \App\AbsenceEvent::where('approved', '==', 0)->get();
                else
                  $absenceApproval = collect([]);

                View::share('absenceApprovalList', $absenceApproval);

                $notificationNumber = $absenceApproval->count() + $hoursApproval->count();
                View::share('notificationNumber', $notificationNumber);
            }

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
