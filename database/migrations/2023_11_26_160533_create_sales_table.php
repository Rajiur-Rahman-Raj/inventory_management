<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->index()->nullable();
            $table->foreignId('sales_center_id')->index()->nullable();
            $table->foreignId('customer_id')->index()->nullable();
            $table->json('items')->nullable();
            $table->decimal('sub_total', 11, 2)->default(0);
            $table->decimal('discount', 11, 2)->default(0);
            $table->decimal('total_amount', 11, 2)->default(0);
            $table->decimal('customer_paid_amount', 11, 2)->default(0);
            $table->decimal('due_amount', 11, 2)->default(0);
            $table->timestamp('payment_date')->nullable();
            $table->text('payment_note')->nullable();
            $table->boolean('payment_status')->default(1);
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
        Schema::dropIfExists('sales');
    }
}
