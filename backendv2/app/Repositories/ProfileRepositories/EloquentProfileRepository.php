<?php

declare(strict_types=1);

namespace App\Repositories\ProfileRepositories;

use App\Models\Profile;
use App\Repositories\ProfileRepositories\ProfileRepositoryInterface;

class EloquentProfileRepository implements ProfileRepositoryInterface {

    public function all(): iterable {
        return Profile::all();
    }

    public function find(int $id): ?Profile {
        return Profile::find($id);
    }

    public function create(array $data): Profile {
        return Profile::create($data);
    }

    public function update(int $id, array $data): bool {
        $profile = $this->find($id);
        if ($profile) {
            return $profile->update($data);
        }
        return false;
    }

    public function delete(int $id): bool {
        $profile = $this->find($id);
        if ($profile) {
            return $profile->delete();
        }
        return false;
    }
}
