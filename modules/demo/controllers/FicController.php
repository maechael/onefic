<?php

namespace app\modules\demo\controllers;

class FicController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionWate()
    {
        return $this->render('wate');
    }
}
