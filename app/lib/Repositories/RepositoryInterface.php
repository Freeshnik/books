<?php

declare(strict_types=1);

namespace App\Repositories;

use App\ActiveRecord;

interface RepositoryInterface
{
    public function save(ActiveRecord $activeRecord, bool $runValidation = true, ?array $attributeNames = null): bool;

    public function delete(string $className, int $id): bool|int;

    public function findOneByConditions(string $activeRecordClass, array $conditions): ?ActiveRecord;
}
