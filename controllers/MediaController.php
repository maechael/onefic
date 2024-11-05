<?php

namespace app\controllers;

use app\models\Metadata;
use Yii;
use yii\helpers\ArrayHelper;

class MediaController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDeleteMedia()
    {
        $id = $_POST['key'];
        $media = Metadata::findOne($id);
        $media->deleteMedia();
        return $this->asJson(['success' => 'true']);
    }

    public function actionStoreForDeleteId()
    {
        $session = Yii::$app->session;
        $id = $_POST['key'];

        if ($session->has('media.ids')) {
            $mediaIds = $session->get('media.ids');
            if (!ArrayHelper::isIn($id, $mediaIds))
                array_push($mediaIds, $id);
            $session['media.ids'] = $mediaIds;
        } else {
            $session['media.ids'] = array($id);
        }

        return $this->asJson(['success' => 'true']);
    }
}
