<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function cores()
    {
        return $this->hasMany(Core::class, 'department_id', 'id');
    }
}
