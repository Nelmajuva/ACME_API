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
        Schema::create('address_accounts', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('account_uuid');
            $table->string('type_of_road')->nullable();
            $table->string('number_of_road')->nullable();
            $table->string('letter')->nullable();
            $table->string('complement')->nullable();
            $table->string('number')->nullable();
            $table->string('letter_two')->nullable();
            $table->string('complement_two')->nullable();
            $table->string('number_two')->nullable();
            $table->string('complement_three')->nullable();

            $table->foreign('account_uuid')->references('uuid')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address_accounts');
    }
};
