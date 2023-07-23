<?php

namespace App\Http\Controllers;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Queries;
use App\Visitagent;
use Carbon\Carbon;
use DB;
class ChartController extends Controller
{
    public function index(){}



    public function countPayment()
    {
        $start =  request('fromdate').' 00:00:00 ';
        $end   =    request('enddate').' 23:59:59';
        $date = Carbon::today()->subDays(7);
            $payment = DB::table('crm_payment_pending_issues')
            ->select(DB::raw('count(*) as total, created_at'))
            ->whereBetween('created_at', [$start, $end])
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get();
          
       $finalData = [];
       $one = [];
       array_push($one, "Date", "requests");
       array_push($finalData, $one);
       foreach($payment as $k=>$value){
       $date = date('d F', strtotime($value->created_at));
       $total = $value->total;
       $temp = [];
       array_push($temp, $date, $total);
       array_push($finalData, $temp);

       }

       $payment = json_encode($finalData);
       return $payment;


    }


    public function countAgent()
    {
        $start =  request('fromdate').' 00:00:00 ';
        $end   =    request('enddate').' 23:59:59';
            $date = Carbon::today()->subDays(7);
            $visitagents = DB::table('crm_visitagents')
            ->select(DB::raw('count(*) as total, created_at'))
            ->whereBetween('created_at', [$start, $end])
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get();

            $finalData = [];
            $one = [];
            array_push($one, "Date", "request");
            array_push($finalData, $one);
            
            foreach($visitagents as $k=> $value){
                $date = date('d F', strtotime($value->created_at));
                $total = $value->total;
                $temp = [];
                array_push($temp, $date, $total);
                array_push($finalData, $temp); 
            }
            $agentdata =  json_encode($finalData);
                return $agentdata;
    }


    public function countbankaccount()
    {
        $start =  request('fromdate').' 00:00:00 ';
        $end   =    request('enddate').' 23:59:59';
        $date = Carbon::today()->subDays(7);
        $bankchange = DB::table('crm_bank_account_changes')
        ->selectRaw('count(*) as total, created_at')
        ->whereBetween('created_at', [$start, $end])
        ->groupBy(DB::raw("DATE(created_at)"))
        ->get();

        $finalData = [];
        $one = [];
        array_push($one, "Date", "request");
        array_push($finalData, $one);
        
        foreach($bankchange as $k=> $value){
            $date = date('d F', strtotime($value->created_at));
            $total = $value->total;
            $temp = [];
            array_push($temp, $date, $total);
            array_push($finalData, $temp); 
        }
        $bankdata =  json_encode($finalData);
            return $bankdata;
    }




