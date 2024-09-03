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
        Schema::create('admin_payments', function (Blueprint $table) {
            $table->bigIncrements('admin_pay_ID');
            $table->unsignedBigInteger('admin_ord_ID');
            $table->unsignedBigInteger('pay_mthd_ID');
            $table->decimal('amount_to_pay', 10, 2);
            $table->decimal('amount_paid', 10, 2);
            $table->date('due_date');
            $table->string('payment_status');
            $table->string('remarks');
            $table->timestamps();

            $table->foreign('admin_ord_ID')->references('admin_ord_ID')->on('admin_orders')
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
        Schema::table('admin_payments', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['admin_ord_ID']);
            $table->dropForeign(['pay_mthd_ID']);
        });
        Schema::dropIfExists('admin_payments');
    }
};
