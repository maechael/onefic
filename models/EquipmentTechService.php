<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipment_tech_service".
 *
 * @property int $equipment_id
 * @property int $tech_service_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Equipment $equipment
 * @property TechService $techService
 */
class EquipmentTechService extends \yii\db\ActiveRecord
{
    public $equipmentIds;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment_tech_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipment_id', 'tech_service_id'], 'required'],
            [['equipment_id', 'tech_service_id'], 'integer'],
            [['created_at', 'updated_at', 'equipmentIds'], 'safe'],
            [['equipment_id', 'tech_service_id'], 'unique', 'targetAttribute' => ['equipment_id', 'tech_service_id']],
            [['equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipment::className(), 'targetAttribute' => ['equipment_id' => 'id']],
            [['tech_service_id'], 'exist', 'skipOnError' => true, 'targetClass' => TechService::className(), 'targetAttribute' => ['tech_service_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'equipment_id' => 'Equipment ID',
            'tech_service_id' => 'Tech Service ID',
            'equipmentIds' => 'Equipment',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Equipment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipment()
    {
        return $this->hasOne(Equipment::className(), ['id' => 'equipment_id'])->inverseOf('equipmentTechServices');
    }

    /**
     * Gets query for [[TechService]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTechService()
    {
        return $this->hasOne(TechService::className(), ['id' => 'tech_service_id'])->inverseOf('equipmentTechServices');
    }
}
