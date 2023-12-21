<?php

namespace Database\Seeders;

use App\Models\City;

use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    private array $listOfCities = [];

    public function __construct()
    {
        $this->listOfCities = [
            ["name" => "Medellín"],
            ["name" => "Bogotá D.C."],
            ["name" => "Bello"],
        ];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentTimestamp = now();

        $citiesToCreate = array_map(function ($city) use ($currentTimestamp) {
            return [
                "name" => $city["name"],
                "status" => true,
                "created_at" => $currentTimestamp,
                "updated_at" => $currentTimestamp,
            ];
        }, $this->listOfCities);

        City::insert($citiesToCreate);
    }
}
