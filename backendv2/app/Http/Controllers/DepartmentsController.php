<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Department;


class DepartmentsController extends Controller
{
    // Mostrar todos los departamentos
    public function getDepartments()
    {
        $departments = Department::all();
        return response()->json($departments);
    }

    // Crear un nuevo departamento en la base de datos
    public function createDepartment(Request $request)
    {       
        //Creamos un nuevo objeto Departaments
        $department = new Department();

        //Setear los valores en la tabla Departments
        $department->name = $request->input('name');

        //Guardamos los valores en la tabla Departments
        $department->save();

        //Retornamos la respuesta en formato JSON
        return response()->json(['message' => 'Departamento creado exitosamente.', 'data' => $department], 201);
    }

    // Actualizar un departamento en la base de datos
    public function updateDepartment(Request $request, $id)
    {   
        //Buscamos el departmento por id
        $department = Department::find($id);

        //Validamos que el departamento exista en la base de datos
        if (!$department) {
            return response()->json(['message' => 'Departamento no encontrado.'], 404);
        } else {
            //Setear los valores en la tabla Departments
            $department->name = $request->input('name');

            //Actualizamos los valores en la tabla Departments
            $department->update();

            //Retornamos la respuesta en formato JSON
            return response()->json(['message' => 'Departamento actualizado exitosamente.', 'data' => $department]);
        }
    }

    public function deleteDepartment($id)
    {
        $department = Department::find($id);

        //Validamos que el departamento exista en la base de datos
        if (!$department) {
            return response()->json(['message' => 'Departamento no encontrado.'], 404);
        } else {
            //Borramos el departmento
            $department->delete();

            //Retornamos la respuesta en formato JSON
            return response()->json(['message' => 'Departamento eliminado exitosamente.']);
        }
    }
}