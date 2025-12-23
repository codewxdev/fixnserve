<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success($data = null, string $message = 'Success', int $status = 200): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Return an error JSON response
     *
     * @param  mixed  $data
     */
    public static function error(string $message = 'Error', int $status = 400, $data = null): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Return a validation error JSON response
     */
    public static function validationError(array $errors, string $message = 'Validation failed'): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors,
        ], 422);
    }

    /**
     * Return a not found JSON response
     */
    public static function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], 404);
    }

    /**
     * Return an unauthorized JSON response
     */
    public static function unauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], 401);
    }

    /**
     * Return a forbidden JSON response
     */
    public static function forbidden(string $message = 'Forbidden'): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], 403);
    }
}
