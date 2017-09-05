<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document_Setting extends Model
{
    use SoftDeletes;

    protected $table = 'document_settings';
}
