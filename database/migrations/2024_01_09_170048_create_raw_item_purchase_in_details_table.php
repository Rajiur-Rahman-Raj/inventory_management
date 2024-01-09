<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRawItemPurchaseInDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raw_item_purchase_in_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raw_item_purchase_in_id')->index()->nullable();
            $table->foreignId('raw_item_id')->index()->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('cost_per_unit', 11, 2)->default(0);
            $table->decimal('total_unit_cost', 11, 2)->default(0);
            $table->timestamp('purchase_date')->nullable();
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
        Schema::dropIfExists('raw_item_purchase_in_details');
    }
}
