<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'admission_time',
        'departure_time',
        'admission_image',
        'departure_image',
        'attendance',
        'absence',
        'justification',
        'delay',
        'non_working_days',
        'date',
        'user_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeFilter(Builder $query, array $filters) {
        if (!empty($filters['date'])) {
            $carbon = new \Carbon\Carbon;
            $date = $carbon->parse($filters['date'])->format('Y-m-d');
            $query->whereDate('date', $date);
        }
    
        if (!empty($filters['position'])) {
            $query->whereHas('user.position', fn($q) => 
                $q->where('name', $filters['position'])
            );
        }
    
        if (!empty($filters['nucleo'])) {
            $query->whereHas('user.position.core', fn($q) => 
                $q->where('name', $filters['nucleo'])
            );
        }
    
        if (!empty($filters['department'])) {
            $query->whereHas('user.position.core.department', fn($q) => 
                $q->where('name', $filters['department'])
            );
        }
    
        if (!empty($filters['shift'])) {
            $query->whereHas('user.position', fn($q) => 
                $q->where('shift', $filters['shift'])
            );
        }
    
        return $query->paginate(10);
    }
}
