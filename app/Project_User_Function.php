<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project_User_Function extends Model
{
    use SoftDeletes;
    protected $table = 'project_user_function';
}
