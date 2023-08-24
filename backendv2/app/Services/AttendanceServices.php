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
        // Establecer la zona horaria a America/Lima
        date_default_timezone_set('America/Lima');

        // Obtener usuario autenticado
        $authUser = auth()->user();
    
        // Obtener el registro de asistencia del usuario para la fecha actual
        $attendance_find = Attendance::where('user_id', $authUser->id)
            ->whereDate('date', date('Y-m-d'))
            ->first(); // Utilizamos 'first' en lugar de 'get' para obtener un solo registro
    
        if (empty($attendance_find)) {
            // Creamos el registro de asistencia
            $new_attendance = new Attendance;
    
            $new_attendance->user_id = $authUser->id;
    
            $new_attendance->date = date('Y-m-d');
            $new_attendance->admission_time = date('H:i');
            $new_attendance->attendance = 1;

            //Captura de la Imagen de Entrada
            $new_attendance->admission_image = $data['admission_image'];

            //Redireccion de imagen a carpeta local
            $file = $data['admission_image'];
            $folderName = date("Y-m-d"); 
            $path = "attendances/" . $folderName; 
            $filename = time() . "-" . $file->getClientOriginalName();
            $file->move($path, $filename);
    
            $new_attendance->save();
            return $new_attendance;
        } else {
            // Actualizamos el registro de asistencia existente
            $attendance_find->departure_time = date('H:i');

            //Redireccion de imagen a carpeta local
            $file = $data['departure_image'];
            $folderName = date("Y-m-d"); 
            $path = "attendances/" . $folderName; 
            $filename = time() . "-" . $file->getClientOriginalName();
            $file->move($path, $filename);

            //Actualizacion de ruta de la imagen de salida
            $attendance_find->departure_image = $data['departure_image'];
    
            $attendance_find->save();
            return $attendance_find;
        }
    }
}