<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Helper;

class QueryController extends Controller
{
    

	public function index(){return [];
		$tasks = \App\Task::whereNotNull('id');

		if(request()->has('title'))
			$tasks->where('title','like','%'.request('title').'%');

        if(request()->has('status'))
            $tasks->whereStatus(request('status'));

        $tasks->orderBy(request('sortBy'),request('order'));

		return $tasks->paginate(request('pageLength'));
	}

    public function store(Request $request){

        $validation = Validator::make($request->all(), [
//            'title' => 'required|unique:Queries',
            'name' => 'required',
            'phone' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'issue_date_from' => '',
            'issue_date_to' => '',
//            'issue_date_from' => 'date_format:Y-m-d',
//            'issue_date_to' => 'date_format:Y-m-d|after_or_equal:issue_date_from',
            'utr_upi' => '',
            'send_sms' => '',
            'google_form_id' => '',
            'payement_team' => '',
            'backend_team' => '',
            'description_form' => 'required',
            'mark_callback' => '',
            'is_time_out' => '',

        ]);

        if($validation->fails())
        	return response()->json(['message' => $validation->messages()->first()],422);

        $user = \JWTAuth::parseToken()->authenticate();
        $query = new \App\Queries();
        $query->fill(request()->all());
        //$query->uuid = generateUuid();
        $query->user_id = $user->id;

        $query->utr_upi = (is_null($query->utr_upi)?0:$query->utr_upi);
        $query->send_sms = (is_null($query->send_sms)?0:$query->send_sms);
        $query->google_form_id = (is_null($query->google_form_id)?0:$query->google_form_id);
        $query->payement_team = (is_null($query->payement_team)?0:$query->payement_team);
        $query->backend_team = (is_null($query->backend_team)?0:$query->backend_team);
        $query->mark_callback = (is_null($query->mark_callback)?0:$query->mark_callback);
        $query->issue_date_from = (($query->issue_date_from=='Invalid date')?null:$query->issue_date_from);
        $query->issue_date_to = (($query->issue_date_to=='Invalid date')?null:$query->issue_date_to);
        $query->description_form = preg_replace('/[^a-zA-Z0-9_ -]/s','',$query->description_form);
        $query->is_time_out = (int)$query->is_time_out;
        $query->save();



        return response()->json(['message' => 'Query added!', 'data' => $query]);
    }

    public function destroy(Request $request, $id){
        $task = \App\Task::find($id);

        if(!$task)
            return response()->json(['message' => 'Could not find task!'],422);

        $task->delete();

        return response()->json(['message' => 'Task deleted!']);
    }

    public function show($id){
        $task = \App\Task::whereUuid($id)->first();

        if(!$task)
            return response()->json(['message' => 'Could not find task!'],422);

        return $task;
    }

    public function update(Request $request, $id){

        $task = \App\Task::whereUuid($id)->first();

        if(!$task)
            return response()->json(['message' => 'Could not find task!']);

        $validation = Validator::make($request->all(), [
            'title' => 'required|unique:tasks,title,'.$task->id.',id',
            'description' => 'required',
            'start_date' => 'required|date_format:Y-m-d',
            'due_date' => 'required|date_format:Y-m-d|after:start_date'
        ]);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first()],422);

        $task->title = request('title');
        $task->description = request('description');
        $task->start_date = request('start_date');
        $task->due_date = request('due_date');
        $task->progress = request('progress');
        $task->save();

        return response()->json(['message' => 'Task updated!', 'data' => $task]);
    }

    public function toggleStatus(Request $request){
        $task = \App\Task::find($request->input('id'));

        if(!$task)
            return response()->json(['message' => 'Could not find task!'],422);

        $task->status = !$task->status;
        $task->save();

        return response()->json(['message' => 'Task updated!']);
    }

    public function searchDetail(Request $request){
	    $name  = $request->input('name');
	    $phone  = $request->input('phone');

        $detail = \App\Merchant::getMerchantDetails($name,$phone);

        if(!isset($detail[0]))
            return response()->json(['message' => 'Could not Detail regarding this merchant'],422);

        return response()->json($detail[0]);

    }

    public function categoryList(){
        $task = \App\Categories::distinct('status_id')->select('status_id','status_name')->get();
        if(!$task)
            return response()->json(['message' => 'Could not categories!'],422);

        return $task;
    }
    public function subCategoryList(Request $request){
        $task = \App\Categories::where('status_id', $request->input('category_id'))->get();

        if(!$task)
            return response()->json(['message' => 'Could not find sub categories!'],422);

        return $task;
    }
    public function subCategoryDesc(Request $request){
        $task = \App\Categories::where('id', $request->input('sub_category_id'))->select('description')->get();
        if(!$task)
            return response()->json(['message' => 'Could not find sub categories!'],422);
        return $task[0];

    }
    public static function googleForm(){
        $task = \App\GoogleForm::all();
        if(!$task)
            return response()->json(['message' => 'Could not find sub categories!'],422);
        return $task;

    }
    public function getCustomerHistory(Request $request){
        $phone  = $request->input('phone');

        $detail = \App\Queries::getDetails($phone);

        if(!$detail)
            return response()->json(['message' => 'Could not Detail regarding this merchant'],422);

        return response()->json($detail);

    }
    public function sendsms(Request $request){
        $phone  = $request->input('phone');
        $name  = $request->input('name');
        $formId  = $request->input('google_form_id');
	    $queryGoogleFormContent = array(
            1 => "Hi $name, \nThank you for calling at BharatPe's Helpline Number.\nYour query regarding Account Change has been noted.\nTo assist you better, as discussed over the call, kindly tap on the below link and fill the mandatory details to proceed further.\n http://bharatpe.in/bac \nTeam BharatPe",
            2 => "Hi $name, \nThank you for calling at BharatPe's Helpline Number.\nYour query regarding Payment issue has been noted.\nTo assist you better, as discussed over the call, kindly tap on the below link and fill the mandatory details to proceed further.\n http://bharatpe.in/ppi \nTeam BharatPe",
            3 => "Hi $name, \nThank you for calling at BharatPe's Helpline Number.\nYour query regarding Agent Request has been noted.\nTo assist you better, as discussed over the call, kindly tap on the below link and fill the mandatory details to proceed further.\n http://bharatpe.in/agent \nTeam BharatPe"
        );


        sendSMS($phone, $queryGoogleFormContent[$formId]);
        return response()->json([1]);
    }

}
