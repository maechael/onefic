<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipment_component".
 *
 * @property int $id
 * @property int $equipment_id
 * @property int $component_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Component $component
 * @property Equipment $equipment
 * @property EquipmentComponentPart[] $equipmentComponentParts
 */
class EquipmentComponent extends \yii\db\ActiveRecord
{
    public $parts;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment_component';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['component_id'], 'required'],
            [['equipment_id', 'component_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['component_id'], 'exist', 'skipOnError' => true, 'targetClass' => Component::class, 'targetAttribute' => ['component_id' => 'id']],
            [['equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipment::class, 'targetAttribute' => ['equipment_id' => 'id']],
            [['parts'], 'safe'],
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
            'component_id' => 'Component',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Component]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComponent()
    {
        return $this->hasOne(Component::className(), ['id' => 'component_id']);
    }

    /**
     * Gets query for [[Equipment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipment()
    {
        return $this->hasOne(Equipment::className(), ['id' => 'equipment_id']);
    }

    /**
     * Gets query for [[EquipmentComponentParts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentComponentParts()
    {
        return $this->hasMany(EquipmentComponentPart::className(), ['equipment_component_id' => 'id']);
    }

    public static function getEquipmentComponents($equipmentId = null)
    {
        $query = self::find();
        if ($equipmentId != null)
            $query->where(['equipment_id' => $equipmentId]);
        return $query->all();
    }
}
