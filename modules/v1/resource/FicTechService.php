<?php

namespace app\modules\v1\resource;

use app\models\FicTechService as ModelsFicTechService;
use app\modules\v1\behaviors\GlobalIdBehavior;
use yii\db\BaseActiveRecord;
use yii\behaviors\AttributeBehavior;

class FicTechService extends ModelsFicTechService
{

    public function fields()
    {
        return ['charging_fee', 'charging_type', 'fic', 'equipment', 'techService', 'global_id'];
    }
    public function behaviors()
    {
        return [
            [
                'class' => GlobalIdBehavior::class

            ]
        ];
    }
}
