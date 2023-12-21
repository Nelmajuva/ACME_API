<?php

namespace Database\Seeders;

use App\Models\MotorOfVehicle;
use Illuminate\Database\Seeder;

class MotorOfVehicleSeeder extends Seeder
{
    private array $listMotorsOfVehicles = [
        ["name" => "Suzuki Alto 800 2018"],
        ["name" => "Kangoo Sandero"],
        ["name" => "Lágrima Optra / Aveo"],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentTimestamp = now();

        $motorsOfVehicles = array_map(function ($motorOfVehicle) use ($currentTimestamp) {
            return [
                "name" => $motorOfVehicle["name"],
                "status" => true,
                "created_at" => $currentTimestamp,
                "updated_at" => $currentTimestamp,
            ];
        }, $this->listMotorsOfVehicles);

        MotorOfVehicle::insert($motorsOfVehicles);
    }
}
