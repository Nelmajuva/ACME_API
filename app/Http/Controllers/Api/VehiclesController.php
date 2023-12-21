<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $listOfVehicles = Vehicle::select(['*'])->paginate(8);

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
            ]);

            $listOfVehicles = Vehicle::create($validatedData);

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
            $vehicle = Vehicle::find($id);

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
            $validatedData = $request->validate([
                'plate' => 'required|string',
                'motor_of_vehicle_id' => 'required',
                'type_of_vehicle_id' => 'required',
                'driver_uuid' => 'required',
                'owner_uuid' => 'required',
            ]);

            $vehicle = Vehicle::find($id);
            if (!isset($vehicle)) return HTTPHelpers::responseError('Vehicle not found.', 404);
            DB::beginTransaction();
            $vehicle->update($validatedData);
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
