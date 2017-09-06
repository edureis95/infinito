<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project_General_User_Function extends Model
{
    use SoftDeletes;
    protected $table = 'project_general_user_function';
}
