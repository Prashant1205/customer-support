<?php
namespace App;
use DB;
use Eloquent;

class Outbound extends Eloquent {

	protected $fillable = [
	    'user_id',
        'phone',
        'problem_id',
        'satisfied',
        'ready',
        'contactable',
        'remarks',];

	protected $primaryKey = 'id';

	protected $table = 'crm_outbound_dial';

}
