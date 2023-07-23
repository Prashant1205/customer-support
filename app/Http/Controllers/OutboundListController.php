<?php

namespace App\Http\Controllers;

use Auth;
use JWTAuth;
use App\User;
use App\OutboundList;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OutboundListController extends Controller
{
    public function index()
    {
       
        $tasks = OutboundList::orderBy('created_at', 'desc')->paginate(request('pageLength'));

        return $tasks;

    }

    public function outBoundSearch(){
        $start =  request('fromdate').' 00:00:00 ';
        $end   =  request('enddate').' 23:59:59';
        $data =  OutboundList::whereBetween('created_at', [$start, $end]);
        return $data->paginate(request('pagelength'));
    }

    public function exportOutbound(){
        $start =  request('fromdate').' 00:00:00 ';
        $end   =    request('enddate').' 23:59:59';
        $data =  OutboundList::whereBetween('created_at', [$start, $end])->get();
        foreach($data as $k){
            if($k['satisfied'] == 1){
                $k['satisfied'] = 'Yes';
            }else{
                $k['satisfied'] = 'No';
            }
            if($k['problem_id'] == '' || $k['problem_id'] == 0){
                $k['problem_id'] = 'Not Applicable';
            }elseif($k['problem_id'] == 1){
                $k['problem_id'] = 'Next Day Settlement';
            }elseif($k['problem_id'] == 2){
                $k['problem_id'] = 'Amount not credited yet';
            }elseif($k['problem_id'] == 3){
                $k['problem_id'] = 'QR lost/damaged';
            }elseif($k['problem_id'] == 4){
                $k['problem_id'] = 'PhonePe/Paytm team removed QR';
            }elseif($k['problem_id'] == 5){
                $k['problem_id'] = 'Transaction message late/not coming';
            }elseif($k['problem_id'] == 6){
                $k['problem_id'] = 'Not able to scan QR';
            }elseif($k['problem_id'] == 7){
                $k['problem_id'] = 'Low business';
            }elseif($k['problem_id'] == 8){
                $k['problem_id'] = 'No Problem, happy to use';
            }elseif($k['problem_id'] == 9){
                $k['problem_id'] = 'Other';
            }

            if($k['contactable'] == 1){
                $k['contactable'] = 'Yes';
            }else{
                $k['contactable'] = 'No';
            }

            if($k['ready'] == 1){
                $k['ready'] = 'Yes';
            }else{
                $k['ready'] = 'No';
            }
        }
        $name = 'outbound'.time().'.csv';
        $header = ["phone","contactable","problem_id","satisfied","ready","remarks","created_at","updated_at"];
        createCSV($header,$data,$name);
        $url = url('storage/'.$name.'.zip');
        return  $url ;
        
    }

}

