<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchantRevisit extends Model
{
    protected $table = 'crm_merchant_revisits';
    protected $fillable = ['agent_phone','merchant_phone','merchant_problem','loan_cashback','app_feature','merchant_satisfied','accept_payment','merchant_city','scan_app','scan_qr'];
}
