<?php

namespace App;

class Model extends \yii\base\Model
{
    public bool $isNewRecord = true;

    /** @var  ActiveRecord */
    protected ActiveRecord $entity;

    /**
     * @param null|ActiveRecord $activeRecord
     */
    public function __construct(?ActiveRecord $activeRecord = null, array $config = [])
    {
        if ($activeRecord) {
            $this->entity = $activeRecord;
            $this->isNewRecord = $this->entity->isNewRecord;
        }
        parent::__construct($config);
    }
}
