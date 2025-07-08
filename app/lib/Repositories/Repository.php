<?php

declare(strict_types=1);

namespace App\Repositories;

use App\ActiveRecord;
use RuntimeException;
use yii\db\Exception;

abstract class Repository implements RepositoryInterface
{
    /** Класс модели
     * @return string
     */
    abstract protected function getModelClass(): string;

    /**
     * @param int $id
     * @return ActiveRecord|null
     */
    public function findById(int $id): ?ActiveRecord
    {
        $modelClass = $this->getModelClass();
        return $modelClass::findOne($id);
    }

    /**
     * @param ActiveRecord $model
     * @return ActiveRecord
     * @throws Exception
     */
    public function save(ActiveRecord $model): ActiveRecord
    {
        if (!$model->save(false)) {
            throw new \RuntimeException('Error while saving model with class ' . get_class($model));
        }

        return $model;
    }

    /**
     * @param ActiveRecord $model
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function delete(ActiveRecord $model): bool
    {
        if (!$model->delete()) {
            throw new RuntimeException('Error while deleting model with class ' . get_class($model));
        }

        return true;
    }
}
