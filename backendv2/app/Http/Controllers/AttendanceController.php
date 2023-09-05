<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AttendanceServices;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    protected $attendanceService;

    public function __construct(AttendanceServices $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function index(Request $request)
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

    public function show($id)
    {
        //
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