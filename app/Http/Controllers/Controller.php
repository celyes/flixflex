<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function success(string|array $data, $code = 200): JsonResponse
    {
        $response = ['success' => true];

        if (is_array($data)) {
            $response += $data;
        } else {
            $response['message'] = $data;
        }

        return response()->json($response, $code);
    }
}
