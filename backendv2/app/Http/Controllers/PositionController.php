<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProfileService;

class ProfileController extends Controller {
    protected $profileService;

    public function __construct(ProfileService $profileService) {
        $this->profileService = $profileService;
    }

    public function getProfiles() {
        $profiles = $this->profileService->getAllProfiles();
        return response()->json($profiles);
    }

    public function createProfile(Request $request) {
        $profile = $this->profileService->createProfile($request->all());
        if (!$profile) {
            return response()->json(['message' => 'Nucleo no encontrado.'], 404);
        }
        return response()->json(['message' => 'Perfil creado exitosamente.', 'data' => $profile], 201);
    }

    public function updateProfile(Request $request, $id) {
        $updated = $this->profileService->updateProfile($id, $request->all());
        if (!$updated) {
            return response()->json(['message' => 'Nucleo no encontrado o perfil no encontrado.'], 404);
        }
        return response()->json(['message' => 'Perfil actualizado exitosamente.']);
    }

    public function deleteProfile($id) {
        $deleted = $this->profileService->deleteProfile($id);
        if (!$deleted) {
            return response()->json(['message' => 'Perfil no encontrado.'], 404);
        }
        return response()->json(['message' => 'Perfil eliminado exitosamente.']);
    }
}
