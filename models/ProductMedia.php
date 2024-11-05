<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_media".
 *
 * @property int $id
 * @property int $product_id
 * @property int $media_id
 *
 * @property Metadata $media
 * @property Product $product
 */
class ProductMedia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_media';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'media_id'], 'required'],
            [['product_id', 'media_id'], 'integer'],
            [['media_id'], 'exist', 'skipOnError' => true, 'targetClass' => Metadata::class, 'targetAttribute' => ['media_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'media_id' => 'Media ID',
        ];
    }

    /**
     * Gets query for [[Media]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasOne(Metadata::class, ['id' => 'media_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
