<?php

namespace App\Http\Controllers;

class BaseContoller extends Controller
{
    // Standardized success and error response methods
    public function successResponse($data, $message = "Success", $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function errorResponse($message = "Error", $code = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null
        ], $code);
    }
}
