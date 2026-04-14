<?php

namespace App\Domains\System\Helpers;

use App\Domains\System\Middlewares\LanguageMiddleware;

class ResponseHelper
{
    public static function success($data = [], $message = 'success', $statusCode = 200)
    {
        return response()->json([
            'status' => LanguageMiddleware::getMessage('status_success'),
            'message' => LanguageMiddleware::getMessage($message),
            'language' => LanguageMiddleware::getCurrentLanguage(),
            'data' => $data,
            'timestamp' => now()->format('Y-m-d H:i:s'),
        ], $statusCode);
    }

    public static function error($message = 'error', $statusCode = 400, $data = [])
    {
        return response()->json([
            'status' => LanguageMiddleware::getMessage('status_error'),
            'message' => LanguageMiddleware::getMessage($message),
            'language' => LanguageMiddleware::getCurrentLanguage(),
            'data' => $data,
            'timestamp' => now()->format('Y-m-d H:i:s'),
        ], $statusCode);
    }

    public static function notFound($message = 'not_found')
    {
        return self::error($message, 404);
    }

    public static function unauthorized($message = 'unauthorized')
    {
        return self::error($message, 401);
    }

    public static function validationError($errors, $message = 'invalid_request')
    {
        return self::error($message, 422, ['errors' => $errors]);
    }
}
