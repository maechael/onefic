<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "maintenance_checklist_item_template".
 *
 * @property int $id
 * @property int|null $equipment_id
 * @property int|null $equipment_component_id
 * @property string|null $criteria
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Equipment $equipment
 * @property EquipmentComponent $equipmentComponent
 */
class MaintenanceChecklistItemTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'maintenance_checklist_item_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipment_id', 'equipment_component_id'], 'integer'],
            [['criteria'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['equipment_component_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentComponent::class, 'targetAttribute' => ['equipment_component_id' => 'id']],
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
            'equipment_component_id' => 'Component',
            'criteria' => 'Criteria',
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
     * Gets query for [[EquipmentComponent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentComponent()
    {
        return $this->hasOne(EquipmentComponent::class, ['id' => 'equipment_component_id']);
    }
}
