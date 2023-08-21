<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\JustificationService;
use Illuminate\Http\Request;

class JustificationController extends Controller
{
    protected $justificationService;

    public function __construct(JustificationService $justificationService)
    {
        $this->justificationService = $justificationService;
    }

    public function getJustifications() {
        $justifications = $this->justificationService->getAllJustifications();
        return response()->json($justifications);
    }

    public function createJustifications(Request $request) {
        $justification = $this->justificationService->createJustification($request->all());
        return response()->json(['message' => 'Justificacion creado exitosamente.', 'data' => $justification], 201);
    }

}