    public function outboundCount()
    {
        $start =  request('fromdate').' 00:00:00 ';
        $end   =    request('enddate').' 23:59:59';
        $date = Carbon::today()->subDays(7);
        $finalData =[];
        $one = [];
        array_push($one, 'Date', 'Contactable','Non-contactable');
        array_push($finalData,$one);
        
        $outbond = DB::table('crm_outbound_dial')
                  ->select(array(
                   DB::raw('count(*) as total, created_at'),
                   DB::raw(
                    "SUM(CASE
                        WHEN contactable = '1'THEN 1 ELSE 0 END) AS 'total_contact'"
                   ),
                   DB::raw(
                    "SUM(CASE
                        WHEN contactable = '0' THEN 1 ELSE 0 END) AS 'total_noncontact'"
                   ),

                 ))
                 ->whereBetween('created_at', [$start, $end])
                ->groupBy(DB::raw("DATE(created_at)"))
                ->get();

          
            foreach($outbond as $k=> $value){
                $date = date('d F', strtotime($value->created_at));
                $total_contact = (int)$value->total_contact;
                $total_noncontact = (int)$value->total_noncontact;
                $temp1 = [];
                array_push($temp1, $date, $total_contact,$total_noncontact);
                array_push($finalData, $temp1); 
                
            }
      
            $outbonddata =  json_encode($finalData);
            return $outbonddata;
    }

    public function escalationCount()
    {
        $start =  request('fromdate').' 00:00:00 ';
        $end   =    request('enddate').' 23:59:59';
        $date = Carbon::today()->subDays(7);
        $finalData =[];
        $one = [];
        array_push($one, 'Date', 'Resolved Issues','Pending Issues');
        array_push($finalData,$one);
        $escalation = DB::table('crm_queries')
                    ->select(array(
                        DB::raw('count(*) as total, created_at'),
                        DB::raw(
                        "SUM(CASE
                            WHEN is_callback_issue_resolved = '1' AND mark_callback = '1' THEN 1 ELSE 0 END) AS 'total_complete'"
                        ),
                        DB::raw(
                        "SUM(CASE
                            WHEN is_callback_issue_resolved = '0' AND mark_callback = '1' THEN 1 ELSE 0 END) AS 'total_incomplete'"
                        ),

                           ))
                    ->whereBetween('created_at', [$start, $end])
                    ->groupBy(DB::raw("DATE(created_at)"))
                    ->get();
    
                    foreach($escalation as $k=> $value){
                        $date = date('d F', strtotime($value->created_at));
                        $total_complete = (int)$value->total_complete;
                        $total_incomplete = (int)$value->total_incomplete;
                        $temp = [];
                        array_push($temp, $date, $total_complete,$total_incomplete);
                        array_push($finalData, $temp); 
                        
                    }
              
                    $escalationdata =  json_encode($finalData);
                    return $escalationdata;
    }


      public function countComplaint()
      {
        $start =  request('fromdate').' 00:00:00 ';
        $end   =    request('enddate').' 23:59:59';
       //  $date = Carbon::today()->subDays(7);
        $complaint = DB::table('crm_rc_status')
        ->leftJoin('crm_queries', 'crm_queries.sub_category_id', '=', 'crm_rc_status.id')
        ->select(array(DB::raw('count(sub_category_id) as sub_total,sub_category_id,DATE_FORMAT(created_at, "%d %M") as cd'),
                DB::raw('sub_status_name as sub_name')
        ))
        ->whereBetween('created_at', [$start, $end])
        ->where('crm_queries.category_id', '=', 2)
        ->groupBy('crm_queries.sub_category_id')
        ->groupBy(DB::raw("DATE(created_at)"))
        ->get();
     
       $complaintlist = DB::table('crm_rc_status')
                       ->select('sub_status_name as complaintslist')
                       ->where('status_id', '=', 2)
                       ->get();
     $compList = [];
        foreach($complaintlist as $key => $value){
            $compList[$value->complaintslist] = 0;
        }            
      //  $starter_date = Carbon::today();
      $today =  request('enddate');
      $lastweek = request('fromdate');
        $period = CarbonPeriod::create($lastweek, $today);

    $listArray1 = [];
    $listArray = [];
    foreach ($period as $key => $value) {
    
       $listArray1[date_format($value,"d F")] = $compList;
       $listArray1[date_format($value,"d F")]['date'] = date_format($value,"d F");     
       $listArray[date_format($value,"d F")] = array_reverse($listArray1[date_format($value,"d F")]);
    }
 
      if(count($complaint)){
          foreach($complaint as $key=> $value){
            
            $listArray[$value->cd][$value->sub_name] = $value->sub_total;
          }
      }
      $list = [];
      if(count($listArray)){
          $i=0;
          foreach($listArray as $key=> $value){
            $i++;
          //  dd($value);
                if(!isset($list[0])){
                    foreach($value as $k1=>$v1){
                        $list[0][] = $k1;
                  }
                }

                foreach($value as $k1=>$v1){
                    $list[$i][] = $v1;
              }
          }
      }
    //  dd($list);

          $complaintData = json_encode($list);
           return $complaintData;

      }

     public function countQuery()
     {
        $start =  request('fromdate').' 00:00:00 ';
        $end   =    request('enddate').' 23:59:59';
       // $date = Carbon::today()->subDays(7);
        $complaint = DB::table('crm_rc_status')
        ->leftJoin('crm_queries', 'crm_queries.sub_category_id', '=', 'crm_rc_status.id')
        ->select(array(DB::raw('count(sub_category_id) as sub_total,sub_category_id,DATE_FORMAT(created_at, "%d %M") as cd'),
                DB::raw('sub_status_name as sub_name')
        ))
        ->whereBetween('created_at', [$start, $end])
        ->where('crm_queries.category_id', '=', 1)
        ->groupBy('crm_queries.sub_category_id')
        ->groupBy(DB::raw("DATE(created_at)"))
        ->get();
     
       $complaintlist = DB::table('crm_rc_status')
                       ->select('sub_status_name as complaintslist')
                       ->where('status_id', '=', 1)
                       ->get();
     $compList = [];
        foreach($complaintlist as $key => $value){
            $compList[$value->complaintslist] = 0;
        }            
   
      //  $starter_date = Carbon::today();
    //  dd($start);
        $today =  request('enddate');
        $lastweek = request('fromdate');
        $period = CarbonPeriod::create($lastweek, $today);

    $listArray1 = [];
    $listArray = [];
    foreach ($period as $key => $value) {
    
       $listArray1[date_format($value,"d F")] = $compList;
       $listArray1[date_format($value,"d F")]['date'] = date_format($value,"d F");     
       $listArray[date_format($value,"d F")] = array_reverse($listArray1[date_format($value,"d F")]);
    }
 
      if(count($complaint)){
          foreach($complaint as $key=> $value){
            
            $listArray[$value->cd][$value->sub_name] = $value->sub_total;
          }
      }
      $list = [];
      if(count($listArray)){
          $i=0;
          foreach($listArray as $key=> $value){
            $i++;
           
                if(!isset($list[0])){
                    foreach($value as $k1=>$v1){
                        $list[0][] = $k1;
                  }
                }

                foreach($value as $k1=>$v1){
                   
                    $list[$i][] = $v1;
                   
              }
          }
      }
   

          $queryData = json_encode($list);
           return $queryData;
     }

}


