<?php

namespace app\modules\v1\behaviors;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

class GlobalIdBehavior extends AttributeBehavior
{
    public $globalIdAttribute = 'global_id';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->globalIdAttribute],
            ];
        }
    }

    protected function getValue($event)
    {
        if ($this->value === null) {
            return Yii::$app->security->generateRandomString();
        }

        return parent::getValue($event);
    }
}
