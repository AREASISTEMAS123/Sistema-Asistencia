<?php

declare(strict_types=1);

namespace App\Repositories\EvaluationRepositories;

use App\Models\Evaluations;

class EloquentEvaluationsRepository implements EvaluationRepositoryInterface {

    public function all(): iterable {
        return Evaluations::all();
    }

    public function find(int $id): ?Evaluations{
        return Evaluations::find($id);
    }

    public function create(array $data): Evaluations {
        return Evaluations::create($data);
    }

    public function update(int $id, array $data): bool {
        $evaluations = $this->find($id);
        if ($evaluations) {
            return $evaluations->update($data);
        }
        return false;
    }

    public function delete(int $id): bool {
        $evaluations = $this->find($id);
        if ($evaluations) {
            return $evaluations->delete();
        }
        return false;
    }
}