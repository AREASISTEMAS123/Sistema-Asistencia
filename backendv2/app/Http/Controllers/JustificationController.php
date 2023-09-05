<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Attendance;
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
        return response()->json(['message' => 'Justificacion creada exitosamente.', 'data' => $justification], 201);
    }

    public function acceptJustifications($id) {
    if (!is_numeric($id) || $id <= 0) {
        return response()->json(['error' => 'ID inválido.'], 400); 
    }

    $justification = $this->justificationService->acceptJustification($id);

    if (!$justification) {
        return response()->json(['error' => 'Justificación no encontrada.'], 404);
    }

    $attendance = new Attendance();
    $attendance->justification_id = $justification->id;
    $attendance->status = 'falta';

        return response()->json(['message' => 'Justificacion aceptada exitosamente.', 'data' => $justification], 201);
    }

    public function declineJustifications($id) {
        $justification = $this->justificationService->declineJustification($id);
        return response()->json(['message' => 'Justificacion rechazada exitosamente.', 'data' => $justification], 201);
    }

}