<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request) : JsonResponse
    {
        $user = User::query()->where([
            'email' => $request->validated("email"),
        ])->first();

        if (! $user || ! Hash::check($request->validated("password"), $user->password)) {
            return response()->json(
                ["message" => "Invalid Credentials"],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $token = $user->createToken($user->email)->plainTextToken;

        return response()->json(["user" => $user, "token" => $token]);
    }
}
