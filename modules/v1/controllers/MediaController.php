<?php

namespace app\modules\v1\controllers;

use app\modules\v1\resource\Media;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class MediaController extends Controller
{
    public $serializer = [
        'class' => 'yii\rest\Serializer',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
                'application/x-www-form-urlencoded' => Response::FORMAT_JSON,
                'multipart/form-data' => Response::FORMAT_JSON,
            ],
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
        ];

        // $behaviors['verbs'] = [
        //     'class' => VerbFilter::class,
        //     'actions' => [
        //         'upload' => ['POST']
        //     ],
        // ];

        return $behaviors;
    }

    public function actionUpload()
    {
        $model = new Media();
        $test = Yii::$app->getRequest()->post();
        $test2 = Yii::$app->getRequest()->getBodyParams();
        // $model->load(Yii::$app->getRequest()->post(), '');
        $test3 = UploadedFile::getInstancesByName('equipmentIssueImages');
        return ['test' => 'tickle'];
    }
}
