<?php

declare(strict_types=1);

namespace App\Http\Controllers;


use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Attendance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $userShift = Auth::user()->shift;
        $users = $this->userService->getFilteredUsers($request->all(), $userShift);
        return response()->json($users);
    }

    public function show($id)
    {
        $userData = $this->userService->getUserDetails($id);
        if (is_null($userData)) {
            return response()->json(['message' => 'No encontrado'], 404);
        }
        return response()->json($userData);
    }

    public function update(UpdateUserRequest $request, $user)
    {
        try {
            $user = $this->userService->update($user, $request->validated());

            return response()->json([
                'message' => 'User updated successfully',
            ], 200);
        } catch (\Exception $e) {
            print ($e);
            return response()->json(['error' => 'User update failed'], 500);
        }
    }


}
