<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWastagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wastages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->index()->nullable();
            $table->foreignId('raw_item_id')->index()->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('cost_per_unit', 11,2)->nullable();
            $table->decimal('total_cost', 11,2)->nullable();
            $table->timestamp('wastage_date')->nullable();
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
        Schema::dropIfExists('wastages');
    }
}
