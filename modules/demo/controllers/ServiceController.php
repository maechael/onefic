<?php

namespace app\modules\demo\controllers;

class ServiceController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionWaterRetort()
    {
        return $this->render('water-retort');
    }
    public function actionVaccumFryer()
    {
        return $this->render('vaccum-fryer');
    }
}
