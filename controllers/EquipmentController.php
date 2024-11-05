<?php

namespace app\controllers;

use app\models\ChecklistComponentTemplate;
use app\models\Component;
use app\models\CriteriaTemplate;
use app\models\Equipment;
use app\models\EquipmentCategory;
use app\models\EquipmentComponent;
use app\models\EquipmentComponentPart;
use app\models\EquipmentSearch;
use app\models\EquipmentSpec;
use app\models\EquipmentTechService;
use app\models\EquipmentType;
use app\models\MaintenanceChecklistItemTemplate;
use app\models\Metadata;
use app\models\Model;
use app\models\ProcessingCapability;
use Exception;
use Yii;
use yii\base\InvalidCallException;
use yii\db\ActiveRecord;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * EquipmentController implements the CRUD actions for Equipment model.
 */
class EquipmentController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Equipment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EquipmentSearch();
        $equipment = new Equipment();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'equipmentTypes' => EquipmentType::getEquipmentTypes(),
            'equipment' => $equipment,
        ]);
    }

    public function actionStepUpdate2($id)
    {
        $equipment = $this->findModel($id);
        $modelComponents = $equipment->equipmentComponents;
        $equipmentComponentParts = $equipment->equipmentComponentParts;
        $equipmentSpecs = $equipment->equipmentSpecs;

        if ($this->request->isPost) {
            if ($equipment->load($this->request->post())) {
                $oldImage = $this->findImage($equipment->image_id); //..Metadata::class

                //..if the image file input is changed thru browse button, image drag or remove button
                if ($equipment->isImageChanged == 1) {
                    $equipment->imageFile = UploadedFile::getInstance($equipment, 'imageFile');

                    //..image saving block
                    if ($equipment->imageFile) {

                        //..if there's no initial image
                        if (!isset($equipment->image_id) || $equipment->image_id == null) {
                            $equipment->uploadImage(false, Yii::$app->params["equipment_folder"]);
                        } else {
                            //..delete old image in uploads
                            // unlink($oldImage->filepath);

                            //..upload new image in uploads          
                            //..update info in metadata table
                            $equipment->uploadImage(true, Yii::$app->params["equipment_folder"]);
                        }
                    } else if (!$equipment->imageFile && isset($equipment->image_id)) {
                        // $oldImage->deleteMedia();
                        $oldImage->delete();
                        $equipment->image_id = null;
                    }
                }

                //..insert ajax validation here

                $valid = $equipment->validate();

                if ($valid) {
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $equipment->save(false)) {
                            $transaction->commit();
                        } else {
                            $transaction->rollBack();
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
            }
        }
        //update step 2
        if (!empty($modelComponents)) {
            foreach ($modelComponents as $indexComponent => $component) {
                $component->parts = ArrayHelper::getColumn($component->equipmentComponentParts, 'part_id');
            }
        }

        if ($this->request->isPost) {
            //..modelComponents saving block
            $oldComponentIds = ArrayHelper::map($modelComponents, 'id', 'id');
            $modelComponents = Model::createMultiple(EquipmentComponent::class, $modelComponents);
            Model::loadMultiple($modelComponents, $this->request->post());
            $deletedIds = array_diff($oldComponentIds, array_filter(ArrayHelper::map($modelComponents, 'id', 'id')));

            //..insert ajax validation here

            $valid = $equipment->validate();
            $valid = Model::validateMultiple($modelComponents) && $valid;

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (!empty($deletedIds))
                        EquipmentComponent::deleteAll(['id' => $deletedIds]);

                    foreach ($modelComponents as $indexComponent => $component) {
                        $component->equipment_id = $equipment->id;
                        if (!$flag = $component->save(false)) {
                            // $transaction->rollBack();
                            break;
                        }

                        //..equipmentComponentPart saving block
                        $oldParts = ArrayHelper::getColumn($component->equipmentComponentParts, 'part_id');
                        $deletedPartIds = array_diff($oldParts, is_array($component->parts) ? $component->parts : []);
                        $addedParts = array_diff(is_array($component->parts) ? $component->parts : [], $oldParts);

                        $deletedComponentPartIds = array_values(ArrayHelper::filter(ArrayHelper::map($component->equipmentComponentParts, 'part_id', function ($elem) {
                            return $elem->id;
                        }), $deletedPartIds));

                        if (!empty($deletedComponentPartIds))
                            EquipmentComponentPart::deleteAll(['id' => $deletedComponentPartIds]);

                        foreach ($addedParts as $aPartId) {
                            $part = new EquipmentComponentPart();
                            $part->equipment_component_id = $component->id;
                            $part->part_id = $aPartId;
                            if (!$flag = $part->save())
                                break;
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        //update Step 3
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
                        return $this->redirect(['index', 'id' => $equipment->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('_update', [
            'equipmentSpecs' => $equipmentSpecs,
            'equipment' => $equipment,
            'part' => $equipmentComponentParts,
            'categories' => EquipmentCategory::getEquipmentCategories(),
            'types' => EquipmentType::getEquipmentTypes(),
            'processCapability' => ProcessingCapability::getProcessingCapabilities(),
            'components' => (empty($modelComponents)) ? [new EquipmentComponent] : $modelComponents,
        ]);
    }

    public function actionStepUpdate($id)
    {
        $equipment = $this->findModel($id);
        $equipment->techServiceIds = ArrayHelper::getColumn($equipment->techServices, 'id');
        $modelComponents = $equipment->equipmentComponents;
        $equipmentComponentParts = $equipment->equipmentComponentParts;
        $equipmentSpecs = $equipment->equipmentSpecs;

        if (!empty($modelComponents)) {
            foreach ($modelComponents as $indexComponent => $component) {
                $component->parts = ArrayHelper::getColumn($component->equipmentComponentParts, 'part_id');
            }
        }

        if ($this->request->isPost) {
            $oldTechServiceIds = $equipment->techServiceIds;

            if ($equipment->load($this->request->post())) {
                $deletedTechServiceIds = array_diff($oldTechServiceIds, !empty($equipment->techServiceIds) ? $equipment->techServiceIds : []);
                $addedTechServiceIds = array_diff(!empty($equipment->techServiceIds) ? $equipment->techServiceIds : [], $oldTechServiceIds);

                $oldImage = $this->findImage($equipment->image_id); //..Metadata::class

                //..modelComponents saving block
                $oldComponentIds = ArrayHelper::map($modelComponents, 'id', 'id');
                $modelComponents = Model::createMultiple(EquipmentComponent::class, $modelComponents);
                Model::loadMultiple($modelComponents, $this->request->post());
                $deletedIds = array_diff($oldComponentIds, array_filter(ArrayHelper::map($modelComponents, 'id', 'id')));

                $oldEquipmentSpecs = ArrayHelper::map($equipmentSpecs, 'id', 'id');
                $equipmentSpecs = Model::createMultiple(EquipmentSpec::class, $equipmentSpecs);
                Model::loadMultiple($equipmentSpecs, $this->request->post());
                $deletedEquipmentSpecs = array_diff($oldEquipmentSpecs, array_filter(ArrayHelper::map($equipmentSpecs, 'id', 'id')));

                foreach ($equipmentSpecs as $i => $spec)
                    $spec->equipment_id = $equipment->id;

                $valid = $equipment->validate();
                $valid = Model::validateMultiple($modelComponents) && $valid;
                $valid = Model::validateMultiple($equipmentSpecs) && $valid;

                if ($valid) {
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        //..if the image file input is changed thru browse button, image drag or remove button
                        if ($equipment->isImageChanged == 1) {
                            $equipment->imageFile = UploadedFile::getInstance($equipment, 'imageFile');

                            //..image saving block
                            if ($equipment->imageFile) {

                                //..if there's no initial image
                                if (!isset($equipment->image_id) || $equipment->image_id == null) {
                                    $equipment->uploadImage(false, Yii::$app->params["equipment_folder"]);
                                } else {
                                    //..delete old image in uploads
                                    // unlink($oldImage->filepath);

                                    //..upload new image in uploads          
                                    //..update info in metadata table
                                    $equipment->uploadImage(true, Yii::$app->params["equipment_folder"]);
                                }
                            } else if (!$equipment->imageFile && isset($equipment->image_id)) {
                                // $oldImage->deleteMedia();
                                $oldImage->delete();
                                $equipment->image_id = null;
                            }
                        }

                        if ($flag = $equipment->save(false)) {
                            //..insert equipment tech service saving here
                            if (!empty($deletedTechServiceIds))
                                EquipmentTechService::deleteAll(['tech_service_id' => $deletedTechServiceIds, 'equipment_id' => $equipment->id]);

                            if (!empty($deletedIds))
                                EquipmentComponent::deleteAll(['id' => $deletedIds]);

                            foreach ($addedTechServiceIds as $techId) {
                                $equipmentTechService = new EquipmentTechService();
                                $equipmentTechService->equipment_id = $equipment->id;
                                $equipmentTechService->tech_service_id = $techId;
                                if (!$flag = $equipmentTechService->save())
                                    break;
                            }

                            foreach ($modelComponents as $indexComponent => $component) {
                                $component->equipment_id = $equipment->id;
                                if (!$flag = $component->save(false)) {
                                    break;
                                }

                                //..equipmentComponentPart saving block
                                $oldParts = ArrayHelper::getColumn($component->equipmentComponentParts, 'part_id');
                                $deletedPartIds = array_diff($oldParts, is_array($component->parts) ? $component->parts : []);
                                $addedParts = array_diff(is_array($component->parts) ? $component->parts : [], $oldParts);

                                $deletedComponentPartIds = array_values(ArrayHelper::filter(ArrayHelper::map($component->equipmentComponentParts, 'part_id', function ($elem) {
                                    return $elem->id;
                                }), $deletedPartIds));

                                if (!empty($deletedComponentPartIds))
                                    EquipmentComponentPart::deleteAll(['id' => $deletedComponentPartIds]);

                                foreach ($addedParts as $aPartId) {
                                    $part = new EquipmentComponentPart();
                                    $part->equipment_component_id = $component->id;
                                    $part->part_id = $aPartId;
                                    if (!$flag = $part->save())
                                        break;
                                }
                            }

                            if ($flag) {
                                if ($deletedEquipmentSpecs)
                                    EquipmentSpec::deleteAll(['id' => $deletedEquipmentSpecs]);

                                foreach ($equipmentSpecs as $i => $spec) {
                                    $spec->equipment_id = $equipment->id;
                                    if (!$flag = $spec->save(false)) {
                                        break;
                                    }
                                }
                            }
                        }

                        if ($flag) {
                            $transaction->commit();
                            return $this->redirect(['index', 'id' => $equipment->id]);
                        } else {
                            $transaction->rollBack();
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
            }
        }

        return $this->render('_update', [
            'equipmentSpecs' => $equipmentSpecs,
            'equipment' => $equipment,
            'part' => $equipmentComponentParts,
            'categories' => EquipmentCategory::getEquipmentCategories(),
            'types' => EquipmentType::getEquipmentTypes(),
            'processCapability' => ProcessingCapability::getProcessingCapabilities(),
            'components' => (empty($modelComponents)) ? [new EquipmentComponent] : $modelComponents,
        ]);
    }

    /**
     * Displays a single Equipment model.
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
     * Creates a new Equipment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Equipment();
        $metadata = new Metadata();
        // $test = Yii::$app->request;
        // $test2 = Yii::$app->request->isAjax;
        // $test3 = Yii::$app->request->isPost;
        // $test4 = Yii::$app->request->post();
        if (Yii::$app->request->isAjax && $this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

                if ($model->imageFile)
                    $model->uploadImage(false, Yii::$app->params["equipment_folder"]);
                if ($model->save())
                    return $this->asJson(['success' => true]);
            }

            $result = [];

            foreach ($model->getErrors() as $attribute => $errors) {
                $result[Html::getInputId($model, $attribute)] = $errors;
            }

            return $this->asJson(['validation' => $result]);
        }

        return $this->render('create', [
            'model' => $model,
            'types' => EquipmentType::getEquipmentTypes(),
            'categories' => EquipmentCategory::getEquipmentCategories(),
            'processCapability' => ProcessingCapability::getProcessingCapabilities()
        ]);
    }

    /**
     * Updates an existing Equipment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $oldImage = $this->findImage($model->image_id); //..Metadata::class
                // $test = $model->getDirtyAttributes(['equipment_type_id']);

                //..if the image file input is changed thru browse button, image drag or remove button
                if ($model->isImageChanged == 1) {
                    $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

                    //..image saving block
                    if ($model->imageFile) {

                        //..if there's no initial image
                        if (!isset($model->image_id) || $model->image_id == null) {
                            $model->uploadImage(false, Yii::$app->params["equipment_folder"]);
                        } else {
                            //..delete old image in uploads
                            // unlink($oldImage->filepath);

                            //..upload new image in uploads          
                            //..update info in metadata table
                            $model->uploadImage(true, Yii::$app->params["equipment_folder"]);
                        }
                    } else if (!$model->imageFile && isset($model->image_id)) {
                        // $oldImage->deleteMedia();
                        $oldImage->delete();
                        $model->image_id = null;
                    }
                }

                //..insert ajax validation here

                $valid = $model->validate();

                if ($valid) {
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            $transaction->commit();
                            return $this->redirect(['view', 'id' => $model->id]);
                        } else {
                            $transaction->rollBack();
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'types' => EquipmentType::getEquipmentTypes(),
            'categories' => EquipmentCategory::getEquipmentCategories(),
            'processCapability' => ProcessingCapability::getProcessingCapabilities()
        ]);
    }

    /**
     * Deletes an existing Equipment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * 
     * ..this shit is the default generated by gii
     * public function actionDelete($id)
     * {
     *      $this->findModel($id)->delete();
     *      return $this->redirect(['index']); 
     * }
     */

    public function actionDelete()
    {

        $post = Yii::$app->request->post();

        //..to handle ajax delete request from kartik detailview
        if (Yii::$app->request->isAjax && isset($post['id'])) {
            $id = $post['id'];
            $equipment = $this->findModel($id);
            if (isset($equipment->image))
                $equipment->image->delete();
            if ($equipment->softDelete()) {
                echo Json::encode([
                    'success' => true,
                    'messages' => [
                        'kv-detail-info' => 'The equipment # ' . $id . ' was successfully deleted. <a href="' .
                            Url::to(['/equipment/index']) . '" class="btn btn-sm btn-info">' .
                            '<i class="glyphicon glyphicon-hand-right"></i>  Click here</a> to proceed.'
                    ]
                ]);
            } else {
                echo Json::encode([
                    'success' => false,
                    'messages' => [
                        'kv-detail-error' => 'Cannot delete the equipment # ' . $id . '.'
                    ]
                ]);
            }
            return;
        } else {
            //..to handle delete request from kartik gridview
            $id = Yii::$app->request->get()['id'];
            $equipment = $this->findModel($id);

            if (isset($equipment->image))
                $equipment->image->delete();
            // $equipment->image->deleteMedia();
            $equipment->softDelete();
            return $this->redirect(['index']);
        }
        throw new InvalidCallException("You are not allowed to do this operation. Contact the administrator.");
    }

    public function actionComponentPartUpdate($id)
    {
        $model = $this->findModel($id);
        $modelComponents = $model->equipmentComponents;
        $modelParts = [];
        // $oldPartIds = [];

        if (!empty($modelComponents)) {
            foreach ($modelComponents as $indexComponent => $component) {
                //..old implementation start
                // $parts = empty($component->equipmentComponentParts) ? [new EquipmentComponentPart] : $component->equipmentComponentParts;
                // $modelParts[$indexComponent] = $parts;
                // $oldParts = ArrayHelper::merge(ArrayHelper::index($parts, 'id'), $oldParts);
                //..old implementation start

                $component->parts = ArrayHelper::getColumn($component->equipmentComponentParts, 'part_id');
                // $oldPartIds = ArrayHelper::merge($component->parts, $oldPartIds);
                // $oldPartIds = $component->parts;
            }
        }

        if ($this->request->isPost) {

            //..modelComponents saving block
            $oldComponentIds = ArrayHelper::map($modelComponents, 'id', 'id');
            $modelComponents = Model::createMultiple(EquipmentComponent::class, $modelComponents);
            Model::loadMultiple($modelComponents, $this->request->post());
            $deletedIds = array_diff($oldComponentIds, array_filter(ArrayHelper::map($modelComponents, 'id', 'id')));

            //..insert ajax validation here

            $valid = $model->validate();
            $valid = Model::validateMultiple($modelComponents) && $valid;

            /**
             * This used to be the old implementation of saving component parts
             * Previous implementation used dynamic form to select multiple parts per component
             * Old code:
             * $partIds = [];
             * if (isset($_POST['EquipmentComponentPart'][0][0])) {
             *    foreach ($_POST['EquipmentComponentPart'] as $indexComponent => $parts) {
             *       $partIds = ArrayHelper::merge($partIds, array_filter(ArrayHelper::getColumn($parts, 'id')));
             *       foreach ($parts as $indexPart => $part) {
             *          $data['EquipmentComponentPart'] = $part;
             *          $modelPart = (isset($part['id']) && isset($oldParts[$part['id']])) ? $oldParts[$part['id']] : new EquipmentComponentPart;
             *          $modelPart->load($data);
             *          $modelParts[$indexComponent][$indexPart] = $modelPart;
             *          $valid = $modelPart->validate();
             *       }
             *    }
             * }
             * $oldPartIds = ArrayHelper::getColumn($oldParts, 'id');      
             */

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (!empty($deletedIds))
                        EquipmentComponent::deleteAll(['id' => $deletedIds]);

                    foreach ($modelComponents as $indexComponent => $component) {
                        $component->equipment_id = $model->id;
                        if (!$flag = $component->save(false)) {
                            // $transaction->rollBack();
                            break;
                        }

                        //..equipmentComponentPart saving block
                        $oldParts = ArrayHelper::getColumn($component->equipmentComponentParts, 'part_id');
                        $deletedPartIds = array_diff($oldParts, is_array($component->parts) ? $component->parts : []);
                        $addedParts = array_diff(is_array($component->parts) ? $component->parts : [], $oldParts);

                        $deletedComponentPartIds = array_values(ArrayHelper::filter(ArrayHelper::map($component->equipmentComponentParts, 'part_id', function ($elem) {
                            return $elem->id;
                        }), $deletedPartIds));

                        if (!empty($deletedComponentPartIds))
                            EquipmentComponentPart::deleteAll(['id' => $deletedComponentPartIds]);

                        foreach ($addedParts as $aPartId) {
                            $part = new EquipmentComponentPart();
                            $part->equipment_component_id = $component->id;
                            $part->part_id = $aPartId;
                            if (!$flag = $part->save())
                                break;
                        }
                    }


                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('component-part-update', [
            'model' => $model,
            'components' => (empty($modelComponents)) ? [new EquipmentComponent] : $modelComponents,
            'parts' => (empty($modelParts)) ? [[new EquipmentComponentPart]] : $modelParts,
        ]);
    }

    public function actionEquipmentSetup()
    {
        $equipment = new Equipment();
        $equipmentComponents = [new EquipmentComponent];
        $equipmentComponentParts = [];
        $equipmentSpecs = [new EquipmentSpec];

        if (Yii::$app->request->isPost && $equipment->load($this->request->post())) {
            $equipment->imageFile = UploadedFile::getInstance($equipment, 'imageFile');
            $valid = $equipment->validate();

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    //..upload image before equipment save..
                    //..to generate image id..
                    if ($equipment->imageFile)
                        $equipment->uploadImage(false, Yii::$app->params["equipment_folder"]);

                    if ($flag = $equipment->save(false)) {
                        //..equipment techservice saving block start
                        if (!empty($equipment->techServiceIds))
                            foreach ($equipment->techServiceIds as $techId) {
                                $equipmentTechService = new EquipmentTechService();
                                $equipmentTechService->equipment_id = $equipment->id;
                                $equipmentTechService->tech_service_id = $techId;
                                if (!$flag = $equipmentTechService->save())
                                    break;
                            }
                        //..equipment techservice saving block end

                        //..components & parts saving block start
                        $equipmentComponents = Model::createMultiple(EquipmentComponent::class, $equipmentComponents);
                        Model::loadMultiple($equipmentComponents, $this->request->post());

                        $valid = Model::validateMultiple($equipmentComponents);

                        if ($valid) {
                            foreach ($equipmentComponents as $indexComponent => $component) {
                                $component->equipment_id = $equipment->id;
                                if (!$flag = $component->save(false))
                                    break;

                                if (ArrayHelper::isTraversable($component->parts)) {
                                    foreach ($component->parts as $partId) {
                                        $ecPart = new EquipmentComponentPart();
                                        $ecPart->equipment_component_id = $component->id;
                                        $ecPart->part_id = $partId;
                                        if (!$flag = $ecPart->save())
                                            break;
                                    }
                                }
                            }
                        }
                        //..components & parts saving block end

                        //..equipment spec saving block start
                        $equipmentSpecs = Model::createMultiple(EquipmentSpec::class, $equipmentSpecs);
                        Model::loadMultiple($equipmentSpecs, $this->request->post());

                        foreach ($equipmentSpecs as $i => $spec)
                            $spec->equipment_id = $equipment->id;

                        $valid = Model::validateMultiple($equipmentSpecs) && $valid && $flag;

                        foreach ($equipmentSpecs as $i => $spec) {
                            $spec->equipment_id = $equipment->id;
                            if (!$flag = $spec->save(false))
                                break;
                        }
                        //..equipment spec saving block end
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $equipment->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        } else {
            $equipment->loadDefaultValues();
        }

        return $this->render('equipment-setup', [
            'equipment' => $equipment,
        ]);
    }

    public function actionChecklist($id)
    {
        $equipment = $this->findModel($id);
        $checklistComponents = $equipment->checklistComponentTemplates;
        $criteriaTemplates = [];
        $oldCriterias = [];

        if (!empty($checklistComponents)) {
            foreach ($checklistComponents as $i => $component) {
                $components = empty($component->criteriaTemplates) ? [new CriteriaTemplate] : $component->criteriaTemplates;
                $criteriaTemplates[$i] = $components;
                $oldCriterias = ArrayHelper::merge(ArrayHelper::index($components, 'id'), $oldCriterias);
            }
        }

        if ($this->request->isPost) {
            $criteriaTemplates = [];
            $oldComponentIds = ArrayHelper::map($checklistComponents, 'id', 'id');
            $checklistComponents = Model::createMultiple(ChecklistComponentTemplate::class, $checklistComponents);
            Model::loadMultiple($checklistComponents, Yii::$app->request->post());
            $deletedComponentIds = array_diff($oldComponentIds, array_filter(ArrayHelper::map($checklistComponents, 'id', 'id')));

            $valid = Model::validateMultiple($checklistComponents);

            $criteriaIds = [];
            if (isset($_POST['CriteriaTemplate'][0][0])) {
                foreach ($_POST['CriteriaTemplate'] as $i => $criterias) {
                    $criteriaIds = ArrayHelper::merge($criteriaIds, array_filter(ArrayHelper::getColumn($criterias, 'id')));
                    foreach ($criterias as $j => $criteria) {
                        $data['CriteriaTemplate'] = $criteria;
                        $modelCriteria = (isset($criteria['id']) && isset($oldCriterias[$criteria['id']])) ? $oldCriterias[$criteria['id']] : new CriteriaTemplate;
                        $modelCriteria->load($data);
                        $criteriaTemplates[$i][$j] = $modelCriteria;
                        $valid = $modelCriteria->validate();
                    }
                }
            }

            $oldCriteriaIds = ArrayHelper::getColumn($oldCriterias, 'id');
            $deletedCriteriaIds = array_diff($oldCriteriaIds, $criteriaIds);

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $flag = true;

                    if (!empty($deletedComponentIds))
                        ChecklistComponentTemplate::deleteAll(['id' => $deletedComponentIds]);
                    if (!empty($deletedCriteriaIds))
                        CriteriaTemplate::deleteAll(['id' => $deletedCriteriaIds]);

                    foreach ($checklistComponents as $i => $component) {
                        if ($flag === false)
                            break;

                        if (!($flag = $component->save(false)))
                            break;

                        if (isset($criteriaTemplates[$i]) && is_array($criteriaTemplates[$i])) {
                            foreach ($criteriaTemplates[$i] as $j => $criteriaTemplate) {
                                $criteriaTemplate->checklist_component_template_id = $component->id;
                                if (!($flag = $criteriaTemplate->save(false)))
                                    break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['index']);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception  $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('checklist', [
            'equipment' => $equipment,
            'checklistComponents' => (empty($checklistComponents)) ? [new ChecklistComponentTemplate] : $checklistComponents,
            'criteriaTemplates' => (empty($criteriaTemplates)) ? [[new CriteriaTemplate]] : $criteriaTemplates,
        ]);
    }

    public function actionChecklistOld($id)
    {
        $equipment = $this->findModel($id);
        $checklistItems = $equipment->maintenanceChecklistItemTemplates;
        $grouped = ArrayHelper::index($equipment->maintenanceChecklistItemTemplates, null, 'equipment_component_id');

        if ($this->request->isPost) {
            $oldItemIds = ArrayHelper::map($checklistItems, 'id', 'id');
            $checklistItems = Model::createMultiple(MaintenanceChecklistItemTemplate::class, $checklistItems);
            Model::loadMultiple($checklistItems, $this->request->post());
            $deletedIds = array_diff($oldItemIds, array_filter(ArrayHelper::map($checklistItems, 'id', 'id')));

            $valid = Model::validateMultiple($checklistItems);

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (!empty($deletedIds))
                        MaintenanceChecklistItemTemplate::deleteAll(['id' => $deletedIds]);

                    foreach ($checklistItems as $i => $checklistItem) {
                        if (!$flag = $checklistItem->save(false))
                            break;
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect('index');
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('checklist', [
            'equipment' => $equipment,
            'checklistItems' => (empty($checklistItems)) ? [new MaintenanceChecklistItemTemplate] : $checklistItems,
            'grouped' => (empty($grouped)) ? [[new MaintenanceChecklistItemTemplate]] : $grouped,
        ]);
    }

    public function actionUpdateSetup($id)
    {
        $equipment = $this->findModel($id);
        return $this->render('update-setup', [
            'equipment' => $equipment
        ]);
    }

    /**
     * Finds the Equipment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Equipment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Equipment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findImage($id)
    {
        if (($image = Metadata::findOne($id)) !== null) {
            return $image;
        }

        return null;
    }
}
