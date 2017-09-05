<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project_Event_Type extends Model
{
	use SoftDeletes;

    protected $table = "project_event_types";
}
