<?php

namespace app\modules\ficModule\controllers;

use app\modules\ficModule\models\Supplier;
use app\modules\ficModule\models\SupplierSearch;
use Yii;
use yii\web\NotFoundHttpException;

class SupplierController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new SupplierSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $supplier = $this->findModel($id);
        $filePreviews = [];
        $previewConfigs = [];
        //..shortcut version of getting filepaths as array
        // $filePreviews = ArrayHelper::getColumn($supplier->medias, 'filepath');
        foreach ($supplier->medias as $media) {
            $filePreviews[] = $media->link;
            $previewConfigs[] = array("type" => $media->previewType, "caption" => $media->basename, "key" => $media->id);
        }

        return $this->render('view', [
            'model' => $supplier,
            'filePreviews' => $filePreviews,
            'previewConfigs' => $previewConfigs
        ]);
    }

    /**
     * Finds the Supplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Supplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Supplier::findOne($id)) !== null) {
            // $model->province_id = $model->municipalityCity->province_id;
            // $model->region_id = $model->municipalityCity->region_id;
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
