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
        $user = $this->getAssociatedUser($request->username_or_email);

        if (!$user || !$this->checkPassword($user->password, $request->password)) {
            abort(403, 'Username, email or password is incorrect. Please try again.');
        }

        $token = $user->createToken($user->name);

        return $this->success([
            'user' => $user,
            'auth_token' => $token->plainTextToken
        ]);
    }

    protected function getAssociatedUser(string $username_or_email): ?User
    {
        return User::where('email', $username_or_email)
            ->orWhere('username', $username_or_email)
            ->first();
    }
    protected function checkPassword(string $userPassword, string $givenPassword): bool
    {
        return Hash::check($givenPassword, $userPassword);
    }
}
