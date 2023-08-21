<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class RegisterService {
    protected $userRepository;


    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data): User {
        $data['password'] = Hash::make($data['password']);

        return $this->userRepository->create($data);
    }
}