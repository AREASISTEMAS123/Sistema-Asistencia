<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Str;

class LoginController extends Controller
{

    public function __invoke(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt(credentials: $request->only(keys: ['username', 'password']))) {
            return response()->json(['message' => 'No autorizado'], 401);
        }elseif (auth()->user()->status == 0){
            return response()->json(['message' => 'Tu cuenta ha sido bloqueado, contacte a un administrador'], 401);
        }

        $user = User::where('username', $request['username'])->first();

        $token = $user->createToken(Str::random())->plainTextToken;

        return response()->json(data: [
            'access_token' => $token
        ]);
    }
}
