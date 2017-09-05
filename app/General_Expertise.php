<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class General_Expertise extends Model
{
    use SoftDeletes;
    protected $table = 'general_expertise';
}
