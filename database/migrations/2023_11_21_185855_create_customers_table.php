<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('owner_name')->nullable();
            $table->foreignId('company_id')->nullable();
            $table->foreignId('sales_center_id')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('trade_id')->nullable();
            $table->string('national_id')->nullable();
            $table->string('check_no')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('division_id')->nullable();
            $table->string('district_id')->nullable();
            $table->string('upazila_id')->nullable();
            $table->string('union_id')->nullable();
            $table->text('address')->nullable();
            $table->string('image')->nullable();
            $table->string('driver')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
