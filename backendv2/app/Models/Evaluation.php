<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'user_id',
        'evaluation_type'
    ];

    public function evaluationType() 
    {
      return $this->belongsTo(EvaluationType::class);
    }
    
    public function notes()  
    {
      return $this->hasMany(Note::class); 
    }
}