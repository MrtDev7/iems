<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Linode extends Model
{
    use SoftDeletes;
    protected $table = 'linode';
}

