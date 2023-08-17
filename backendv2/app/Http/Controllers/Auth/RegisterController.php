<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;

class RegisterController extends Controller {
    protected $userService;

    public function __construct(UserService $userService) 
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request) {
        $user = $this->userService->register($request->validated());

        auth()->login($user);
    }
}