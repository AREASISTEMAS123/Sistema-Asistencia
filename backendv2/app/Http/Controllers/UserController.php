<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Repositories\UserRepositories\UserRepositoryInterface;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->all();
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

    public function store(RegisterRequest $request)
    {
        // Implement validation here (similar to what we discussed before)
        $user = $this->userRepository->create($request->all());
        return response()->json(['message' => 'User created successfully', 'data' => $user], 201);
    }

    public function update(Request $request, $id)
    {
        // Implement validation here
        if (!$this->userRepository->update($id, $request->all())) {
            return response()->json(['message' => 'User update failed'], 400);
        }

        return response()->json(['message' => 'User updated successfully']);
    }

    public function destroy($id)
    {
        if (!$this->userRepository->delete($id)) {
            return response()->json(['message' => 'User delete failed'], 400);
        }

        return response()->json(['message' => 'User deleted successfully']);
    }
}