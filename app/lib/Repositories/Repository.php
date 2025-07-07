<?php

declare(strict_types=1);

namespace App\Repositories;

use App\ActiveRecord;
use App\Models\Author;
use App\Models\Book;
use DomainException;
use RuntimeException;
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
     * @param string $className
     * @param int $id
     * @return bool|int
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function delete(string $className, int $id): bool|int
    {
        $model = $this->findOneByConditions($className, ['id' => $id]);
        if (!$model) {
            throw new DomainException('Model of class ' . $className . ' not found.');
        }

        return $model->delete();
    }

    /**
     * @param string $activeRecordClass
     * @param array $conditions
     * @return ActiveRecord|null
     */
    public function findOneByConditions(string $activeRecordClass, array $conditions): ?ActiveRecord
    {
        return $activeRecordClass::findOne($conditions);
    }

    /**
     * @param ActiveRecord $model
     * @return ActiveRecord|Book|Author
     * @throws Exception
     */
    public function update(ActiveRecord $model): ActiveRecord
    {
        if (!$model->save(false)) {
            throw new RuntimeException('Error while saving model.');
        }

        return $model;
    }
}
