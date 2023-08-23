<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Attendance;
use App\Repositories\AttendanceRepositories\AttendanceRepositoryInterface;

class AttendanceService {
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
        
        // Creamos el registro de asistencia
        $attendance = new Attendance;
        $attendance->authUser = $authUser->id;
        $attendance->date = date('Y-m-d');
        $attendance->save();
        
        return $this->attendanceRepository->create($data);
    }
}