<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function getFilteredUsers(array $filters): LengthAwarePaginator
    {
        $query = User::query()->with('position.core.department');

        if (!empty($filters['s'])) {
            $query->whereHas('position', fn ($q) => $q->where('shift', $filters['s']));
        }

        if (!empty($filters['d'])) {
            $query->whereHas('position.core.department', fn ($q) => $q->where('name', $filters['d']));
        }

        if (!empty($filters['n'])) {
            $query->where(function ($q) use ($filters) {
            $q->where('name', 'LIKE', '%' . $filters['n'] . '%')
            ->orWhere('surname', 'LIKE', '%' . $filters['n'] . '%');
            });
        }

        if (!empty($filters['c'])) {
            $query->whereHas('position.core', fn ($q) => $q->where('name', $filters['c']));
        }

        return $query->paginate(15);
    }
}
