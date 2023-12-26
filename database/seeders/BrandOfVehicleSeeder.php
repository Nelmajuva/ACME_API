<?php

namespace Database\Seeders;

use App\Models\BrandOfVehicle;
use Illuminate\Database\Seeder;

class BrandOfVehicleSeeder extends Seeder
{
    private array $listBrandsOfVehicles = [
        ["name" => "Ford"],
        ["name" => "ARK"],
        ["name" => "BMW"],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentTimestamp = now();

        $brandsOfVehiclesToCreate = array_map(function ($brandOfVehicle) use ($currentTimestamp) {
            return [
                "name" => $brandOfVehicle["name"],
                "status" => true,
                "created_at" => $currentTimestamp,
                "updated_at" => $currentTimestamp,
            ];
        }, $this->listBrandsOfVehicles);

        BrandOfVehicle::insert($brandsOfVehiclesToCreate);
    }
}
