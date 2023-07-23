<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantRevisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_merchant_revisits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('agent_phone');
            $table->string('merchant_phone');
            $table->string('merchant_problem');
            $table->string('loan_cashback');
            $table->string('app_feature');
            $table->string('merchant_satisfied');
            $table->string('accept_payment');
            $table->string('merchant_city');
            $table->string('scan_app');
            $table->string('scan_qr');

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
        Schema::dropIfExists('merchant_revisits');
    }
}
