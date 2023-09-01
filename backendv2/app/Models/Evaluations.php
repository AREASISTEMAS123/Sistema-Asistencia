<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluations extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'user_id',
        'evaluation_type'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function evaluation_type() {
        return $this->belongsTo(Evaluation_Type::class, 'evaluation_type', 'id');
    }
}
