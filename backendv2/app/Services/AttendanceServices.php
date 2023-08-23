<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Attendance;
use App\Repositories\AttendanceRepositories\AttendanceRepositoryInterface;
use Illuminate\Http\Request;

class AttendanceServices {
    protected $attendanceRepository;

    public function __construct(AttendanceRepositoryInterface $attendanceRepository) {
        $this->attendanceRepository = $attendanceRepository;
    }

    public function getAllAttendances() {
        return $this->attendanceRepository->all();
    }

    private function getCheckInTimeForUser($userId) {
        // Lógica para obtener hora cheque de entrada de usuario 
      }
      
    private function uploadImage($image) {
        // Subir imagen al servidor
    }

    public function store(array $data) 
    {
        // Obtener usuario autenticado
        $authUser = auth()->user();
        
        // Obtener el registro de asistencia del usuario para la fecha actual
        $attendance = Attendance::where('user_id', $authUser)
            ->whereDate('date', date('Y-m-d'))
            ->first();

        if (empty($attendance)) {
            // Creamos el registro de asistencia
            $attendance = new Attendance;

            $attendance->user_id = $authUser->id;
        
            $attendance->date = date('Y-m-d');
            $attendance->admission_time = date('H:i');
            $attendance->admission_image = $data['admission_image'];

            $attendance->save();
            
            echo "CREATE_ATTENDANCE";
            return $this->attendanceRepository->create($data);

        } else {
            $attendance_id = $attendance->id;
            $attendance->departure_time = date('H:i');
            $attendance->departure_image = $data['departure_image'];

            echo "UPDATE_ATTENDANCE";
            return $this->attendanceRepository->update($attendance_id, $data);
        }
    }
}