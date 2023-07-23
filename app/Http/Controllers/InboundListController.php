<?php

namespace App\Http\Controllers;

use Auth;
use JWTAuth;
use App\User;
use App\Escalation;
use App\Http\Requests\RegisterFormRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InboundListController extends Controller
{
    public function index()
    {
        
        // $tasks = Escalation::orderBy(request('sortBy'),request('order'))->join('admin_users', 'admin_users.id', '=', 'crm_queries.user_id')->select('admin_users.name');

        $tasks = Escalation::join('admin_users', 'admin_users.id', '=', 'crm_queries.user_id')
            ->join("crm_rc_status",function($join){
            	$join->on("crm_rc_status.status_id","=","crm_queries.category_id")
            		 ->on("crm_rc_status.id","=","crm_queries.sub_category_id");})
            ->select('crm_queries.*', 'crm_rc_status.status_name as category_name', 'crm_rc_status.sub_status_name as sub_category_name', 'admin_users.name as agent_name')
            ->orderBy(request('sortBy'),request('order'));

        return $tasks->paginate(request('pageLength'));

    }

    public function inBoundSearch(){
        $start =  request('fromdate').' 00:00:00';
        $end   =  request('enddate').' 23:59:59';
        $tasks = Escalation::join('admin_users', 'admin_users.id', '=', 'crm_queries.user_id')
        ->join("crm_rc_status",function($join){
            $join->on("crm_rc_status.status_id","=","crm_queries.category_id")
                 ->on("crm_rc_status.id","=","crm_queries.sub_category_id");})
        ->select('crm_queries.*', 'crm_rc_status.status_name as category_name', 'crm_rc_status.sub_status_name as sub_category_name', 'admin_users.name as agent_name')
        ->whereBetween('crm_queries.created_at', [$start, $end]);
        return $tasks->paginate(request('pagelength'));

    }

    public function inBoundExport(){
        $start =  request('fromdate').' 00:00:00 ';
        $end   =    request('enddate').' 23:59:59';
        $data =  Escalation::join('admin_users', 'admin_users.id', '=', 'crm_queries.user_id')
        ->join("crm_rc_status",function($join){
            $join->on("crm_rc_status.status_id","=","crm_queries.category_id")
                 ->on("crm_rc_status.id","=","crm_queries.sub_category_id");})
        ->select('crm_queries.*', 'crm_rc_status.status_name as category_name', 'crm_rc_status.sub_status_name as sub_category_name', 'admin_users.name as agent_name')
        ->whereBetween('crm_queries.created_at', [$start, $end])->get();
        $name = 'inbound'.time().'.csv';
        $header = ["created_at","name","phone","utr_upi","category_name","sub_category_name","issue_date_from","issue_date_to","description_form","agent_name"];
        createCSV($header,$data,$name);
        $url = url('storage/'.$name.'.zip');
        return  $url ;
    }

}

