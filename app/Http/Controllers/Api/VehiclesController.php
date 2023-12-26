<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\MotorOfVehicle;
use App\Models\TypeOfVehicle;
use App\Utilities\HTTPHelpers;
use App\Models\Vehicle;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class VehiclesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Get all the information need to create 
     * or edit a vehicle.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getResources(): JsonResponse
    {
        try {
            $listOfOwners = Account::select(['*'])->whereIn('type_of_account_id', ['1', '3'])->where('status', true)->get();
            $listOfDrivers = Account::select(['*'])->whereIn('type_of_account_id', ['2', '3'])->where('status', true)->get();
            $listMotorsOfVehicles = MotorOfVehicle::select(['*'])->where('status', true)->get();
            $listTypesOfVehicles = TypeOfVehicle::select(['*'])->where('status', true)->get();

            return HTTPHelpers::responseJson([
                'owners' => $listOfOwners,
                'drivers' => $listOfDrivers,
                'motors_of_vehicles' => $listMotorsOfVehicles,
                'types_of_vehicles' => $listTypesOfVehicles,
            ]);
        } catch (\Throwable $th) {
            return HTTPHelpers::responseError($th->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $listOfVehicles = Vehicle::select(['*'])->with('motorOfVehicle')->with('typeOfVehicle')->with('driver')->with('owner')->paginate(32);

            return HTTPHelpers::responseJson($listOfVehicles);
        } catch (\Throwable $th) {
            return HTTPHelpers::responseError($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'plate' => 'required|string',
                'motor_of_vehicle_id' => 'required',
                'type_of_vehicle_id' => 'required',
                'driver_uuid' => 'required',
                'owner_uuid' => 'required',
                'color' => 'required',
            ]);

            $listOfVehicles = Vehicle::create($validatedData + ['status' => true]);

            return HTTPHelpers::responseJson($listOfVehicles);
        } catch (\Throwable $th) {
            return HTTPHelpers::responseError($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $vehicle = Vehicle::where('uuid', $id)->with('motorOfVehicle')->with('typeOfVehicle')->with('driver')->with('driver.city')->with('owner')->with('owner.city')->first();

            return HTTPHelpers::responseJson($vehicle);
        } catch (\Throwable $th) {
            return HTTPHelpers::responseError($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $request->validate([
                'plate' => 'required|string',
                'motor_of_vehicle_id' => 'required',
                'type_of_vehicle_id' => 'required',
                'driver_uuid' => 'required',
                'owner_uuid' => 'required',
                'color' => 'required',
            ]);

            $vehicle = Vehicle::find($id);
            if (!isset($vehicle)) return HTTPHelpers::responseError('Vehicle not found.', 404);
            DB::beginTransaction();
            $vehicle->update($request->all());
            DB::commit();

            return HTTPHelpers::responseJson($vehicle);
        } catch (\Throwable $th) {
            return HTTPHelpers::responseError($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $vehicle = Vehicle::where('id', $id)->where('status', true)->first();
            if (!isset($vehicle)) return HTTPHelpers::responseError('Vehicle not found.', 404);
            $vehicle->update(['status' => false]);

            return HTTPHelpers::responseJson($vehicle);
        } catch (\Throwable $th) {
            return HTTPHelpers::responseError($th->getMessage());
        }
    }
}
