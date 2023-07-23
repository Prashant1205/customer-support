<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use JWTAuth;
use App\Fos;
use App\Merchant;
use App\Rcmaster;
use App\MerchantStatus;
use Helper;
use DB;
use ZipArchive;
use Maatwebsite\Excel\Facades\Excel;

class FosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request )
    {
        $requestData = $request->all();
        if(isset($requestData['status']) && $requestData['status']!=''){
            $status = $requestData['status'];
        }else{
            $status = '';
        }

        if($requestData['fromdate'] != 'Invalid date' && $requestData['enddate'] != 'Invalid date'){
            $fromDate = date('Y-m-d H:i:s',strtotime(str_replace('-','/', $requestData['fromdate'])));
            $endDate = date('Y-m-d',strtotime(str_replace('-','/', $requestData['enddate'])));
            $endDate = $endDate.' 23:59:59';
        }else{
            $fromDate = '';
            $endDate = '';
        }

        $fosLists = Fos::join('merchantbusiness', 'merchantbusiness.id', '=', 'fos_visit_details.merchant_id');
        $fosLists->leftJoin('fos_merchant_status', 'fos_merchant_status.merchant_id', '=', 'fos_visit_details.merchant_id');
        $fosLists->join('agent', 'agent.ReferralCode', '=', 'merchantbusiness.referralcode');
        $fosLists->select('fos_visit_details.*', 'merchantbusiness.merchantname as merchant_name',
            'merchantbusiness.businessname as business_name','merchantbusiness.status as status',
            'merchantbusiness.merchantaddress as address','merchantbusiness.mobile as business_phone',
            'merchantbusiness.merchantcity as merchantcity','agent.City as agent_city','agent.ReferralCode as referral_code','fos_merchant_status.reason',
            'fos_merchant_status.comment'
        );
        $fosLists->groupBy('merchantbusiness.id');
        if($requestData["phone"] != ""){
            $fosLists->where('merchantbusiness.phonenumber', $requestData['phone']);
        }
        if($status != ''){
            $fosLists->where('merchantbusiness.status',$status);
        }
        if($requestData["city"] != ""){
           $fosLists->where('merchantcity', $requestData['city']);
       }
        if($fromDate != '' && $endDate !=''){
            $fosLists->whereBetween('fos_visit_details.created_at', [$fromDate, $endDate]);
        }
        $fosLists->whereIn('fos_visit_details.key_id',[31,32,33]);
        $fosLists->orderBy(request('sortBy'),request('fos_visit_details.created_at'));


        return $fosLists->paginate(request('pageLength'));



    }

    /**
     * Show the S3 bucket Images.
     *
     * @return \Illuminate\Http\Request
     */
    public function getFosImages(request $request)
    {   
        $merchantdata = Merchant::where('id','=',$request['file'])->get();
        $merchantImages =DB::table('fos_visit_details')
                        ->join('fos_rc_master','fos_visit_details.key_id','=','fos_rc_master.key_id')
                        ->select('fos_visit_details.key_value','fos_visit_details.key_id','fos_rc_master.text')
                        ->where('fos_visit_details.merchant_id',$request['file'])
                        ->whereBetween('fos_visit_details.key_id',[31,33])
                        ->get();


        $imageList = [];
        foreach($merchantImages as $key => $image){
            $imageList[$key]= $image->text;
            $imageList['url'.$key] =  getpresignedS3Image($image->key_value);
        }
        return response()->json(['response' => 'success', 'data' => $imageList, 'merchantdata'=>$merchantdata]);
    }

    public function updateStatus(request $request){
        $merchant_id = $request->input('id');
        $status = $request->input('status');
        $task = Merchant::where('id','=', $merchant_id)->where('status','!=','APPROVED')->first();
        if(!$task)
            return response()->json(['response' => 'failed', 'message' => 'Could not find merchant!'],422);
        $task->status = $status;
        $task->save();
        return response()->json(['response' => 'success', 'message' => 'Merchant status updated successfully!']);

    }

    public function updaterejectStatus(request $request){
        $merchant_id = $request->input('id');
        $status = $request->input('status');
        $reason = $request->input('reason');
        $comment = $request->input('comment');
       
        if($comment != '' && $reason != ''){
            $task = Merchant::where('id','=', $merchant_id)->where('status','!=','REJECTED')->first();
            if(!$task)
                return response()->json(['response' => 'failed', 'message' => 'Could not find merchant!'],422);
            $task->status = $status;
            $task->save();
            $merchantstatus =  new MerchantStatus();
            $merchantstatus->merchant_id = $merchant_id;
            $merchantstatus->reason = $reason;
            $merchantstatus->comment = $comment;
            $merchantstatus->save();
            return response()->json(['response' => 'success', 'message' => 'Merchant status updated successfully!']);
        }else
        {
            return response()->json(['response' => 'failed', 'message' => 'All Fields Are Require!'],422);
        }
        

    }
    
    //function to download merchant images as zip file
    public function getMerchantImages(request $request){

        $merchantImages =DB::table('fos_visit_details')
                        ->join('fos_rc_master','fos_visit_details.key_id','=','fos_rc_master.key_id')
                        ->select('fos_visit_details.key_value','fos_visit_details.key_id','fos_rc_master.text')
                        ->where('fos_visit_details.merchant_id',$request->input('id'))
                        ->whereBetween('fos_visit_details.key_id',[31,33])
                        ->get();
        
        $imageList = [];
        foreach($merchantImages as $key => $image){
            $imageList[$key] =  getImageFromFosVal($image->key_value);
            $imageList['name'.$key] = explode('/',$image->key_value)[1];
        }
        $path = storage_path();
        $zipFileName = time().'MerchantImages.zip';
        $zip = new ZipArchive();
        $filetopath = $path. '/' . $zipFileName;
        $zip->open($filetopath, ZipArchive::CREATE);

        foreach ($imageList as $key=> $value){
            if($value != ''){
                $zip->addFile($path . '/app/merchant-photos/' . $value, $value);
            }
        }
        $zip->close();
  
        if(file_exists($filetopath)){
          return env('APP_URL').'/files/'.$zipFileName;
        }
        return "File Doesn't exit!!!";
    }

    public function getCityList(){

        $cityList =DB::table('sales_cities')
                        ->select('city_name')
                        ->get();

        return response()->json(['response' => 'success', 'data' => $cityList]);
        
    }

    public function fosListExport(){
        $start =  request('fromdate').' 00:00:00 ';
        $end   =  request('enddate').' 23:59:59';
        $phone = request('phone');
        $status = request('status');
        $city = request('city');
        $fosLists = Fos::join('merchantbusiness', 'merchantbusiness.id', '=', 'fos_visit_details.merchant_id');
        $fosLists->leftJoin('fos_merchant_status', 'fos_merchant_status.merchant_id', '=', 'fos_visit_details.merchant_id');
        $fosLists->join('agent', 'agent.ReferralCode', '=', 'merchantbusiness.referralcode');
        $fosLists->select('fos_visit_details.*', 'merchantbusiness.merchantname as merchant_name',
            'merchantbusiness.businessname as business_name','merchantbusiness.status as status',
            'merchantbusiness.merchantaddress as address','merchantbusiness.mobile as business_phone',
            'merchantbusiness.merchantcity as merchantcity','agent.City as agent_city','agent.ReferralCode as referral_code','fos_merchant_status.reason',
            'fos_merchant_status.comment'
        );
        $fosLists->groupBy('merchantbusiness.id');
        if($phone != ""){
            $fosLists->where('merchantbusiness.phonenumber', $phone);
        }
        if($status != ''){
            $fosLists->where('merchantbusiness.status',$status);
        }
        if($city != ""){
           $fosLists->where('merchantcity', $city);
       }
        if($start != '' && $end !=''){
            $fosLists->whereBetween('fos_visit_details.created_at', [$start, $end]);
        }
        $data = $fosLists->whereIn('fos_visit_details.key_id',[31,32,33])->get();
        
        //print_r($fosLists->get()); die;
        $name = 'fosList'.time().'.csv';
        $header = ["created_at","business_name","merchant_name","business_phone","referral_code","merchantcity","view image","reason","comment","status"];
        createCSV($header,$data,$name);
        $url = url('storage/'.$name.'.zip');
        return  $url ;
    }

}