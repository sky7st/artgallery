<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnquiryPairTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiry_pair', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('work_id');
            $table->bigInteger('customer_id');
            $table->bigInteger('saler_id')->nullable();
            $table->bigInteger('now_price_id')->nullable();
            $table->timestamps();
            $table->unique(['work_id', 'customer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enquiry_pair');
    }
}
