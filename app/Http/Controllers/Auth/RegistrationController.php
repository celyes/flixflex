<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegistrationController extends Controller
{
    public function __invoke(RegisterUserRequest $request): mixed
    {
        $user = User::create($request->validated());
        $token = $user->createToken($user->name);
        return response()->json([
            'success' => true,
            'user' => $user,
            'auth_token' => $token->plainTextToken
        ], 201);
    }
}
