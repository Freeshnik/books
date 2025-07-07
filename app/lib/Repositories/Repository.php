<?php

declare(strict_types=1);

namespace App\Repositories;

use App\ActiveRecord;
use yii\db\Exception;
use yii\db\StaleObjectException;

abstract class Repository implements RepositoryInterface
{
    /**
     * @throws Exception
     */
    public function save(ActiveRecord $activeRecord, bool $runValidation = true, ?array $attributeNames = null): bool
    {
        return $activeRecord->save(runValidation: $runValidation, attributeNames: $attributeNames);
    }

    /**
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function delete(ActiveRecord $activeRecord): bool|int
    {
        return $activeRecord->delete();
    }

    public function findOneByConditions(array $conditions): ?ActiveRecord
    {
        return ActiveRecord::findOne($conditions);
    }
}
