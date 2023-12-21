<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MotorOfVehicle;
use App\Utilities\HTTPHelpers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class MotorsOfVehiclesController extends Controller
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
            $listMotorsOfVehicles = MotorOfVehicle::select(['*'])->paginate(8);

            return HTTPHelpers::responseJson($listMotorsOfVehicles);
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
                'name' => 'required|string',
            ]);

            $motorOfVehicle = MotorOfVehicle::create($validatedData);

            return HTTPHelpers::responseJson($motorOfVehicle);
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
            $motorOfVehicle = MotorOfVehicle::find($id);

            return HTTPHelpers::responseJson($motorOfVehicle);
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
                'name' => 'required|string',
            ]);

            $motorOfVehicle = MotorOfVehicle::find($id);
            if (!isset($motorOfVehicle)) return HTTPHelpers::responseError('Motor of vehicle not found.', 404);
            DB::beginTransaction();
            $motorOfVehicle->update($validatedData);
            DB::commit();

            return HTTPHelpers::responseJson($motorOfVehicle);
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
            $motorOfVehicle = MotorOfVehicle::where('id', $id)->where('status', true)->first();
            if (!isset($motorOfVehicle)) return HTTPHelpers::responseError('Motor of vehicle not found.', 404);
            $motorOfVehicle->update(['status' => false]);

            return HTTPHelpers::responseJson($motorOfVehicle);
        } catch (\Throwable $th) {
            return HTTPHelpers::responseError($th->getMessage());
        }
    }
}
