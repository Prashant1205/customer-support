<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchantStatus extends Model
{
    protected $table = 'fos_merchant_status';
    protected $fillable = [

        'merchant_id',
        'reason',
        'comment'
            ];
}
