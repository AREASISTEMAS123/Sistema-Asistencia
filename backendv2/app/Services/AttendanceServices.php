<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Attendance;
use App\Repositories\AttendanceRepositories\AttendanceRepositoryInterface;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;
use App\Models\Justification;

class AttendanceServices {
    protected $attendanceRepository;

    public function __construct(AttendanceRepositoryInterface $attendanceRepository) {
        $this->attendanceRepository = $attendanceRepository;
    }

    public function getAllAttendances() {
        return $this->attendanceRepository->all();
    }

    private function isLateForCheckIn($checkInTime) {
        $checkInLimit = new DateTime('08:11', new DateTimeZone('America/Lima'));
        $checkInTime = new DateTime($checkInTime, new DateTimeZone('America/Lima'));
    
        return $checkInTime > $checkInLimit;
    }
      
    private function uploadImage($image) {
        // Subir imagen al servidor
        $file = $image;
        $folderName = date("Y-m-d"); 
        $path = "attendances/" . $folderName; 
        $filename = time() . "-" . $file->getClientOriginalName();
        $file->move($path, $filename);  

        return $path . "/" . $filename;
    }

    private function hasJustification() {
        $today = date('Y-m-d');
        $authUser = auth()->user();
        
        $justificationExists = Justification::where('user_id', $authUser->id)
            ->whereDate('justification_date', $today) //Falta condicional del status != 3
            ->first('type');
        
        return $justificationExists->type; // 0 | 1
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
            ->first(); 
    
        if (empty($attendance_find)) {
            // Creamos el registro de asistencia
            $new_attendance = new Attendance;
    
            $new_attendance->user_id = $authUser->id;
    
            $new_attendance->date = date('Y-m-d');
            $new_attendance->admission_time = date('H:i');

            // Verificar si llegó tarde al check-in
            if ($this->isLateForCheckIn($new_attendance->admission_time)) {
                
                // Verificar si existe una justificación y actualizar la columna justifications
                $type = $this->hasJustification(); 

                // El usuario llegó tarde
                if ($type == 1){
                    $new_attendance->justification = 1;
                    $new_attendance->delay = 1;
                } else if ($type == 0){
                    $new_attendance->justification = 1;
                    $new_attendance->absence = 1;
                } else {
                    $new_attendance->delay = 1;
                }
            } else {
                // El usuario llegó temprano
                $new_attendance->attendance = 1;
            }

            $path = $this->uploadImage($data['admission_image']);

            //Actualizacion de ruta de la imagen de salida
            $new_attendance->admission_image = $path;
    
            $new_attendance->save();
            return $new_attendance;

        } else {
            // Actualizamos el registro de asistencia existente
            $attendance_find->departure_time = date('H:i');

            $path = $this->uploadImage($data['departure_image']);

            //Actualizacion de ruta de la imagen de salida
            $attendance_find->departure_image = $path;  

            $attendance_find->save();
            return $attendance_find;
        }
    }
}