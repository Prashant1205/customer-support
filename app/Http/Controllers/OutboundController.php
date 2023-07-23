<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class OutboundController extends Controller
{
    public function store(Request $request){

        if($request->input('contactable') == 1) {
            $validation = Validator::make($request->all(), [
                'phone' => 'required:numeric',
                'contactable' => 'required:numeric',
                'problem_id' => 'required:numeric',
                'satisfied' => 'required:numeric',
                'ready' => 'required:numeric',
                'remarks' => 'required',
            ]);
        }elseif ($request->input('contactable') == 0) {
            $validation = Validator::make($request->all(), [
                'phone' => 'required:numeric',
                'contactable' => 'required:numeric',
                'remarks' => 'required',
            ]);
        }



        if($validation->fails())
        	return response()->json(['message' => $validation->messages()->first()],422);

        $user = \JWTAuth::parseToken()->authenticate();
        $query = new \App\Outbound();
        $query->fill(request()->all());
        $query->user_id = $user->id;
        $query->problem_id = (is_null($query->problem_id) || $query->problem_id=='')? 0: $query->problem_id;
        $query->satisfied = (is_null($query->satisfied) || $query->satisfied=='')? 0: $query->satisfied;
        $query->ready = (is_null($query->ready) || $query->ready=='')? 0: $query->ready;
        $query->remarks = preg_replace('/[^a-zA-Z0-9_ -]/s','',$query->remarks);
        $query->save();

        return response()->json(['message' => 'Query added!', 'data' => $query]);
    }

}
