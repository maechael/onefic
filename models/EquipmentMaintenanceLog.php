<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipment_maintenance_log".
 *
 * @property int $id
 * @property int $fic_equipment_id
 * @property string $maintenance_date
 * @property string|null $time_started
 * @property string|null $time_ended
 * @property string|null $conclusion_recommendation
 * @property string|null $inspected_checked_by
 * @property string|null $noted_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property FicEquipment $ficEquipment
 * @property MaintenanceLogComponentPart[] $maintenanceLogComponentParts
 */
class EquipmentMaintenanceLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment_maintenance_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fic_equipment_id', 'maintenance_date'], 'required'],
            [['fic_equipment_id'], 'integer'],
            [['maintenance_date', 'time_started', 'time_ended', 'created_at', 'updated_at'], 'safe'],
            [['conclusion_recommendation'], 'string'],
            [['inspected_checked_by', 'noted_by'], 'string', 'max' => 255],
            [['fic_equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => FicEquipment::className(), 'targetAttribute' => ['fic_equipment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fic_equipment_id' => 'Fic Equipment ID',
            'maintenance_date' => 'Maintenance Date',
            'time_started' => 'Time Started',
            'time_ended' => 'Time Ended',
            'conclusion_recommendation' => 'Conclusion Recommendation',
            'inspected_checked_by' => 'Inspected Checked By',
            'noted_by' => 'Noted By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[FicEquipment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFicEquipment()
    {
        return $this->hasOne(FicEquipment::className(), ['id' => 'fic_equipment_id']);
    }

    /**
     * Gets query for [[MaintenanceLogComponentParts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaintenanceLogComponentParts()
    {
        return $this->hasMany(MaintenanceLogComponentPart::className(), ['equipment_maintenance_log_id' => 'id'])->orderBy(['equipment_component_id' => SORT_ASC]);
    }

    public function getEquipment()
    {
        return $this->hasOne(Equipment::class, ['id' => 'equipment_id'])->via('ficEquipment');
    }

    public function getEquipmentComponents()
    {
        return $this->hasMany(EquipmentComponent::class, ['equipment_id' => 'id'])->via('equipment');
    }

    public function getComponents()
    {
        return $this->hasMany(Component::class, ['id' => 'component_id'])->via('equipmentComponents');
    }
}
