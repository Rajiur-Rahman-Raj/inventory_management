<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRawItemMakePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_raw_item_make_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raw_item_purchase_in_id')->index()->nullable();
            $table->decimal('amount', 11,2)->nullable();
            $table->decimal('due', 11,2)->default(0);
            $table->timestamp('payment_date')->nullable();
            $table->timestamp('note')->nullable();
            $table->integer('paid_by')->nullable();
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
        Schema::dropIfExists('purchase_raw_item_make_payments');
    }
}
