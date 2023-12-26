<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\City;
use App\Models\MotorOfVehicle;
use App\Models\TypeOfVehicle;
use App\Models\User;
use App\Models\Vehicle;
use App\Utilities\HTTPHelpers;

class StatsController extends Controller
{
    public function getStats()
    {
        try {
            $totalOfOwners = Account::whereIn('type_of_account_id', ['1', '3'])->count();
            $totalOfDrivers = Account::whereIn('type_of_account_id', ['2', '3'])->count();
            $totalOfVehicles = Vehicle::count();
            $totalOfCities = City::count();
            $totalOfMotorsVehicles = MotorOfVehicle::count();
            $totalOfBrandsVehicles = MotorOfVehicle::count();
            $totalOfTypesVehicles = TypeOfVehicle::count();
            $totalOfUsers = User::count();

            return HTTPHelpers::responseJson([
                'drivers' => $totalOfDrivers,
                'owners' => $totalOfOwners,
                'vehicles' => $totalOfVehicles,
                'cities' => $totalOfCities,
                'motors_vehicles' => $totalOfMotorsVehicles,
                'types_vehicles' => $totalOfTypesVehicles,
                'brands_vehicles' => $totalOfBrandsVehicles,
                'users' => $totalOfUsers,
            ]);
        } catch (\Throwable $th) {
            return HTTPHelpers::responseError($th->getMessage());
        }
    }
}
