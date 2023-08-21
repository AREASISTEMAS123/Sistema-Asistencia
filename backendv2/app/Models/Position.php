<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'cores_id',
    ];

    public function department()
    {
        return $this->belongsTo(Core::class, 'cores_id', 'id');
    }
}
