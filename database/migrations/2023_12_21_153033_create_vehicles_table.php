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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('plate', 8)->unique();
            $table->string('color', 12);
            $table->unsignedInteger('motor_of_vehicle_id');
            $table->unsignedInteger('type_of_vehicle_id');
            $table->unsignedInteger('brand_of_vehicle_id');
            $table->uuid('driver_uuid');
            $table->uuid('owner_uuid');
            $table->timestamps();
            $table->boolean('status');

            $table->foreign('motor_of_vehicle_id')->references('id')->on('motors_of_vehicles');
            $table->foreign('type_of_vehicle_id')->references('id')->on('types_of_vehicles');
            $table->foreign('brand_of_vehicle_id')->references('id')->on('brands_of_vehicles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
