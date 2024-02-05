<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateMemberCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_member_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->index()->nullable();
            $table->foreignId('affiliate_member_id')->index()->nullable();
            $table->decimal('amount')->index()->nullable();
            $table->timestamp('commission_date')->nullable();
            $table->integer('commission_by')->default(1)->comment('1 => member, 2=> member_wife');
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
        Schema::dropIfExists('affiliate_member_commissions');
    }
}
