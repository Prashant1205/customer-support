<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankAccountChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_bank_account_changes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('state');
            $table->string('city');
            $table->string('old_acc_cheque');
            $table->string('old_acc_typeofid');
            $table->string('old_acc_idproof');
            $table->string('existing_acc_screenshot');
            $table->string('cancel_cheque');
            $table->string('typeofid');
            $table->string('idproof');
            $table->text('reason');
            $table->string('terms_condition');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_account_changes');
    }
}
