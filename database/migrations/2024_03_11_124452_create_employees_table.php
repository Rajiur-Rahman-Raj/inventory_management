<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->index()->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('national_id')->nullable();
            $table->timestamp('date_of_birth')->nullable();
            $table->timestamp('joining_date')->nullable();
            $table->string('designation')->nullable();
            $table->integer('employee_type')->nullable();
            $table->decimal('joining_salary', 11,2)->default(0);
            $table->decimal('current_salary', 11,2)->default(0);
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->boolean('status')->default(1);
            $table->string('image')->nullable();
            $table->string('driver')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
