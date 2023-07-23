<?php

namespace App;

use DB;
use Eloquent;

class Merchant extends Eloquent
{
  protected $fillable = [

            ];
  protected $primaryKey = 'id';
  protected $table = 'merchantbusiness';
  public $timestamps = false;

  public static function getMerchantDetails($name, $phone){

      $results  = DB::table('merchantbusiness')
          ->leftJoin('agent', 'merchantbusiness.referralcode', '=', 'agent.ReferralCode')
          ->leftJoin('validate', 'validate.mobile', '=', 'merchantbusiness.mobile')
          ->where('merchantbusiness.mobile', '=', '91'.$phone)
          ->select('merchantbusiness.merchantname','merchantbusiness.businessname','merchantcity','merchantstate','merchantbusiness.upiid as upiid','settlement','merchantbusiness.referralcode','agent.Individual as agent_name','agent.City as agent_city','validate.daily_date')->get();
      return $results;

    }
}
