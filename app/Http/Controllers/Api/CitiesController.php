<?php

namespace App\Http\Controllers\Api;

use App\Models\City;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use App\Utilities\HTTPHelpers;
use App\Http\Controllers\Controller;

class CitiesController extends Controller
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
            $listOfCities = City::select(['*'])->paginate(8);

            return HTTPHelpers::responseJson($listOfCities);
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

            $city = City::create($validatedData);

            return HTTPHelpers::responseJson($city);
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
            $city = City::find($id);

            return HTTPHelpers::responseJson($city);
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

            $city = City::find($id);
            if (!isset($city)) return HTTPHelpers::responseError('City not found.', 404);
            DB::beginTransaction();
            $city->update($validatedData);
            DB::commit();

            return HTTPHelpers::responseJson($city);
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
            $city = City::where('id', $id)->where('status', true)->first();
            if (!isset($city)) return HTTPHelpers::responseError('City not found.', 404);
            $city->update(['status' => false]);

            return HTTPHelpers::responseJson($city);
        } catch (\Throwable $th) {
            return HTTPHelpers::responseError($th->getMessage());
        }
    }
}
