<?php

namespace App\Http\Controllers\Api;

use App\Models\Account;
use App\Utilities\HTTPHelpers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
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
            $listOfAccounts = Account::select(['*'])->paginate(16);

            return HTTPHelpers::responseJson($listOfAccounts);
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
                'type_of_account_id' => 'required',
                'city_id' => 'required',
                'document' => 'required|string|unique:users',
                'first_name' => 'required|string',
                'second_name' => 'required|string',
                'surnames' => 'required|string',
                'phone_number' => 'required|string',
            ]);

            $account = Account::create($validatedData);

            return HTTPHelpers::responseJson($account);
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
            $account = Account::find($id);

            return HTTPHelpers::responseJson($account);
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
                'type_of_account_id' => 'required',
                'city_id' => 'required',
                'document' => 'required|string|unique:users',
                'first_name' => 'required|string',
                'second_name' => 'required|string',
                'surnames' => 'required|string',
                'phone_number' => 'required|string',
            ]);

            $account = Account::find($id);
            if (!isset($account)) return HTTPHelpers::responseError('Account not found.', 404);
            DB::beginTransaction();
            $account->update($validatedData);
            DB::commit();

            return HTTPHelpers::responseJson($account);
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
            $account = Account::where('uuid', $id)->where('status', true)->first();
            if (!isset($account)) return HTTPHelpers::responseError('Account not found.', 404);
            $account->update(['status' => false]);

            return HTTPHelpers::responseJson($account);
        } catch (\Throwable $th) {
            return HTTPHelpers::responseError($th->getMessage());
        }
    }
}
