<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ProductEquipment[] $productEquipments
 * @property ProductMedia[] $productMedia
 */
class Product extends \yii\db\ActiveRecord
{
    public $equipmentIds;
    public $productImages;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'equipmentIds'], 'safe'],
            [['productImages'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, pdf', 'maxFiles' => 0],
            [['name', 'description'], 'string', 'max' => 255],

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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[ProductEquipments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductEquipments()
    {
        return $this->hasMany(ProductEquipment::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductMedia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductMedias()
    {
        return $this->hasMany(ProductMedia::class, ['product_id' => 'id']);
    }
}
