<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AttendanceService;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function getAttendances(Request $request)
    {
        $filters = $request->all(); 
        $attendances = $this->attendanceService->getFilteredAttendances($filters);
        return response()->json($attendances);
    }

    public function createAttendance(Request $request)
    {
        $attendance = $this->attendanceService->store($request->all());
        return response()->json(['message' => 'Asistencia marcada con exito', 'data' => $attendance]);
    }

    public function show()
    {
        //Recogemos el ID del usuario logeado
        $user_id = auth()->id();

        // Obtener el registro de asistencia del usuario para el usuario actualmente logeado
        $attendance = Attendance::where('user_id', $user_id)->get();

        //Retornamos la respuesta en formato JSON
        return response()->json(['attendance' => $attendance]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
