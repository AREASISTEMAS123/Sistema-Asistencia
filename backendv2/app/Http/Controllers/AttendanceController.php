<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Position;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Recogemos el ID del usuario logeado
        $user_id = auth()->id();

        // Obtener el registro de asistencia del usuario para la fecha actual
        $attendance = Attendance::where('user_id', $user_id)
            ->whereDate('date', date('Y-m-d'))
            ->first();

        // Recogemos los datos del turno del usuario logeado (shift)
        $user_profile = Position::where('user_id', $user_id)->get();

        // Si el turno es tarde, la hora de salida es a las 19:00:00, si es mañana, a las 13:00:00
        $departure_hour = $user_profile[0]['shift'] == 'Tarde' ? '19:01:00' : '13:01:00';

        if (empty($attendance)) {
            // No existe un registro de asistencia para la fecha actual, crear uno nuevo
            $attendance = new Attendance();

            // Recogemos los valores de fecha y tiempo de marcado de entrada
            $attendance->date = $request->input('date');
            $attendance->admission_time = $request->input('admission_time');

            // Si el turno es tarde, la hora de entrada es a las 14:11:00, si es mañana, a las 08:11:00
            $hora = $user_profile[0]['shift'] == 'Tarde' ? '14:11:00' : '08:11:00';

            // Aumentamos los valores de asistencia o tardanza dependiendo de la condicional
            if ($attendance->admission_time >= $hora) {
                $attendance->delay = 1;
            } else {
                $attendance->attendance = 1;
            }

            // Recogemos el ID del usuario logeado
            $attendance->user_id = $user_id;

            if ($request->hasFile("admission_image")) {
                // Recogemos la imagen de entrada
                $file = $request->file("admission_image");
                $folderName = date("Y-m-d"); // Obtiene la fecha de hoy en formato "año-mes-día"
                $path = "attendance/" . $folderName; // Ruta de la carpeta con la fecha de hoy
                $filename = time() . "-" . $file->getClientOriginalName();
                $uploadSuccess = $file->move($path, $filename);
                $attendance->admission_image = $path . "/" . $filename;

            } else {
                // Retornar error si la imagen no existe
                return response()->json(['message' => 'Se requiere una imagen']);
            }

            // Guardamos los cambios en la base de datos
            $attendance->save();

            // Retornamos la respuesta en formato JSON
            return response()->json(['attendance' => $attendance]);

        } else {

            $existingAttendance = $request->input('admission_time');

            if ($existingAttendance != null) {
                // Ya se ha registrado la asistencia para esta fecha y usuario
                return response()->json(['message' => 'Ya has marcado asistencia para hoy']);
            }

            // La hora actual es mayor que la de salida, si no marcó hora de salida, se le marca falta.
            if ($departure_hour < date('H:i:s') && is_null($attendance->departure_time)) {

                // Seteamos los valores de asistencia o tardanza dependiendo de la condicional
                $attendance->delay = 0;
                $attendance->attendance = 0;
                $attendance->absence = 1;

                // Guardamos los cambios en la base de datos
                $attendance->save();

                // Retornamos la respuesta en formato JSON
                return response()->json(['attendance' => $attendance]);
            }

            // Existe un registro de asistencia para la fecha actual
            if (is_null($attendance->departure_time)) {

                // Actualizar el registro existente con la hora de salida
                $attendance->departure_time = $request->input('departure_time');

                if ($request->hasFile("departure_image")) {

                    // Recogemos la imagen de salida
                    $file = $request->file("departure_image");
                    $folderName = date("Y-m-d"); // Obtiene la fecha de hoy en formato "año-mes-día"
                    $path = "attendance/" . $folderName; // Ruta de la carpeta con la fecha de hoy
                    $filename = time() . "-" . $file->getClientOriginalName();
                    $uploadSuccess = $file->move($path, $filename);
                    $attendance->departure_image = $path . "/" . $filename;

                } else {
                    // Retornar error si la imagen no existe
                    return response()->json(['message' => 'Se requiere una imagen']);
                }

                // Guardamos los cambios en la base de datos
                $attendance->save();

                // Retornamos la respuesta en formato JSON
                return response()->json(['attendance' => $attendance]);

            } else {
                // Retornar error de marcado de asistencia
                return response()->json(['error' => 'Ya marcaste asistencia']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
