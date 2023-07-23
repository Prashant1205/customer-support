<?php

namespace App\Http\Controllers;

use Auth;
use JWTAuth;
use App\User;
use App\Escalation;
use App\Http\Requests\RegisterFormRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EscalationController extends Controller
{
    public function index()
    {
        // $alldata = Escalation::paginate(5);
        //  return response()->json(["alldata"=>$alldata]);

        $tasks = Escalation::where('mark_callback','=', 1)->where('is_callback_issue_resolved','=', request('issue_status'));


        $tasks->orderBy(request('sortBy'),request('order'));

        return $tasks->paginate(request('pageLength'));

    }

    public function countEscalation()
    {
        $complete_counts = Escalation::where('is_callback_issue_resolved','=', 1)->where('mark_callback','=', 1)->get();
        $complete_count = $complete_counts->count();
        $incomplete_counts = Escalation::where('is_callback_issue_resolved','=', 0)->where('mark_callback','=', 1)->get();
        $incomplete_count = $incomplete_counts->count();
        return response()->json(compact('complete_count','incomplete_count'));
    }

    public function toggleStatus(Request $request){

        $task = Escalation::find($request->input('id'));

        if(!$task)
            return response()->json(['response' => 'failed', 'message' => 'Couldnot find task!'],422);

        $task->is_callback_issue_resolved = !$task->is_callback_issue_resolved;
        $task->callback_issue_resolved_date = date("Y-m-d H:i:s");
        $task->save();
        //print_r($task);

        return response()->json(['response' => 'success', 'message' => 'Task updated!']);
    }

    public function escalationSearch(){
        $start =  request('fromdate');
        $end   =  request('enddate');
        if(request('tabvalue') == 'incompleted'){
            $tasks = Escalation::where('mark_callback','=', 1)->where('is_callback_issue_resolved','=',0)->whereBetween('created_at', [$start, $end]);
            return $tasks->paginate(request('pageLength'));
        }
        if(request('tabvalue')== 'completed'){
            $tasks = Escalation::where('mark_callback','=', 1)->where('is_callback_issue_resolved','=',1)->whereBetween('created_at', [$start, $end]);
            return $tasks->paginate(request('pageLength'));
        }
            
    }

    public function escalationExport(){
        $start =  request('fromdate').' 00:00:00 ';
        $end   =    request('enddate').' 23:59:59';
        $tabType = request('tabvalue');

        $header = ["name","phone","utr_upi","description_form","created_at","issue_date_from","issue_date_to"];
        if($tabType == 'incompleted'){
          $data =  Escalation::where('mark_callback','=', 1)->where('is_callback_issue_resolved','=',0)->whereBetween('created_at', [$start, $end])->get();
          $name = 'incompleted'.time().'.csv';
            createCSV($header,$data,$name);
        }

        if($tabType == 'completed'){
          $data =  Escalation::where('mark_callback','=', 1)->where('is_callback_issue_resolved','=',1)->whereBetween('created_at', [$start, $end])->get();
          $name = 'completed'.time().'.csv';
            createCSV($header,$data,$name);
        }
        $url = url('storage/app/'.$name.'.zip');
        return  $url ;
    }
}

