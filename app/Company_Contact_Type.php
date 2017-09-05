<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company_Contact_Type extends Model
{
    use SoftDeletes;
    protected $table = 'company_contact_type';
}
