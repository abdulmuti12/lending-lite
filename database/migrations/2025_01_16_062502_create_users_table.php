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
        Schema::create('user_account', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->string('born_place', 60);
            $table->dateTime('born_date');
            $table->string('phone_number', 20);
            $table->string('nik', 30);
            $table->string('ktp_file', 225)->nullable();
            $table->bigInteger('salary_per_month');
            $table->string('password', 225);
            $table->bigInteger('limit_loan')->nullable();
            $table->string('type', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
