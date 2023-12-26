<?php

namespace App\Http\Controllers\Api;

use App\Utilities\HttpHelpers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['signInWithEmailAndPassword']);
    }

    /**
     * Sign in to delete all existing user tokens and return a new token.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function signInWithEmailAndPassword(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string|min:8',
            ]);

            if (!Auth::attempt($validatedData)) {
                return HttpHelpers::responseError('Invalid credentials.', 401);
            }

            $request->user()->tokens()->delete();

            $user = $request->user();
            $accessToken = $user->createToken('TokenACME')->plainTextToken;

            return HttpHelpers::responseJson(['user' => $user, 'access_token' => $accessToken]);
        } catch (\Throwable $th) {
            return HttpHelpers::responseError($th->getMessage());
        }
    }

    /**
     * Return user logged.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $user->tokens()->delete();
            $accessToken = $user->createToken('TokenACME')->plainTextToken;

            return HttpHelpers::responseJson(['user' => $user, 'access_token' => $accessToken]);
        } catch (\Throwable $th) {
            return HttpHelpers::responseError($th->getMessage());
        }
    }

    /**
     * Sign out everywhere and delete the token in the database.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function signOut(Request $request)
    {
        try {
            $request->user()->tokens()->delete();

            return HttpHelpers::responseJson('Tokens revoked successfully.');
        } catch (\Throwable $th) {
            return HttpHelpers::responseError($th->getMessage());
        }
    }
}
