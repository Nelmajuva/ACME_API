<?php

namespace Database\Seeders;

use App\Models\TypeOfVehicle;
use Illuminate\Database\Seeder;

class TypeOfVehicleSeeder extends Seeder
{
    private array $listTypesOfVehicles = [
        ["name" => "Carro"],
        ["name" => "Moto"],
        ["name" => "Camioneta"],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentTimestamp = now();

        $typesOfVehiclesToCreate = array_map(function ($typeOfVehicle) use ($currentTimestamp) {
            return [
                "name" => $typeOfVehicle["name"],
                "status" => true,
                "created_at" => $currentTimestamp,
                "updated_at" => $currentTimestamp,
            ];
        }, $this->listTypesOfVehicles);

        TypeOfVehicle::insert($typesOfVehiclesToCreate);
    }
}
