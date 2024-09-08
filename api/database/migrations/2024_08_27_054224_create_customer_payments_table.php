<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_payments', function (Blueprint $table) {
            $table->bigIncrements('cstr_pay_ID');
            $table->unsignedBigInteger('sls_prd_ord_ID');
            $table->date('payment_date');
            $table->unsignedBigInteger('pay_mthd_ID');
            $table->string('payment_status');
            $table->date('due_date');
            $table->decimal('amount_to_pay', 10, 2);
            $table->decimal('amount_paid', 10, 2);
            $table->timestamps();

            $table->Foreign('sls_prd_ord_ID')->references('sls_prd_ord_ID')->on('sales_product_orders')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->Foreign('pay_mthd_ID')->references('pay_mthd_ID')->on('payment_methods')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_payments', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['sls_prd_ord_ID']);
            $table->dropForeign(['pay_mthd_ID']);
        });
        Schema::dropIfExists('customer_payments');
    }
};
