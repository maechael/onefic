<?php

namespace app\modules\v1\controllers;

use app\modules\v1\resource\ChecklistCriteria;
use app\modules\v1\resource\MaintenanceChecklistLog;
use Exception;
use Yii;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class MaintenanceChecklistLogController extends ActiveController
{
    public $modelClass = MaintenanceChecklistLog::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        //..insert behavior setup code here
        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        //..insert action changes here
        unset($actions['create']);
        return $actions;
    }

    public function actionCreate()
    {
        $model = new $this->modelClass(['scenario' => $this->modelClass::SCENARIO_CUSTOM]);
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($flag = $model->save()) {
                foreach ($model->criteriaResults as $i => $result) {
                    $criteria = new ChecklistCriteria();
                    $data['ChecklistCriteria'] = $result;
                    $criteria->load($data);

                    $criteria->link('maintenanceChecklistLog', $model);
                }

                if ($flag) {
                    $transaction->commit();
                    $response = Yii::$app->getResponse();
                    $response->setStatusCode(201);
                } else {
                    $transaction->rollBack();
                    throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
                }
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }
}
