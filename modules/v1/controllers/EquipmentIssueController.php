<?php

namespace app\modules\v1\controllers;

use app\models\EquipmentIssueImage;
use app\models\IssueRelatedPart;
use app\models\LocalMedia;
use app\models\Metadata;
use app\modules\v1\resource\EquipmentIssue;
use Exception;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\rest\Controller;
use yii\web\Response;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class EquipmentIssueController extends ActiveController
{
    public $modelClass = EquipmentIssue::class;
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

        // $behaviors['verbs'] = [
        //     'class' => VerbFilter::class,
        //     'actions' => [
        //         'media' => ['POST']
        //     ],
        // ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        //..insert action changes here
        unset($actions['create']);
        // unset($actions['update']);
        // unset($actions['view']);
        return $actions;
    }

    public function actionCreate()
    {
        $model = new $this->modelClass(['scenario' => $this->modelClass::SCENARIO_CUSTOM]);
        // $test = Yii::$app->getRequest()->getBodyParams();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->equipmentIssueImgs = UploadedFile::getInstancesByName('equipmentIssueImgs');
            $relatedPartIds = Json::decode($model->relatedPartIds);
            $relatedComponentIds = Json::decode($model->relatedComponentIds);

            if ($flag = $model->save()) {
                if (!empty($relatedPartIds)) {
                    foreach ($relatedPartIds as $partId) {
                        $issueRelatedPart = new IssueRelatedPart();
                        $issueRelatedPart->equipment_issue_id = $model->id;
                        $issueRelatedPart->component_part_id = $partId;
                        $issueRelatedPart->type = IssueRelatedPart::TYPE_PART;

                        if (!$flag = $issueRelatedPart->save())
                            break;
                    }
                }

                if (!empty($relatedComponentIds)) {
                    foreach ($relatedComponentIds as $componentId) {
                        $issueRelatedPart = new IssueRelatedPart();
                        $issueRelatedPart->equipment_issue_id = $model->id;
                        $issueRelatedPart->component_part_id = $componentId;
                        $issueRelatedPart->type = IssueRelatedPart::TYPE_COMPONENT;

                        if (!$flag = $issueRelatedPart->save())
                            break;
                    }
                }

                if ($flag) {
                    foreach ($model->equipmentIssueImgs as $image) {
                        $media = new LocalMedia();
                        $media->set($image, Yii::$app->params["equipment_issue_folder"]);

                        if ($flag = $flag && $media->save()) {
                            $equipmentIssueImage = new EquipmentIssueImage();
                            $equipmentIssueImage->equipment_issue_id = $model->id;
                            $equipmentIssueImage->local_media_id = $media->id;

                            if ($flag = $flag && $equipmentIssueImage->save()) {
                                $flag = $media->upload($image);
                            } else {
                                break;
                            }
                        } else {
                            break;
                        }
                    }
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

    public function actionMedia()
    {
        $model = new $this->modelClass(['scenario' => $this->modelClass::SCENARIO_UPLOAD]);
        // $model->load(Yii::$app->getRequest()->post(), '');
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->equipmentIssueImgs = UploadedFile::getInstances($model, 'equipmentIssueImgs');
        // $test = UploadedFile::getInstancesByName('equipmentIssueImgs');
        return ['test' => 'tickle'];
    }
}
