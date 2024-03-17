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
            $table->timestamp('purchase_date')->nullable();
            $table->decimal('sub_total', 11,2)->nullable();
            $table->integer('discount_percent')->nullable();
            $table->decimal('discount_amount', 11, 2)->nullable();
            $table->integer('vat_percent')->nullable();
            $table->decimal('vat_amount', 11, 2)->nullable();
            $table->decimal('total_price', 11, 2)->nullable();
            $table->decimal('paid_amount', 11, 2)->default(0);
            $table->decimal('due_amount', 11, 2)->default(0);
            $table->timestamp('last_payment_date')->nullable()->comment('not necessary');
            $table->timestamp('last_note')->nullable()->comment('here not necessary');
            $table->boolean('payment_status')->nullable();
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
        Schema::dropIfExists('raw_item_purchase_ins');
    }
}
