<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_centers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->foreignId('company_id')->index()->nullable();
            $table->foreignId('division_id')->index()->nullable();
            $table->foreignId('district_id')->index()->nullable();
            $table->foreignId('upazila_id')->index()->nullable();
            $table->foreignId('union_id')->index()->nullable();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('national_id')->nullable();
            $table->string('trade_id')->nullable();
            $table->string('address')->nullable();
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
        Schema::dropIfExists('sales_centers');
    }
}
