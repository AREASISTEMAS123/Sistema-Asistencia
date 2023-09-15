<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function getAttendanceAttribute($value)
    {
        return $value ? 1 : 0;
    }

    // Mutador para el campo 'justification'
    public function getJustificationAttribute($value)
    {
        return $value ? 1 : 0;
    }

    // Mutador para el campo 'delay'
    public function getDelayAttribute($value)
    {
        return $value ? 1 : 0;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeFilter(Builder $query, array $filters, $userShift = null, $userCore = null, $currentDate = null)
    {
        $query->with('user.roles', 'user.position.core.department');

        // Filtrar por fecha actual si no se proporciona una fecha
        $date = !empty($filters['date']) ? $filters['date'] : $currentDate;
        if (!empty($date)) {
            $query->whereDate('date', '=', $date);
        }

        // Filtrar por núcleo
        if (!empty($filters['core']) || !empty($userCore)) {
            $coreId = !empty($filters['core']) ? $filters['core'] : $userCore;
            $query->whereHas('user.position.core', fn($q) => $q->where('id', $coreId));
        }

        // Filtrar por departamento
        if (!empty($filters['department'])) {
            $query->whereHas('user.position.core.department', fn($q) => $q->where('id', $filters['department']));
        }

        // Filtrar por turno
        if (!empty($filters['shift']) || !empty($userShift)) {
            $shift = !empty($filters['shift']) ? $filters['shift'] : $userShift;
            $query->whereHas('user.position', fn($q) => $q->where('shift', $shift));
        }

        return $query;
    }

}
