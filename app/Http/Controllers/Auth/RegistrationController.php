<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegistrationController extends Controller
{
    /**
     * Register new users
     *
     * Create new users in the application
     *
     * @param RegisterUserRequest $request
     * @return mixed
     */
    public function __invoke(RegisterUserRequest $request): mixed
    {

        $user = User::create($request->validated());

        // We could certainly send a verification email but that's beyond the scope of this test...
        $user->markEmailAsVerified();

        $token = $user->createToken($user->name);

        return $this->success([
            'user' => $user,
            'auth_token' => $token->plainTextToken
        ], 201);
    }
}
