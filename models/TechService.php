<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tech_service".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $created_at
 * @property string $updated_at
 */
class TechService extends \yii\db\ActiveRecord
{
    public $equipmentIds;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tech_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'equipmentIds'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
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
            'description' => 'Description',
            'equipmentIds' => 'Equipment',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getEquipmentTechServices()
    {
        return $this->hasMany(EquipmentTechService::class, ['tech_service_id' => 'id']);
    }

    public function getEquipments()
    {
        return $this->hasMany(Equipment::class, ['id' => 'equipment_id'])->via('equipmentTechServices');
    }

    public static function getTechServices()
    {
        return self::find()->orderBy(['name' => SORT_ASC])->all();
    }
}
