<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact_Source extends Model
{
    use SoftDeletes;
    protected $table = "contact_sources";
}
