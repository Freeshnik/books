<?php

namespace App;

class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        foreach ($this->getAttributes() as $key => $value) {
            if ($value instanceof \DateTime) {
                $this->setAttribute($key, $value->format('Y-m-d H:i:s'));
            }
        }
        return parent::beforeSave($insert);
    }
}
