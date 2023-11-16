<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Logs out the user
     *
     * This endpoint revokes the current api key.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        if (!$request->user()->currentAccessToken()->delete()) {
            abort(400, "Could not revoke current token. Please try again.");
        }
        return $this->success("Token revoked successfully");
    }
}
