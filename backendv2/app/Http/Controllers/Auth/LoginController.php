<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Requests;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Str;

use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {

        if (!Auth::attempt($request->only(['username', 'password']))) {
            return response()->json(['message' => 'No autorizado'], 401);
        } elseif (auth()->user()->status == 0) {
            return response()->json(['message' => 'Tu cuenta ha sido bloqueada, contacta a un administrador'], 401);
        }

        $user = User::where('username', $request->input('username'))->first();

        $token = $user->createToken(Str::random())->plainTextToken;

        return response()->json([
            'access_token' => $token,

        ]);
    }
}


