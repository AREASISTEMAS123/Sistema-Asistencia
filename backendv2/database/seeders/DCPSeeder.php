<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Core;
use App\Models\Position;
use App\Models\EvaluationTypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DCPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'name' => 'Operativo'
        ]);
        
        Core::create([
            'name' => 'Sistemas',
            'department_id' => 1
        ]);

        Position::create([
            'name' => 'Backend',
            'core_id' => 1
        ]);

        EvaluationTypes::create([
            'name' => 'Softskills',
        ]);
    }
}
