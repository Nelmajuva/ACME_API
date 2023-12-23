<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TypeOfAccount;
use App\Utilities\HTTPHelpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypesOfAccountsController extends Controller
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
            $listTypesOfAccounts = TypeOfAccount::select(['*'])->paginate(16);

            return HTTPHelpers::responseJson($listTypesOfAccounts);
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

            $typeOfAccount = TypeOfAccount::create($validatedData);

            return HTTPHelpers::responseJson($typeOfAccount);
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
            $typeOfAccount = TypeOfAccount::find($id);

            return HTTPHelpers::responseJson($typeOfAccount);
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

            $typeOfAccount = TypeOfAccount::find($id);
            if (!isset($typeOfAccount)) return HTTPHelpers::responseError('Type of account not found.', 404);
            DB::beginTransaction();
            $typeOfAccount->update($validatedData);
            DB::commit();

            return HTTPHelpers::responseJson($typeOfAccount);
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
            $typeOfAccount = TypeOfAccount::where('id', $id)->where('status', true)->first();
            if (!isset($typeOfAccount)) return HTTPHelpers::responseError('Type of account not found.', 404);
            $typeOfAccount->update(['status' => false]);

            return HTTPHelpers::responseJson($typeOfAccount);
        } catch (\Throwable $th) {
            return HTTPHelpers::responseError($th->getMessage());
        }
    }
}
