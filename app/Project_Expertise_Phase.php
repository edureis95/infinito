<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project_Expertise_Phase extends Model
{
    use SoftDeletes;
    protected $table = "project_expertise_phases";
}
