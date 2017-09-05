<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project_Expertise extends Model
{
	use SoftDeletes;
    protected $table = "project_expertise";
}
