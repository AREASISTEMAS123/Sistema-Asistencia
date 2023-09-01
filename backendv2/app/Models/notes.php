<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notes extends Model
{
    use HasFactory;

    protected $fillable = [
        'note',
        'evaluations_id'
    ];
    // evaluation_id
    public function evaluation() {
        return $this->belongsTo(Evaluations::class, 'evaluations_id', 'id');
    }
}
