<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Justification;
use App\Repositories\JustificationRepositories\JustificationRepositoryInterface;

class JustificationService {
    protected $justificationRepository;

    public function __construct(JustificationRepositoryInterface $justificationRepository) {
        $this->justificationRepository = $justificationRepository;
    }

    public function getAllJustifications() {
        return $this->justificationRepository->all();
    }

    public function createJustification(array $data) {

        $data["status"] = 3;
        $user_id = auth()->id();
        $data["user_id"] = $user_id;

        return $this->justificationRepository->create($data);
    }

    // public function updateJustification(int $id, array $data) {
    //     if (Justification::find($data['core_id'])) {
    //         return $this->justificationRepository->update($id, $data);
    //     }
    //     return false;
    // }

    public function deleteJustification(int $id) {
        return $this->justificationRepository->delete($id);
    }
}
