<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Core;
use App\Repositories\ProfileRepositories\ProfileRepositoryInterface;

class ProfileService {
    protected $profileRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository) {
        $this->profileRepository = $profileRepository;
    }

    public function getAllProfiles() {
        return $this->profileRepository->all();
    }

    public function createProfile(array $data) {
        if (Core::find($data['core_id'])) {
            return $this->profileRepository->create($data);
        }
        return null;
    }

    public function updateProfile(int $id, array $data) {
        if (Core::find($data['core_id'])) {
            return $this->profileRepository->update($id, $data);
        }
        return false;
    }

    public function deleteProfile(int $id) {
        return $this->profileRepository->delete($id);
    }
}
