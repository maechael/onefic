<?php

namespace app\models;

use Yii;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii2tech\ar\softdelete\SoftDeleteQueryBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "equipment".
 *
 * @property int $id
 * @property string $model
 * @property int|null $equipment_type_id
 * @property int|null $equipment_category_id
 * @property int|null $processing_capability_id
 * @property int|null $image_id
 * @property bool|false $isDeleted
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property EquipmentCategory $equipmentCategory
 * @property EquipmentType $equipmentType
 */
class Equipment extends \yii\db\ActiveRecord
{
    public $imageFile;
    public $isImageChanged;
    public $techServiceIds;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model', 'equipment_type_id', 'equipment_category_id', 'processing_capability_id'], 'required'],
            [['equipment_type_id', 'equipment_category_id', 'processing_capability_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['model'], 'string', 'max' => 200],
            [['model'], 'unique'],
            [['equipment_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentCategory::class, 'targetAttribute' => ['equipment_category_id' => 'id']],
            [['equipment_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentType::class, 'targetAttribute' => ['equipment_type_id' => 'id']],
            [['processing_capability_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProcessingCapability::class, 'targetAttribute' => ['processing_capability_id' => 'id']],
            [['imageFile'], 'file', 'skipOnEmpty' => true],
            [['isImageChanged'], 'boolean'],
            [['isImageChanged', 'techServiceIds'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model' => 'Model',
            'equipment_type_id' => 'Type',
            'equipment_category_id' => 'Category',
            'processing_capability_id' => 'Processing Capability',
            'techServiceIds' => 'Tech Service',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::class,
                'softDeleteAttributeValues' => [
                    'isDeleted' => true
                ],
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery|SoftDeleteQueryBehavior
     */
    public static function find()
    {
        $query = parent::find();
        // $query->attachBehavior('softDelete', SoftDeleteBehavior::class);
        // return $query;
        $query->attachBehavior('softDelete', SoftDeleteQueryBehavior::class);
        return $query->notDeleted();
    }

    /**
     * Gets query for [[EquipmentCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentCategory()
    {
        return $this->hasOne(EquipmentCategory::class, ['id' => 'equipment_category_id']);
    }

    /**
     * Gets query for [[EquipmentType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentType()
    {
        return $this->hasOne(EquipmentType::class, ['id' => 'equipment_type_id']);
    }

    public function getImage()
    {
        return $this->hasOne(Metadata::class, ['id' => 'image_id']);
    }

    /**
     * Gets query for [[ProcessingCapability]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProcessingCapability()
    {
        return $this->hasOne(ProcessingCapability::class, ['id' => 'processing_capability_id']);
    }

    /**
     * Gets query for [[EquipmentSpecs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentSpecs()
    {
        return $this->hasMany(EquipmentSpec::class, ['equipment_id' => 'id']);
    }

    public function getEquipmentComponents()
    {
        return $this->hasMany(EquipmentComponent::class, ['equipment_id' => 'id']);
    }

    public function getComponents()
    {
        return $this->hasMany(Component::class, ['id' => 'component_id'])->via('equipmentComponents');
    }

    public function getEquipmentComponentParts()
    {
        return $this->hasMany(EquipmentComponentPart::class, ['equipment_component_id' => 'id'])->via('equipmentComponents');
    }

    public function getEquipmentTechServices()
    {
        return $this->hasMany(EquipmentTechService::class, ['equipment_id' => 'id']);
    }

    public function getTechServices()
    {
        return $this->hasMany(TechService::class, ['id' => 'tech_service_id'])->via('equipmentTechServices');
    }

    public function getMaintenanceChecklistItemTemplates()
    {
        return $this->hasMany(MaintenanceChecklistItemTemplate::class, ['equipment_id' => 'id']);
    }

    public function getChecklistComponentTemplates()
    {
        return $this->hasMany(ChecklistComponentTemplate::class, ['equipment_id' => 'id']);
    }

    public static function getEquipments()
    {
        return self::find()->orderBy(['model' => SORT_ASC])->all();
    }

    public function uploadImage($isUpdate = false, $subfolder = null)
    {
        $metadata = new Metadata();
        if ($this->validate()) {
            if ($isUpdate)
                $this->image->delete();

            $metadata->set($this->imageFile, $subfolder);

            if (!is_dir(dirname($metadata->filepath)))
                FileHelper::createDirectory(dirname($metadata->filepath));

            if ($metadata->validate() && $metadata->save()) {
                $this->image_id = $metadata->id;
                $this->imageFile->saveAs($metadata->filepath);
            }
        }
    }
}
