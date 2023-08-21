<?php

namespace App\Http\Controllers;

use App\Services\PositionService;
use Illuminate\Http\Request;

class ProfileController extends Controller {
    protected $positionService;

    public function __construct(PositionService $positionService) {
        $this->positionService = $positionService;
    }

    public function getProfiles() {
        $profiles = $this->positionService->getAllPositions();
        return response()->json($profiles);
    }

    public function createProfile(Request $request) {
        $profile = $this->positionService->createPosition($request->all());
        if (!$profile) {
            return response()->json(['message' => 'Nucleo no encontrado.'], 404);
        }
        return response()->json(['message' => 'Perfil creado exitosamente.', 'data' => $profile], 201);
    }

    public function updateProfile(Request $request, $id) {
        $updated = $this->positionService->updatePosition($id, $request->all());
        if (!$updated) {
            return response()->json(['message' => 'Nucleo no encontrado o perfil no encontrado.'], 404);
        }
        return response()->json(['message' => 'Perfil actualizado exitosamente.']);
    }

    public function deleteProfile($id) {
        $deleted = $this->positionService->deletePosition($id);
        if (!$deleted) {
            return response()->json(['message' => 'Perfil no encontrado.'], 404);
        }
        return response()->json(['message' => 'Perfil eliminado exitosamente.']);
    }
}
