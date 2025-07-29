<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiResponse extends JsonResource
{
    public static function success($data = null, string $message = '', int $code = 200)
    {
        throw new HttpResponseException(response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code));
    }
    public static function failed($data = null, string $message = '', int $code = 200)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $code));
    }

    public static function error(string $message, int $code = 400, $errors = [])
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $code));
    }
}
