<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalerPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('enquiry_pair_id');
            $table->integer('price');
            $table->boolean('cust_confirmed')->nullable();
            $table->timestamp('cust_confirmed_at')->nullable();
            $table->boolean('artist_confirmed')->nullable();
            $table->timestamp('artist_confirmed_at')->nullable();
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
        Schema::dropIfExists('saler_price');
    }
}
