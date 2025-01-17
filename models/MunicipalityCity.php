<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "municipality_city".
 *
 * @property int $id
 * @property int $region_id
 * @property int $province_id
 * @property string $name
 * @property string|null $district
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Fic[] $fics
 * @property Province $province
 * @property Region $region
 */
class MunicipalityCity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'municipality_city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id', 'province_id', 'name'], 'required'],
            [['region_id', 'province_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'district'], 'string', 'max' => 100],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Province::className(), 'targetAttribute' => ['province_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Municipality/City',
            'region_id' => 'Region',
            'province_id' => 'Province',
            'name' => 'Municipality',
            'district' => 'District',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Fics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFics()
    {
        return $this->hasMany(Fic::className(), ['municipality_city_id' => 'id']);
    }

    /**
     * Gets query for [[Province]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['id' => 'province_id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }
}
