<?php

declare(strict_types=1);

namespace App\Repositories;

use App\ActiveRecord;

interface RepositoryInterface
{
    public function findById(int $id): ?ActiveRecord;
    public function save(ActiveRecord $model): ActiveRecord;
    public function delete(ActiveRecord $model): bool;
    public function findByConditions(array $conditions): array;
}
