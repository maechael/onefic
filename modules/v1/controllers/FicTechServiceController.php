<?php

namespace app\modules\v1\controllers;

use app\modules\v1\resource\FicTechService;
use yii\rest\ActiveController;
use yii\web\Response;

class FicTechServiceController extends ActiveController
{
    public $modelClass = FicTechService::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }
}
