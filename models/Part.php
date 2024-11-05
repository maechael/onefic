<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "part".
 *
 * @property int $id
 * @property string $name
 * @property int|null $media_id 
 * @property int|null $isDeleted 
 * @property int|null $version
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EquipmentComponentPart[] $equipmentComponentParts
 * @property EquipmentComponent[] $equipmentComponents
 * @property Equipment[] $equipments
 * @property PartSupplier[] $partSuppliers
 * @property Supplier[] $suppliers
 */
class Part extends \yii\db\ActiveRecord
{
    public $imageFile;
    public $isImageChanged;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'part';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['media_id', 'isDeleted', 'version'], 'integer'],
            [['created_at', 'updated_at', 'isImageChanged'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['name'], 'unique'],
            [['imageFile'], 'file', 'skipOnEmpty' => true],
            [['isImageChanged'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'media_id' => 'Media ID',
            'isDeleted' => 'Is Deleted',
            'version' => 'Version',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[EquipmentComponentParts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentComponentParts()
    {
        return $this->hasMany(EquipmentComponentPart::class, ['part_id' => 'id'])->inverseOf('part');
    }

    /**
     * Gets query for [[EquipmentComponents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentComponents()
    {
        return $this->hasMany(EquipmentComponent::class, ['id' => 'equipment_component_id'])->via('equipmentComponentParts');
    }

    /**
     * Gets query for [[Equipments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipments()
    {
        return $this->hasMany(Equipment::class, ['id' => 'equipment_id'])->via('equipmentComponents');
    }

    /**
     * Gets query for [[PartSuppliers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPartSuppliers()
    {
        return $this->hasMany(PartSupplier::class, ['part_id' => 'id'])->inverseOf('part');
    }

    /**
     * Gets query for [[Suppliers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSuppliers()
    {
        return $this->hasMany(Supplier::class, ['id' => 'supplier_id'])->via('partSuppliers');
    }

    public function getMedia()
    {
        return $this->hasOne(Metadata::class, ['id' => 'media_id']);
    }

    public static function getParts()
    {
        return self::find()->orderBy(['name' => SORT_ASC])->all();
    }

    public function uploadImage($isUpdate = false, $subfolder = null)
    {
        $metadata = new Metadata();
        if ($this->validate()) {
            if ($isUpdate)
                $this->media->delete();

            $metadata->set($this->imageFile, $subfolder);

            if (!is_dir(dirname($metadata->filepath)))
                FileHelper::createDirectory(dirname($metadata->filepath));

            if ($metadata->validate() && $metadata->save()) {
                $this->media_id = $metadata->id;
                $this->imageFile->saveAs($metadata->filepath);
            }
        }
    }
}
