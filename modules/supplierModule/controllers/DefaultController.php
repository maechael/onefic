<?php

namespace app\modules\supplierModule\controllers;

use yii\web\Controller;

/**
 * Default controller for the `supplierModule` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTest()
    {
        return $this->render('test');
    }
}
