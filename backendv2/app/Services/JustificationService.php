<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Attendance;
use App\Models\Justification;
use App\Repositories\JustificationRepositories\JustificationRepositoryInterface;

class JustificationService {
    protected $justificationRepository;

    public function __construct(JustificationRepositoryInterface $justificationRepository) {
        $this->justificationRepository = $justificationRepository;
    }

    public function getAllJustifications() {
        return $this->justificationRepository->all();
    }
    public function detailsJustification($id)
    {
        $justification = Justification::with('User.role')->where('id', $id)->get();
        return response()->json($justification);
    }

    private function uploadImage($image) {
        // Subir imagen al servidor
        $file = $image;
        $folderName = date("Y-m-d");
        $path = "justifications/" . $folderName;
        $filename = time() . "-" . $file->getClientOriginalName();
        $file->move($path, $filename);

        return $path . "/" . $filename;
    }

    public function createJustification(array $data) {
        //Por default el status == 3 (En Proceso)
        $data["status"] = 3;

        //Por default el usuario logueado
        $user_id = auth()->id();
        $data["user_id"] = $user_id;

        //Redireccion de imagen a carpeta local
        $data['evidence'] = $this->uploadImage($data['evidence']);

        //Guardado de ruta en base de datos
        //$data["justification_date"] = $data["justification_date"];

        return $this->justificationRepository->create($data);
    }

    public function acceptJustification($id) {
        $justification = Justification::find($id);
        $date = $justification->justification_date;
        $user = $justification->user_id;

        $att = Attendance::where('user_id',$user)->where('date',$date)->exists();

        if ( $att == 'true'){

            $att = Attendance::where('user_id', $user)->where('date',$date)->firstOrFail();
            if ($att->user_id == $user && $att->date = $date){

                if($justification->justification_type == '0'){
                    $att->update([
                        'attendance' =>'0',
                        'absence' => '1',
                        'justification' => '1',
                    ]);
                    $justification->update(['justification_status' => '1']);

                    return response()->json([ "message" => "Justificacion acceptado con exito"]);
                }else{
                    $att->update([
                        'justification' => '1',
                    ]);
                    $justification->update(['justification_status' => '1']);

                    return response()->json([ "message" => "Justificacion acceptado con exito"]);
                }

            }

        } else{

            if($justification->justification_type == '0'){
                $attendance = Attendance::create([
                    'user_id' => $user,
                    'absence' => '1',
                    'justification' => '1',
                    'date' => $justification->justification_date
                ]);
                $justification->update(['justification_status' => '1']);

                return response()->json([ "message" => "Justificacion acceptado con exito"]);
            }else{
                $attendance = Attendance::create([
                    'user_id' => $user,
                    'delay' => '1',
                    'justification' => '1',
                    'date' => $justification->justification_date
                ]);
                $justification->update(['justification_status' => '1',]);

                return response()->json([ "message" => "Justificacion acceptado con exito"]);
            }

        }
    }

    public function declineJustification($id) {
        $justification = Justification::find($id);

        if ($justification) {
            if ($justification->status == 2 || $justification->status == 1) {
                return response()->json(['message' => 'Esta justificacion ya ha sido declinada o aceptada'], 201);
            } else {
                $justification->status = 2;
                $justification->save();
                return $justification;
            }
        }
    }

    public function deleteJustification(int $id) {
        return $this->justificationRepository->delete($id);
    }
}
