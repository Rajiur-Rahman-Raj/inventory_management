<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTransferDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transfer_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->index()->nullable();
            $table->foreignId('item_id')->index()->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('cost_per_unit', 11, 2)->default(0);
            $table->decimal('amount', 11, 2)->nullable();
            $table->timestamp('transfer_date')->nullable();
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
        Schema::dropIfExists('stock_transfer_details');
    }
}
