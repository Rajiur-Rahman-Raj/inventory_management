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
            $table->foreignId('invoice_id')->index()->nullable();
            $table->foreignId('company_id')->index()->nullable();
            $table->foreignId('sales_center_id')->index()->nullable();
            $table->foreignId('customer_id')->index()->nullable();
            $table->json('items')->nullable();
            $table->decimal('sub_total', 11, 2)->default(0);
            $table->integer('discount_parcent')->default(0);
            $table->decimal('discount', 11, 2)->default(0);
            $table->decimal('total_amount', 11, 2)->default(0);
            $table->decimal('customer_paid_amount', 11, 2)->default(0);
            $table->decimal('due_amount', 11, 2)->default(0);
            $table->timestamp('latest_payment_date')->nullable();
            $table->text('latest_note')->nullable();
            $table->boolean('payment_status')->default(1);
            $table->integer('sales_by')->default(1)->comment('1=> company, 2=sales center');
            $table->boolean('is_return')->default(1)->comment('0=>no return, 1=>return sale');
            $table->decimal('profit', 11, 2)->nullable();
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
        Schema::dropIfExists('sales');
    }
}
