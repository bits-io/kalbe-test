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
        Schema::create('sales_transactions', function (Blueprint $table) {
            $table->id('InvoiceID');
            $table->unsignedBigInteger('OutletID');
            $table->unsignedBigInteger('SalesmanID');
            $table->date('TransactionDate');
            $table->decimal('Subtotal', 15, 2);
            $table->timestamps();

            $table->foreign('OutletID')->references('OutletID')->on('outlets');
            $table->foreign('SalesmanID')->references('SalesmanID')->on('salesmen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_transactions');
    }
};
