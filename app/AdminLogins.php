<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminLogins extends Model
{
    protected $table = 'admin_logins'; 
    protected $fillable = ['agent_id', 'useragent_uri', 'request_uri', 'agent_ip'];
}
