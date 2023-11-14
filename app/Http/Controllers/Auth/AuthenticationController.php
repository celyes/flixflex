<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    /**
     * Authenticate a user
     *
     * This endpoint authenticates a user based on a given email or username and a password
     *
     * @param AuthenticateUserRequest $request
     * @return JsonResponse
     */
    public function __invoke(AuthenticateUserRequest $request): JsonResponse
    {
        $user = User::where('email', $request->username_or_email)
            ->orWhere('username', $request->username_or_email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            abort(403, 'Username, email or password is incorrect. Please try again.');
        }

        $token = $user->createToken($user->name);

        return response()->json([
            'success' => true,
            'user' => $user,
            'auth_token' => $token->plainTextToken
        ]);
    }
}
