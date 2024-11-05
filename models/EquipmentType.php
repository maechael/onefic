<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipment_type".
 *
 * @property int $id
 * @property string $name
 *
 * @property Equipment[] $equipments
 */
class EquipmentType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Type',
        ];
    }

    /**
     * Gets query for [[Equipments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipments()
    {
        return $this->hasMany(Equipment::class, ['equipment_type_id' => 'id']);
    }

    public static function getEquipmentTypes(){
        return self::find()->orderBy(['name'=>SORT_ASC])->all();
    }
}
