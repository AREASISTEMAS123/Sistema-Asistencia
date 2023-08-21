<?php

declare(strict_types=1);

namespace App\Repositories\ProfileRepositories;

use App\Models\Profile;

interface ProfileRepositoryInterface {
    public function all(): iterable;
    public function find(int $id): ?Profile;
    public function create(array $data): Profile;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}