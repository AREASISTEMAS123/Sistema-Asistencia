<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Core;
use App\Models\Profile;

class ProfileController extends Controller
{
    // Mostrar todos los nucleos
    public function getProfiles()
    {
        $profile = Profile::all();
        return response()->json($profile);
    }
    
    // Crear un nuevo nucleo en la base de datos
    public function createProfile(Request $request)
    {       
        //Creamos un nuevo objeto Cores
        $profile = new Profile();
    
        //Setear los valores en la tabla Cores
        $profile->name = $request->input('name');

        //Validamos que el departamento exista en la base de datos
        if (Core::find($request->input('core_id'))) {
            //Setear los valores en la tabla Cores
            $profile->cores_id = $request->input('core_id');
            //Guardamos los valores en la tabla Cores
            $profile->save();
        } else {
            return response()->json(['message' => 'Nucleo no encontrado.'], 404);
        }
    
        //Retornamos la respuesta en formato JSON
        return response()->json(['message' => 'Perfil creado exitosamente.', 'data' => $profile], 201);
    }
    
    // Actualizar un perfil en la base de datos
    public function updateProfile(Request $request, $id)
    {   
        //Buscamos el perfil por id
        $profile = Profile::find($id);

        //Validamos que el perfil exista en la base de datos
        if (!$profile) {
            return response()->json(['message' => 'Perfil no encontrado.'], 404);
        } else {

            //Setear los valores en la tabla Profile
            $profile->name = $request->input('name');

            //Validamos que el nucleo exista en la base de datos
            if (Core::find($request->input('core_id'))) {
                //Setear los valores en la tabla Cores
                $profile->cores_id = $request->input('core_id');
                //Guardamos los valores en la tabla Cores
                $profile->save();
            } else {
                return response()->json(['message' => 'Nucleo no encontrado.'], 404);
            }

            //Actualizamos los valores en la tabla Departments
            $profile->update();

            //Retornamos la respuesta en formato JSON
            return response()->json(['message' => 'Perfil actualizado exitosamente.', 'data' => $profile]);
        }
    }

    // Borrar un perfil en la base de datos
    public function deleteProfile($id)
    {
        $profile = Profile::find($id);

        //Validamos que el nucleo exista en la base de datos
        if (!$profile) {
            return response()->json(['message' => 'Perfil no encontrado.'], 404);
        } else {
            //Borramos el nucleo
            $profile->delete();
            //Retornamos la respuesta en formato JSON
            return response()->json(['message' => 'Perfil eliminado exitosamente.']);
        }
    }
}