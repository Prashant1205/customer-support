<?php

namespace App;

use Eloquent;

class QuerySearch extends Eloquent
{
  protected $fillable = [

            ];
  protected $primaryKey = 'id';
  protected $table = 'crm_query_search';

  public static function getMerchantDetails($name, $phone){
      $results = DB::select('select * from users where id = ?', [1]);
    }
}
