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
        Schema::create('transactions_log', function (Blueprint $table) {
            $table->id();
            $table->integer('investment_id')->nullable(); 
            $table->integer('bank_id')->nullable(); 
            $table->integer('debit_id')->nullable();
            $table->string('type', 50)->nullable();
            $table->bigInteger('amount'); 
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions_log');
    }
};
