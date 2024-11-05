<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property int $id
 * @property int $number
 * @property string $code
 * @property string|null $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Fic[] $fics
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number', 'code'], 'required'],
            [['number'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['code', 'name'], 'string', 'max' => 100],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Region',
            'number' => 'Number',
            'code' => 'Region',
            'name' => 'Name',
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
        return $this->hasMany(Fic::class, ['region_id' => 'id']);
    }

    public static function getRegions()
    {
        //var_dump(self::find()->asArray()->all());
        return self::find()->orderBy(['number' => SORT_ASC])->all();
        //return ['key' => 'value', 'key1' => 'value2'];
    }
}
