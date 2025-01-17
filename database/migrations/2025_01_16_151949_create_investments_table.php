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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->integer('lender_id'); // Foreign Key ke tabel lenders
            $table->integer('bank_id'); // Foreign Key ke tabel banks
            $table->timestamp('date_investment'); // Tanggal investasi
            $table->timestamp('date_investment_paid')->nullable(); // Tanggal investasi (nullable)
            $table->bigInteger('total_investment'); 
            $table->string('va_number', 30); 
            $table->enum('status', ['Pending', 'Completed', 'Failed'])->default('Pending'); // Status investasi
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
