<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRawItemPurchaseInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raw_item_purchase_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->index()->nullable();
            $table->foreignId('supplier_id')->index()->nullable();
            $table->timestamp('purchase_date');
            $table->decimal('sub_total', 11,2)->nullable();
            $table->integer('discount_percent')->nullable();
            $table->decimal('discount_amount', 11, 2)->nullable();
            $table->decimal('total_price', 11, 2)->nullable();
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
        Schema::dropIfExists('raw_item_purchase_ins');
    }
}
