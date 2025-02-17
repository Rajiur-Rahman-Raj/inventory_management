<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable();
            $table->string('member_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('division_id')->index()->nullable();
            $table->foreignId('district_id')->index()->nullable();
            $table->foreignId('upazila_id')->index()->nullable();
            $table->foreignId('union_id')->index()->nullable();
            $table->string('member_national_id')->nullable();
            $table->decimal('total_commission_amount',18,8)->default(0);
            $table->string('member_commission')->nullable();
            $table->decimal('member_commission_amount', 18,8)->default(0);
            $table->timestamp('date_of_death')->nullable();
            $table->string('wife_name')->nullable();
            $table->string('wife_national_id')->nullable();
            $table->string('wife_commission')->nullable();
            $table->decimal('wife_commission_amount', 18,8)->default(0);
            $table->string('document')->nullable();
            $table->string('driver')->nullable();
            $table->text('address')->nullable();
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
        Schema::dropIfExists('affiliate_members');
    }
}
