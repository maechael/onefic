<?php

namespace app\modules\v1\controllers;

use app\modules\v1\resource\EquipmentIssueRepair;
use Exception;
use Yii;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class EquipmentIssueRepairController extends ActiveController
{
    public $modelClass = EquipmentIssueRepair::class;
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
                $issue = $model->equipmentIssue;
                $issue->status = $model->issue_status;

                $flag = $issue->save();
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
