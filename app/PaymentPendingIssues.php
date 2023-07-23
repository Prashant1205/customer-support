<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentPendingIssues extends Model
{
    protected $table = 'crm_payment_pending_issues';
    protected $fillable = ['phone', 'txn_history', 'home_screenshot', 'passbook', 'date_of_transaction', 'remark','terms_condition'];
}
