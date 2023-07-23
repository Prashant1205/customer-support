<?php

namespace App\Http\Controllers;
use Validator;
use Session;
use Helper;

use Zip;
use Maatwebsite\Excel\Facades\Excel;
use App\MerchantRevisit;
use App\Visitagent;
use App\BankAccountChange;
use App\PaymentPendingIssues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class FormController extends Controller
{
  public function requestForAgent(){return view('forms.request-agent');}

  public function requestForBankAccountchange(){return view('forms.request-bank-account-change');}

  public function paymentPendingissue(){return view('forms.payment-pending');}

  public function merchantRevisit(){return view('forms.revisit-merchant');}
  
    

 public function createRequestForAgent(request $request)
 {
    $rules = array (

        'name' => 'required', 
        'phone' => 'required',
        'address' => 'required',
        'landmark' => 'required',
        'state' => 'required',
        'city' => 'required'
         
        );
        
        $v = Validator::make (Input::all (), $rules);
        
        if ($v->fails()) {
         return Redirect::back ()->withErrors ( $v, '/form/request-for-agent' )->withInput ();
        
         
        } else { 
        
                $visit = new Visitagent;
                $visit->name = $request->name;
                $visit->phone = $request->phone;
                $visit->address = $request->address;
                $visit->landmark = $request->landmark;
                $visit->state = $request->state;
                $visit->city = $request->city;
                $visit->terms_condition = $request->terms;

        
           $visit->save(); 
        
        if ($visit)
        {
            Session::flash ( 'message', "your request is registered successfully" );
            return redirect::back();
        }else{
        
            return Redirect::back()->withErrors(['msg', 'something is wrong']);
        }
              }
 }

      public function createBankAccountChange(request $request)
      {
        $rules = array (

            'name' => 'required', 
            'phone' => 'required',
            'email' => 'required',
            'state' => 'required',
            'city' => 'required',
            'oldcheque' => 'required|image|mimes:jpeg,png,jpg,pdf,svg|max:2048',
            'oldidtype' => 'required',
            'oldidproof' => 'required|image|mimes:jpeg,png,jpg,pdf,svg|max:2048',
            'screenshot' => 'required|image|mimes:jpeg,png,jpg,pdf,svg|max:2048',
            'cheque' => 'required|image|mimes:jpeg,png,jpg,pdf,svg|max:2048',
            'idtype' => 'required',
            'idproof' => 'required|image|mimes:jpeg,png,jpg,pdf,svg|max:2048',
            'reason' => 'required',

             
            );
            $v = Validator::make (Input::all (), $rules);
        
            if ($v->fails()) {
              
             return Redirect::back ()->withErrors ( $v, '/form/bank-account-change' )->withInput ();
             
            }else
            
                {
                    $change = new BankAccountChange;
    
                    if ($request->hasFile('oldcheque')) {
                        $image = $request->file('oldcheque');
                        $name = str_slug($request->name).'old-acc-cheque'.'.'.$image->getClientOriginalExtension();
                        $destinationPath = public_path('/uploads');
                        $imagePath = $destinationPath. "/".  $name;
                        $filename = uploadAmazonS( $image->getPathName(),'old-acc-cheque',$image->getClientOriginalExtension());
                        $change->old_acc_cheque = $filename;
                      }

                      if ($request->hasFile('oldidproof')) {
                        $image = $request->file('oldidproof');
                        $name = str_slug($request->name).'old-acc-cheque'.'.'.$image->getClientOriginalExtension();
                        $destinationPath = public_path('/uploads');
                        $imagePath = $destinationPath. "/".  $name;
                        $filename = uploadAmazonS( $image->getPathName(),'old-acc-proof',$image->getClientOriginalExtension());
                        $change->old_acc_idproof = $filename;
                      }

                      if ($request->hasFile('cheque')) {
                        $image = $request->file('cheque');
                        $name = str_slug($request->name).'cancel-cheque'.'.'.$image->getClientOriginalExtension();
                        $destinationPath = public_path('/uploads');
                        $imagePath = $destinationPath. "/".  $name;
                        $filename = uploadAmazonS( $image->getPathName(),'cancel-cheque',$image->getClientOriginalExtension());
                        $change->cancel_cheque = $filename;
                      }
                      if ($request->hasFile('screenshot')) {
                        $image = $request->file('screenshot');
                        $name = str_slug($request->name).'existing-acc-screenshot'.'.'.$image->getClientOriginalExtension();
                        $destinationPath = public_path('/uploads');
                        $imagePath = $destinationPath. "/".  $name;
                        $filename = uploadAmazonS( $image->getPathName(),'existing-acc-screenshot',$image->getClientOriginalExtension());
                        $change->existing_acc_screenshot = $filename;
                      }
                      if ($request->hasFile('idproof')) {
                        $image = $request->file('idproof');
                        $name = str_slug($request->name).'idproof'.'.'.$image->getClientOriginalExtension();
                        $destinationPath = public_path('/uploads');
                        $imagePath = $destinationPath. "/".  $name;
                        $filename = uploadAmazonS( $image->getPathName(),'idproof',$image->getClientOriginalExtension());
                        $change->idproof = $filename;
                      }
                    $change->name = $request->name;
                    $change->phone = $request->phone;
                    $change->email = $request->email;
                    $change->state = $request->state;
                    $change->city = $request->city;
                    $change->old_acc_typeofid = $request->oldidtype;
                    $change->typeofid = $request->idtype;
                    $change->reason = $request->reason;
                    $change->terms_condition = $request->terms;

    
                    $change->save();
                    if ($change)
                        {
                            Session::flash ( 'message', "your request is registered successfully" );
                            return redirect::back();
                        }else{
                        
                            return Redirect::back()->withErrors(['msg', 'something is wrong']);
                        }
                } 
            
        }        

        public function createPaymentPendingIssue(request $request)
        {
          $rules = array (

           
            'phone' => 'required',
            'txn' => 'required|image|mimes:jpeg,png,jpg,pdf,svg|max:2048',
            'screenshot' => 'required|image|mimes:jpeg,png,jpg,pdf,svg|max:2048',
            'passbook' => 'required|image|mimes:jpeg,png,jpg,pdf,svg|max:2048',
            'dot' => 'required',
            'remark' => 'required',

             
            );
            $v = Validator::make (Input::all (), $rules);
        
            if ($v->fails()) {
             
             return Redirect::back ()->withErrors ( $v, '/form/payment-pending-issue' )->withInput ();
             
            }else
            { 
             
                  $payment = new PaymentPendingIssues;
                  if ($request->hasFile('txn')) {
                    $image = $request->file('txn');
                    $name = str_slug($request->phone).'txn-history'.'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/uploads');
                    $imagePath = $destinationPath. "/".  $name;
                    $filename = uploadAmazonS($image->getPathName(),'txn',$image->getClientOriginalExtension());
                    $payment->txn_history = $filename;
                  }
                  if ($request->hasFile('screenshot')) {
                    $image = $request->file('screenshot');
                    $name = str_slug($request->phone).'home-screenshot'.'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/uploads');
                    $imagePath = $destinationPath. "/".  $name;
                    $filename = uploadAmazonS( $image->getPathName(),'home-screenshot',$image->getClientOriginalExtension());
                    $payment->home_screenshot = $filename;
                  }

                  if ($request->hasFile('passbook')) {
                    $image = $request->file('passbook');
                    $name = str_slug($request->phone).'passbook'.'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/uploads');
                    $imagePath = $destinationPath. "/".  $name;
                    $filename = uploadAmazonS( $image->getPathName(),'passbook',$image->getClientOriginalExtension());
                    $payment->passbook = $filename;
                  }
                  
                  $payment->phone = $request->phone;
                  $payment->date_of_transaction = $request->dot;
                  $payment->remark = $request->remark;
                  $payment->terms_condition = $request->terms;
                  $payment->save();
                  if ($payment)
                      {
                          Session::flash ( 'message', "your request is registered successfully" );
                          return redirect::back();
                      }else{
                      
                          return Redirect::back()->withErrors(['msg', 'something is wrong']);
                      }
           }

        }
         

        public function createMerchantRevisit(request $request)
        {
          $rules = array (

            'agentphone' => 'required', 
            'merchantphone' => 'required',
            'merchantproblem' => 'required',
            'loancashback' => 'required',
            'appfeature' => 'required',
            'merchantsatisfied' => 'required',
            'acceptpayment' => 'required',
            'merchantcity' => 'required',
            'scanapp' => 'required',
            'scanqr' => 'required'
             
            );
            
            $v = Validator::make (Input::all (), $rules);
            
            if ($v->fails()) {
             return Redirect::back ()->withErrors ($v)->withInput();
            
             
            } else { 
                   $data = $request->merchantproblem;

                   $merchantprob = implode(",", $data);
                    $revisit = new MerchantRevisit;
                    $revisit->agent_phone = $request->agentphone;
                    $revisit->merchant_phone = $request->merchantphone;
                    $revisit->merchant_problem = $merchantprob;
                    $revisit->loan_cashback = $request->loancashback;
                    $revisit->app_feature = $request->appfeature;
                    $revisit->merchant_satisfied = $request->merchantsatisfied;
                    $revisit->accept_payment = $request->acceptpayment;
                    $revisit->merchant_city = $request->merchantcity;
                    $revisit->scan_app = $request->scanapp;
                    $revisit->scan_qr = $request->scanqr;

    
            
               $revisit->save(); 
            
            if ($revisit)
            {
                Session::flash ( 'message', "your request is registered successfully" );
                return redirect::back();
            }else{
            
                return Redirect::back()->withErrors(['msg', 'something is wrong']);
            }
                  }

        }


        public function visitAgentList()
        {
        $visitagentlist = Visitagent::orderBy(request('sortBy'),request('order'));
        return $visitagentlist->paginate(request('pageLength'));
        }

        public function paymentPendingList()
        {
            $PaymentPending = PaymentPendingIssues::orderBy(request('sortBy'),request('order'));
            return $PaymentPending->paginate(request('pageLength'));
        }
        
        public function bankAccountChangelist()
        {
            $bankchange = BankAccountChange::orderBy(request('sortBy'),request('order'));
            return $bankchange->paginate(request('pageLength'));
        }
         public function merchantRevisitList()
        {
            $merchantrevisit = MerchantRevisit::orderBy(request('sortBy'),request('order'));
            return $merchantrevisit->paginate(request('pageLength'));
        }
        public function getImageFromS(Request $request){
          $data =  getImageFromS($request); //helper
          $url = url($request->file);
          return response()->json(['response' => 'success', 'file' => $url]);          
    
        }

        public function thanks(){
          return view('forms.thanks');
      }
      public function dataSearch(){

        $start =  request('fromdate').' 00:00:00 ';
        $end   =    request('enddate').' 23:59:59';
        $tabType = request('tabvalue');

        if ($tabType == 'agent'){
          $data =  Visitagent::whereBetween('created_at', [$start, $end]);
          return $data->paginate(request('pagelength'));
        }
        
        if($tabType == 'payment'){
          $data =  PaymentPendingIssues::whereBetween('created_at', [$start, $end]);
          return $data->paginate(request('pagelength'));
        }

        if($tabType == 'bank'){
          $data =  BankAccountChange::whereBetween('created_at', [$start, $end]);
          return $data->paginate(request('pagelength'));
        }

        if($tabType == 'merchant'){
          $data =  MerchantRevisit::whereBetween('created_at', [$start, $end]);
          return $data->paginate(request('pagelength'));
        }
        
        
    }

    //  public function dataEx()
    //     {

    //       $start =  request('fromdate');
    //       $end   =    request('enddate');
    //       $tabType = request('tabvalue');
    //       if ($tabType == 'agent'){
    //       $data =  Visitagent::whereBetween('created_at', [$start, $end])->get();
          
    //       $name = 'agent'.time().'.xlsx';
        
    //       Excel::store($data, 'users.xlsx');

    //      echo $url = url('storage/users.xlsx');
    //       return $name;   
    //       }
          
    //   }

      public function dataExport(){

        $start =  request('fromdate').' 00:00:00 ';
        $end   =    request('enddate').' 23:59:59';
        $tabType = request('tabvalue');

        if ($tabType == 'agent'){
          $header = ["name", "phone", "address", "landmark", "state", "city", "created_at"];
          $data =  Visitagent::whereBetween('created_at', [$start, $end])->get();
          $name = 'agent'.time().'.csv';
          createCSV($header,$data,$name);
          $url = url('storage/'.$name.'.zip');
          return  $url ;
        }
        
        if($tabType == 'payment'){
          $header = ["phone", "txn_history", "home_screenshot", "passbook","date_of_transaction", "remark", "created_at"];
          $data =  PaymentPendingIssues::whereBetween('created_at', [$start, $end])->get();
          $name = 'payment'.time().'.csv';
          createCSV($header,$data,$name);
          $url = url('storage/'.$name.'.zip');
          return  $url ;
        }

        if($tabType == 'bank'){
          $header = ["name", "phone", "email", "state", "city", "old_acc_cheque", "old_acc_typeofid", "old_acc_idproof", "cancel_cheque", "typeofid", "idproof", "existing_acc_screenshot", "reason", "created_at"];
          $data =  BankAccountChange::whereBetween('created_at', [$start, $end])->get();
          $name = 'bank'.time().'.csv';
          createCSV($header,$data,$name);
          $url = url('storage/'.$name.'.zip');
          return  $url ;
        }

        if($tabType == 'merchant'){
          $header = ["agent_phone", "merchant_phone", "merchant_problem", "loan_cashback","app_feature", "merchant_satisfied", "accept_payment", "merchant_city", "scan_app", "scan_qr", "created_at"];
          $data =  MerchantRevisit::whereBetween('created_at', [$start, $end])->get();
          // foreach($data as $value){
          //   print_r($value['merchant_problem']); 
          // }die;
          $name = 'merchant'.time().'.csv';
          createCSV($header,$data,$name);
          $url = url('storage/'.$name.'.zip');
          return  $url ;
        }
        
        
    }

    public function dataExportZip(){

      $tabType = request('tabvalue');
      $id = request('id');
     
      if($tabType == 'paymentpending'){
        $data =  PaymentPendingIssues::where('id', $id)->get();
        $fileList = ['txn_history','home_screenshot','passbook'];
        foreach ($fileList as $key=>$value){
            getImageFromSval($data[0]->$value);
        }

        $path = storage_path();
  
        $zipFileName = time().'AllDocuments.zip';

        $zip = new ZipArchive();
        $filetopath = $path. '/' . $zipFileName;
        $zip->open($filetopath, ZipArchive::CREATE);
          $fileList = [
              'txn_history'=>'txn_history.jpg',
              'home_screenshot'=>'home_screenshot.jpg',
              'passbook'=>'passbook.jpg'
          ];
          foreach ($fileList as $key=> $value){
              if($data[0]->$key != '' && file_exists($path . '/app' . $data[0]->$key)){
                  $zip->addFile($path . '/app' . $data[0]->$key, $value);
              }
          }
        $zip->close();

        if(file_exists($filetopath)){
          return env('APP_URL').'/files/'.$zipFileName;
        }
        return "File Doesn't exit!!!";

      }

      if($tabType == 'bankaccount'){
        $data =  BankAccountChange::where('id', $id)->get();

          $fileList = ['old_acc_cheque','cancel_cheque','existing_acc_screenshot','old_acc_typeofid','old_acc_idproof'];
          foreach ($fileList as $key=>$value){
              getImageFromSval($data[0]->$value);
          }
        $path = storage_path();
        $zipFileName = time().'AllBankDocuments.zip';
        $filetopath = $path. '/' . $zipFileName;

        $zip = new ZipArchive();
 
        $zip->open($filetopath, ZipArchive::CREATE);

        $fileList = [
            'old_acc_cheque'=>'old_acc_cheque.jpg',
            'cancel_cheque'=>'cancel_cheque.jpg',
            'existing_acc_screenshot'=>'existing_acc_screenshot.jpg',
            'old_acc_typeofid'=>'old_acc_typeofid.jpg',
            'old_acc_idproof'=>'old_acc_idproof.jpg',

            ];
        foreach ($fileList as $key=> $value){
            if($data[0]->$key != '' && file_exists($path . '/app' . $data[0]->$key)){
                $zip->addFile($path . '/app' . $data[0]->$key, $value);
            }
        }

        $zip->close();
          if(file_exists($filetopath)){
              return env('APP_URL').'/files/'.$zipFileName;
          }
        return "No file found !";

      }

    }


    public function toggleStatus(Request $request){

        $tabType = request('tabvalue');
        $id = request('id');

        if ($tabType == 'agent'){

          $data =  Visitagent::find($id);
          if(!$data)
            return response()->json(['res' => 'failed', 'message' => 'Couldnot find task!'],422);

          $data->is_issue_resolved = !$data->is_issue_resolved;
          $data->save();

          return  response()->json(['res' => 'success', 'message' => 'Task updated!']);
        }
        
        if($tabType == 'payment'){
          $data =  PaymentPendingIssues::find($id);
          if(!$data)
            return response()->json(['res' => 'failed', 'message' => 'Couldnot find task!'],422);

          $data->is_issue_resolved = !$data->is_issue_resolved;
          $data->save();

          return  response()->json(['res' => 'success', 'message' => 'Task updated!']);
        }

        if($tabType == 'bank'){
          $data =  BankAccountChange::find($id);
          if(!$data)
            return response()->json(['res' => 'failed', 'message' => 'Couldnot find task!'],422);

          $data->is_issue_resolved = !$data->is_issue_resolved;
          $data->save();

          return  response()->json(['res' => 'success', 'message' => 'Task updated!']);
        }

        if($tabType == 'merchant'){
          $data =  BankAccountChange::find($id);
          if(!$data)
            return response()->json(['res' => 'failed', 'message' => 'Couldnot find task!'],422);

          $data->is_issue_resolved = !$data->is_issue_resolved;
          $data->save();

          return  response()->json(['res' => 'success', 'message' => 'Task updated!']);
        }

        return response()->json(['res' => 'failed', 'message' => 'Couldnot find!']);
    }



}


