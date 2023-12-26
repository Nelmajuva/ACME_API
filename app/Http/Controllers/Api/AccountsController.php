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
            $listOfAccounts = Account::select(['*'])->with('typeOfAccount')->with('city')->paginate(32);

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
                'document' => 'required|unique:accounts',
                'first_name' => 'required|string',
                'second_name' => 'string|nullable',
                'surnames' => 'required|string',
                'phone_number' => 'required',
                'address' => 'required',
            ]);

            $account = Account::create($validatedData + ['status' => true]);

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
            $account = Account::where('uuid', $id)->with('typeOfAccount')->with('city')->first();

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
            $request->validate([
                'type_of_account_id' => 'required',
                'city_id' => 'required',
                'document' => 'required',
                'first_name' => 'required|string',
                'second_name' => 'nullable|string',
                'surnames' => 'required|string',
                'phone_number' => 'required',
                'address' => 'required',
            ]);

            $account = Account::find($id);
            if (!isset($account)) return HTTPHelpers::responseError('Account not found.', 404);
            DB::beginTransaction();
            $account->update($request->all());
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
