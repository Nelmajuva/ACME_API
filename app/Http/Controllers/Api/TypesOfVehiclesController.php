<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Utilities\HTTPHelpers;
use App\Models\TypeOfVehicle;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TypesOfVehiclesController extends Controller
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
            $listTypesOfVehicles = TypeOfVehicle::select(['*'])->paginate(32);

            return HTTPHelpers::responseJson($listTypesOfVehicles);
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
                'name' => 'required|string|unique:types_of_vehicles',
            ]);

            $listTypesOfVehicles = TypeOfVehicle::create($validatedData + ['status' => true]);

            return HTTPHelpers::responseJson($listTypesOfVehicles);
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
            $typeOfVehicle = TypeOfVehicle::find($id);

            return HTTPHelpers::responseJson($typeOfVehicle);
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
                'name' => 'required|string',
            ]);

            $typeOfVehicle = TypeOfVehicle::find($id);
            if (!isset($typeOfVehicle)) return HTTPHelpers::responseError('Type of vehicle not found.', 404);
            DB::beginTransaction();
            $typeOfVehicle->update($request->all());
            DB::commit();

            return HTTPHelpers::responseJson($typeOfVehicle);
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
            $typeOfVehicle = TypeOfVehicle::where('id', $id)->where('status', true)->first();
            if (!isset($typeOfVehicle)) return HTTPHelpers::responseError('Type of vehicle not found.', 404);
            $typeOfVehicle->update(['status' => false]);

            return HTTPHelpers::responseJson($typeOfVehicle);
        } catch (\Throwable $th) {
            return HTTPHelpers::responseError($th->getMessage());
        }
    }
}
