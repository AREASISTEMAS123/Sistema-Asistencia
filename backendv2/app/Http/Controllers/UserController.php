<?php

declare(strict_types=1);

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Services\UserService;
use App\Models\User;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $users = $this->userService->getFilteredUsers($request->all());
        return response()->json($users);
    }

    public function show($id)
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    public function showProfileData(){
        $users = User::with('position.core.department')->get();
        return response()->json($users);
    }
}
