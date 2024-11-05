<?php

namespace app\modules\v1\resource;

use app\models\FicEquipment as ModelsFicEquipment;
use app\modules\v1\behaviors\GlobalIdBehavior;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;

class FicEquipment extends ModelsFicEquipment
{
    public function behaviors()
    {
        return [
            [
                'class' => GlobalIdBehavior::class
            ]
        ];
    }
}
