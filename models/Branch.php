<?php

namespace app\models;

use PDO;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "branch".
 *
 * @property int $id
 * @property int $supplier_id
 * @property int|null $organization_status
 * @property string|null $contact_person
 * @property string|null $cellNumber
 * @property string|null $email
 * @property string|null $telNumber
 * @property int $region_id
 * @property int $province_id
 * @property int $municipality_city_id
 * @property string|null $address
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Supplier $supplier
 * @property SupplierMedia[] $supplierMedia
 */
class Branch extends \yii\db\ActiveRecord
{
    const SCENARIO_SETUP = 'setup';

    public $businessFiles;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'branch';
    }

    public function scenarios()
    {
        //..other way of declaring scenarios
        // return [
        //     self::SCENARIO_SETUP => ['region_id', 'province_id', 'municipality_city_id'],
        // ];

        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SETUP] = [
            'organization_status',
            'region_id',
            'province_id',
            'municipality_city_id',
            'contact_person',
            'cellNumber',
            'email',
            'telNumber',
            'address',
            'businessFiles'
        ];

        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['supplier_id', 'region_id', 'province_id', 'municipality_city_id'], 'required', 'on' => self::SCENARIO_DEFAULT],
            [['region_id', 'province_id', 'municipality_city_id'], 'required', 'on' => self::SCENARIO_SETUP],
            [['supplier_id', 'organization_status', 'region_id', 'province_id', 'municipality_city_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['contact_person', 'cellNumber', 'email', 'telNumber', 'address'], 'string', 'max' => 255],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::class, 'targetAttribute' => ['supplier_id' => 'id']],
            [['businessFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, pdf', 'maxFiles' => 0],
            [['email'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supplier_id' => 'Supplier ID',
            'organization_status' => 'Organization Status',
            'contact_person' => 'Contact Person',
            'cellNumber' => 'Cell Number',
            'email' => 'Email',
            'telNumber' => 'Tel Number',
            'region_id' => 'Region',
            'province_id' => 'Province',
            'municipality_city_id' => 'Municipality/City',
            'address' => 'Address',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Overriding beforeDelete function to ensure that..
     * ..all Media(Metadata) related to Branch is deleted.
     * SupplierMedia records will be automatically deleted..
     * ..as a result of having a cascade foreign relationship to..
     * ..Media(Metadata) table.
     */
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        // ...custom code here...
        foreach ($this->medias as $media) {
            // $media->deleteMedia();
            $media->delete();
        }
        return true;
    }

    /**
     * Gets query for [[Supplier]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier()
    {
        return $this->hasOne(Supplier::class, ['id' => 'supplier_id']);
    }

    /**
     * Gets query for [[SupplierMedia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplierMedias()
    {
        return $this->hasMany(SupplierMedia::class, ['branch_id' => 'id']);
    }

    /**
     * Gets query for [[Metadata]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedias()
    {
        return $this->hasMany(Metadata::class, ['id' => 'media_id'])->via('supplierMedias');
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::class, ['id' => 'region_id']);
    }

    /**
     * Gets query for [[Province]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::class, ['id' => 'province_id']);
    }

    /**
     * Gets query for [[MunicipalityCity]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipalityCity()
    {
        return $this->hasOne(MunicipalityCity::class, ['id' => 'municipality_city_id']);
    }

    public function getPreviewConfigs()
    {
        $previews = $configs = [];
        foreach ($this->medias as $media) {
            $previews[] = $media->link;
            $configs[] = array("type" => $media->previewType, "caption" => $media->basename, "key" => $media->id);
        }

        return (object)array("previews" => $previews, "configs" => $configs);
    }
}
