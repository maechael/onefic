<?php

namespace app\controllers;

use app\models\Equipment;
use app\models\EquipmentSearch;
use Yii;
use app\models\EquipmentSpec;
use app\models\EquipmentSpecSearch;
use app\models\Model;
use Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * EquipmentSpecController implements the CRUD actions for EquipmentSpec model.
 */
class EquipmentSpecController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all EquipmentSpec models.
     * @return mixed
     */
    public function actionIndex()
    {
        // $searchModel = new EquipmentSpecSearch();
        $searchModel = new EquipmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EquipmentSpec model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EquipmentSpec model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EquipmentSpec();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EquipmentSpec model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $equipment = $this->findEquipment($id);
        $equipmentSpecs = $equipment->equipmentSpecs;

        if ($this->request->isPost) {
            $oldEquipmentSpecs = ArrayHelper::map($equipmentSpecs, 'id', 'id');
            $equipmentSpecs = Model::createMultiple(EquipmentSpec::class, $equipmentSpecs);
            Model::loadMultiple($equipmentSpecs, $this->request->post());
            $deletedIds = array_diff($oldEquipmentSpecs, array_filter(ArrayHelper::map($equipmentSpecs, 'id', 'id')));

            foreach ($equipmentSpecs as $i => $spec)
                $spec->equipment_id = $equipment->id;

            $valid = Model::validateMultiple($equipmentSpecs);

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($deletedIds)
                        EquipmentSpec::deleteAll(['id' => $deletedIds]);

                    foreach ($equipmentSpecs as $i => $spec) {
                        $spec->equipment_id = $equipment->id;
                        if (!$flag = $spec->save(false)) {
                            $transaction->rollBack();
                            break;
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['update', 'id' => $equipment->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'equipmentSpecs' => empty($equipmentSpecs) ? [new EquipmentSpec] : $equipmentSpecs,
        ]);
    }

    /**
     * Deletes an existing EquipmentSpec model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EquipmentSpec model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return EquipmentSpec the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EquipmentSpec::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findEquipment($id)
    {
        if (($model = Equipment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
