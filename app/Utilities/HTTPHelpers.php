<?php

namespace App\Utilities;

class HTTPHelpers
{
    /**
     * Response for default.
     * @return \Illuminate\Http\JsonResponse
     */
    public static function responseJson($message, $query = null, $bindings = null, $headers = [], $options = JSON_UNESCAPED_UNICODE)
    {
        if (!app()->environment('production')) {
            return response()->json(["status" => true, 'message' => $message, 'query' => $query, 'bindings' => $bindings], 200, $headers, $options);
        }
        return response()->json(["status" => true, 'message' => $message], 200, $headers, $options);
    }

    /**
     * Response with custom errors.
     * @return \Illuminate\Http\JsonResponse
     */
    public static function responseError($message, $status = 200, $headers = [], $options = JSON_UNESCAPED_UNICODE)
    {
        return response()->json(['status' => false, 'message' => $message], $status, $headers, $options);
    }
}
