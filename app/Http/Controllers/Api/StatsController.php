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
            $totalOfOwners = Account::where('type_of_account_id', '1')->count();
            $totalOfDrivers = Account::where('type_of_account_id', '2')->count();
            $totalOfVehicles = Vehicle::count();
            $totalOfCities = City::count();
            $totalOfMotorsVehicles = MotorOfVehicle::count();
            $totalOfTypesVehicles = TypeOfVehicle::count();
            $totalOfUsers = User::count();

            return HTTPHelpers::responseJson([
                'drivers' => $totalOfDrivers,
                'owners' => $totalOfOwners,
                'vehicles' => $totalOfVehicles,
                'cities' => $totalOfCities,
                'motors_vehicles' => $totalOfMotorsVehicles,
                'types_vehicles' => $totalOfTypesVehicles,
                'users' => $totalOfUsers,
            ]);
        } catch (\Throwable $th) {
            return HTTPHelpers::responseError($th->getMessage());
        }
    }
}
