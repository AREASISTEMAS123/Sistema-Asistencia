<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'core_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function department()
    {
        return $this->belongsTo(Core::class, 'core_id', 'id');
    }
}
