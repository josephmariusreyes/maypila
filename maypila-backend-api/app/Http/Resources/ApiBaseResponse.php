<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiBaseResponse
{
    public static function success($data = null, string $message = 'Success', int $status = 200, array $meta = [])
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'meta' => $meta ?: null,
        ], $status);
    }

    public static function error(string $message = 'Error', int $status = 400, $errors = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
