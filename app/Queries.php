<?php
namespace App;
use DB;
use Eloquent;

class Queries extends Eloquent {

	protected $fillable = [

                    'user_id',
                    'name',
                    'phone',
                    'category_id',
                    'sub_category_id',
                    'issue_date_from',
                    'issue_date_to',
                    'utr_upi',
                    'send_sms',
                    'google_form_id',
                    'payement_team',
                    'backend_team',
                    'description_form',
                    'mark_callback',
                    'is_time_out'
						];
	protected $primaryKey = 'id';
	protected $table = 'crm_queries';

    public static  function getDetails($phone){
        $results  = DB::select('SELECT 
                                    cq.name as customer_name,
                                    cq.phone as customer_phone,
                                    u.name,
                                    crs.status_name,
                                    crs.sub_status_name,
                                    crs.description as remarks,
                                    cq.description_form,
                                    date_format(cq.created_at,"%d %M %Y %H:%i:%s") as created_at 
                                    FROM 
                                    `crm_queries` cq 
                                    LEFT join crm_rc_status crs on crs.status_id = cq.category_id 
                                    and crs.id = cq.sub_category_id
                                    left join admin_users u on u.id= cq.user_id
                                    WHERE cq.phone = :phone order by cq.id desc',['phone'=>$phone]);
        return $results;
    }

}
