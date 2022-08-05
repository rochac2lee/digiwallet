<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fluxo extends Model
{
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'recorrencia' => 'boolean',
    ];
}
