<?php

namespace app\modules\ficModule\controllers;

use Yii;

class FicController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $test = Yii::$app->user->identity;
        return $this->render('index', [
            'fic' => Yii::$app->user->identity->userProfile->fic
        ]);
    }
}
