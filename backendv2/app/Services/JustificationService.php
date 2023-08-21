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

        $file = $data['evidence'];
        $folderName = date("Y-m-d"); 
        $path = "justifications/" . $folderName; 
        $filename = time() . "-" . $file->getClientOriginalName();
        $file->move($path, $filename);

        $data['evidence'] = $path . "/" . $filename;

        return $this->justificationRepository->create($data);
    }

    public function acceptJustification($id) {
        $justification = Justification::find($id);

        if ($justification) {
            if ($justification->status == 1 || $justification->status == 2) {
                return response()->json(['message' => 'Esta justificacion ya ha sido aceptada o declinada'], 201);
            } else {
                $justification->status = 1;
                $justification->save();
                return $justification;
            }
        }
    }

    public function declineJustification($id) {
        $justification = Justification::find($id);

        if ($justification) {
            if ($justification->status == 2 || $justification->status == 1) {
                return response()->json(['message' => 'Esta justificacion ya ha sido declinada o aceptada'], 201);
            } else {
                $justification->status = 2;
                $justification->save();
                return $justification;
            }
        }
    }

    public function deleteJustification(int $id) {
        return $this->justificationRepository->delete($id);
    }
}
