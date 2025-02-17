<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_id')->index()->nullable();
            $table->foreignId('stock_id')->index()->nullable();
            $table->foreignId('item_id')->index()->nullable();
            $table->string('item_name')->nullable();
            $table->integer('item_quantity')->nullable();
            $table->decimal('cost_per_unit', 11, 2)->default(0)->comment('selling_price');
            $table->decimal('item_price', 11, 2)->default(0)->comment('selling_total_item_price');
            $table->decimal('stock_per_unit', 11, 2)->default(0)->comment('for stock cost per unit');
            $table->decimal('stock_item_price', 11, 2)->default(0)->comment('stock total item price');
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
        Schema::dropIfExists('sales_items');
    }
}
