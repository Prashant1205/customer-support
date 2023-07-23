<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccountChange extends Model
{
   protected $table = 'crm_bank_account_changes';
   protected $fillable = ['name', 'phone', 'email', 'state', 'city', 'old_acc_cheque', 'old_acc_typeofid', 'old_acc_idproof', 'existing_acc_screenshot', 'cancel_cheque', 'typeofid', 'idproof', 'reason', 'terms_condition'];
}
