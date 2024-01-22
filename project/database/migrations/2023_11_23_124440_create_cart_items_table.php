<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->index()->nullable();
            $table->foreignId('sales_center_id')->index()->nullable();
            $table->foreignId('stock_id')->index()->nullable();
            $table->foreignId('item_id')->index()->nullable();
            $table->integer('quantity')->default(0);
            $table->decimal('cost_per_unit', 11, 2)->nullable();
            $table->decimal('cost', 11, 2)->nullable();
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
        Schema::dropIfExists('cart_items');
    }
}
