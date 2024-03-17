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
            $table->text('center_address')->nullable();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->integer('discount_percent')->default(0);
            $table->string('national_id')->nullable();
            $table->string('trade_id')->nullable();
            $table->boolean('status')->default(1);
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
