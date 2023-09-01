<?php

declare(strict_types=1);

namespace App\Repositories\EvaluationRepositories;

use App\Models\Evaluations;

interface EvaluationRepositoryInterface {
    public function all(): iterable;
    public function find(int $id): ?Evaluations;
    public function create(array $data): Evaluations;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}