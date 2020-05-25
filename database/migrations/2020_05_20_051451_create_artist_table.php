<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::dropIfExists('artist');
        Schema::create('artist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('artist_ssn')->unique(); 
            $table->string('artist_email')->unique();
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('usual_type')->nullable();
            $table->string('usual_medium')->nullable();
            $table->string('usual_style')->nullable();
            $table->bigInteger('sales_last_year')->default('0');
            $table->bigInteger('sales_year_to_date')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artist');
    }
}
