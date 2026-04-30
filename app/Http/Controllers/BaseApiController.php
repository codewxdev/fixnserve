<?php

namespace App\Http\Controllers;

use App\Domains\Config\Helpers\ResponseHelper;

class BaseApiController extends Controller
{
    protected function success($data = [], $message = 'success', $statusCode = 200)
    {
        return ResponseHelper::success($data, $message, $statusCode);
    }

    protected function error($message = 'error', $statusCode = 400, $data = [])
    {
        return ResponseHelper::error($message, $statusCode, $data);
    }

    protected function notFound($message = 'not_found')
    {
        return ResponseHelper::notFound($message);
    }

    protected function unauthorized($message = 'unauthorized')
    {
        return ResponseHelper::unauthorized($message);
    }

    protected function validationError($errors, $message = 'invalid_request')
    {
        return ResponseHelper::validationError($errors, $message);
    }
}
