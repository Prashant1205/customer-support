<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentPendingIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_payment_pending_issues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone');
            $table->string('txn_history');
            $table->string('home_screenshot');
            $table->string('passbook');
            $table->string('date_of_transaction');
            $table->string('remark');
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
        Schema::dropIfExists('payment_pending_issues');
    }
}
