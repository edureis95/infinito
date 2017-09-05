<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project_Details extends Model
{
    use SoftDeletes;

    protected $table = 'project_details';
}
