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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id');
            $table->integer('investment_id')->nullable(); 
            $table->integer('debit_id')->nullable();
            $table->enum('type_transaction', ['Kredit', 'Debit']);
            $table->bigInteger('amount'); 
            $table->timestamp('transaction_date');
            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
