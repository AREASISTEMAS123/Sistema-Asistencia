<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'note',
        'evaluations_id'
    ];
    
    public function evaluation()
    {
      return $this->belongsTo(Evaluation::class);
    }
}
