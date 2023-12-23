<?php

namespace App\Utilities;

class HTTPHelpers
{
    /**
     * Response for default.
     * @return \Illuminate\Http\JsonResponse
     */
    public static function responseJson($message)
    {
        return response()->json(["status" => true, 'message' => $message], 200);
    }

    /**
     * Response with custom errors.
     * @return \Illuminate\Http\JsonResponse
     */
    public static function responseError($message, $status = 500)
    {
        /**
         * Use system logs to save errors or use vendors 
         * to save all critical errors.
         * 
         * ...
         */

        return response()->json(['status' => false, 'message' => $message, 'code' => $status], $status);
    }
}
