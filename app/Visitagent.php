<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitagent extends Model
{
    protected $table = 'crm_visitagents';
    protected $fillable = [
        'name', 'phone', 'address', 'landmark','state', 'city', 'terms_condition'
    ];
}
