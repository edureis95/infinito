<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_Memory extends Model
{
    use SoftDeletes;

    protected $table = "users_memory";
}
