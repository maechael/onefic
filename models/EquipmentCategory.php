<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipment_category".
 *
 * @property int $id
 * @property string $name
 *
 * @property Equipment[] $equipments
 */
class EquipmentCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment_category';
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
            'name' => 'Category',
        ];
    }

    /**
     * Gets query for [[Equipments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipments()
    {
        return $this->hasMany(Equipment::class, ['equipment_category_id' => 'id']);
    }

    public static function getEquipmentCategories(){
        return self::find()->orderBy(['name'=>SORT_ASC])->all();
    }
}
