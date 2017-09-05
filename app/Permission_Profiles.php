<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission_Profiles extends Model
{
	use SoftDeletes;
    protected $table = 'permission_profiles';
}
