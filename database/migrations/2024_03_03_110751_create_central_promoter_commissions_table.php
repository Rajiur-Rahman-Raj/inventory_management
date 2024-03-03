<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCentralPromoterCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('central_promoter_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('central_promoter_id')->index()->nullable();
            $table->foreignId('sale_id')->index()->nullable();
            $table->decimal('amount', 11,2)->nullable();
            $table->timestamp('commission_date')->nullable();
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
        Schema::dropIfExists('central_promoter_commissions');
    }
}
