<?php

namespace Database\Seeders;

use App\Models\TypeOfAccount;

use Illuminate\Database\Seeder;

class TypeOfAccountSeeder extends Seeder
{
    private array $listTypesOfAccounts = [
        ["name" => "Propietario"],
        ["name" => "Conductor"],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentTimestamp = now();

        $typesOfAccountsToCreate = array_map(function ($typeOfAccount) use ($currentTimestamp) {
            return [
                "name" => $typeOfAccount["name"],
                "status" => true,
                "created_at" => $currentTimestamp,
                "updated_at" => $currentTimestamp,
            ];
        }, $this->listTypesOfAccounts);

        TypeOfAccount::insert($typesOfAccountsToCreate);
    }
}
