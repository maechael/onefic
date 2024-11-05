<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "maintenance_checklist_template".
 *
 * @property int $id
 * @property int|null $equipment_id
 * @property string $accomplished_by
 * @property string|null $designation
 * @property string|null $office
 * @property string|null $date
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Equipment $equipment
 * @property MaintenanceChecklistItemTemplate[] $maintenanceChecklistItemTemplates
 */
class MaintenanceChecklistTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'maintenance_checklist_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipment_id'], 'integer'],
            [['accomplished_by'], 'required'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['accomplished_by', 'designation', 'office'], 'string', 'max' => 255],
            [['equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipment::class, 'targetAttribute' => ['equipment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'equipment_id' => 'Equipment ID',
            'accomplished_by' => 'Accomplished By',
            'designation' => 'Designation',
            'office' => 'Office',
            'date' => 'Date',
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
        return $this->hasOne(Equipment::class, ['id' => 'equipment_id']);
    }

    /**
     * Gets query for [[MaintenanceChecklistItemTemplates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaintenanceChecklistItemTemplates()
    {
        return $this->hasMany(MaintenanceChecklistItemTemplate::class, ['maintenance_checklist_template_id' => 'id']);
    }
}
