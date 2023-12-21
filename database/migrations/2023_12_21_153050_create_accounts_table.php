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
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->integer('type_of_account_id');
            $table->integer('city_id');
            $table->string('document', 12);
            $table->string('first_name', 32);
            $table->string('second_name', 32);
            $table->string('surnames', 48);
            $table->string('phone_number', 16);
            $table->timestamps();
            $table->boolean('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
