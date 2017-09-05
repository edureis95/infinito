<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commercial_Project_Client extends Model
{
    use SoftDeletes;
    protected $table = 'commercial_project_client';
}
