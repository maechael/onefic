<?php

namespace app\modules\ficModule;

use Yii;

/**
 * ficModule module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\ficModule\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->layout = 'main';
        Yii::$app->user->loginUrl = ['/fic-module/auth/login'];
    }
}
