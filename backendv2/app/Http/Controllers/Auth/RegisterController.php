<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller {
    protected $userService;

    public function __construct(UserService $userService) 
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request): JsonResponse 
    {
        try {
            $user = $this->userService->register($request->validated());

            return response()->json([
                'message' => 'Registration successful',
                'data' => ['user' => $user]
            ], 201);

        } catch (\Exception $e) {
            // Puedes mejorar el manejo de errores con un logger o dando respuestas más específicas
            return response()->json(['error' => 'Registration failed'], 500);
        }
    }
}