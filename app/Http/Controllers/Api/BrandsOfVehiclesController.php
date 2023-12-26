<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BrandOfVehicle;
use App\Utilities\HTTPHelpers;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class BrandsOfVehiclesController extends Controller
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
            $listBrandsOfVehicles = BrandOfVehicle::select(['*'])->paginate(32);

            return HTTPHelpers::responseJson($listBrandsOfVehicles);
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

            $listBrandsOfVehicles = BrandOfVehicle::create($validatedData + ['status' => true]);

            return HTTPHelpers::responseJson($listBrandsOfVehicles);
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
            $brandOfVehicle = BrandOfVehicle::find($id);

            return HTTPHelpers::responseJson($brandOfVehicle);
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

            $brandOfVehicle = BrandOfVehicle::find($id);
            if (!isset($brandOfVehicle)) return HTTPHelpers::responseError('Type of vehicle not found.', 404);
            DB::beginTransaction();
            $brandOfVehicle->update($request->all());
            DB::commit();

            return HTTPHelpers::responseJson($brandOfVehicle);
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
            $brandOfVehicle = BrandOfVehicle::where('id', $id)->where('status', true)->first();
            if (!isset($brandOfVehicle)) return HTTPHelpers::responseError('Brand of vehicle not found.', 404);
            $brandOfVehicle->update(['status' => false]);

            return HTTPHelpers::responseJson($brandOfVehicle);
        } catch (\Throwable $th) {
            return HTTPHelpers::responseError($th->getMessage());
        }
    }
}
