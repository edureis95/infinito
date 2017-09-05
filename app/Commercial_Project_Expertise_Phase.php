<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commercial_Project_Expertise_Phase extends Model
{
    use SoftDeletes;
    protected $table = 'commercial_project_expertise_phases';
}
