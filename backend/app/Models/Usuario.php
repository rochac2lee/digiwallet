<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $guarded = [];

    protected $hidden = ['senha'];
}
