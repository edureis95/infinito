<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskTimer extends Model
{
	use SoftDeletes;
    protected $table = "task_timer";
}
