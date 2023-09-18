<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AttendanceService;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{

    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function getAttendances(Request $request)
    {
            $user = Auth::user();
            $userShift = $user->shift;
            $position = $user->position->first();
            $userCore = $position ? $position->core->id : null;

            $filters = $request->all();
            $currentDate = now()->format('Y-m-d');


            $attendances = $this->attendanceService->getFilteredAttendances($filters, $userShift, $userCore, $currentDate);

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
        $date = Carbon::now();

        // Obtener el registro de asistencia del usuario para el usuario actualmente logeado
        $attendance = Attendance::where('user_id', $user_id)->where('date', $date)->first();

        //Retornamos la respuesta en formato JSON
        return response()->json(['attendance' => $attendance]);
    }

    public function callDatabaseProcedure()
    {
        DB::statement('select llenar_attendances_user_id();');
    }
}
