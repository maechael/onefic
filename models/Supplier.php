<?php

namespace app\models;

use Yii;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii2tech\ar\softdelete\SoftDeleteQueryBehavior;

/**
 * This is the model class for table "supplier".
 *
 * @property int $id
 * @property string $organization_name
 * @property string|null $form_of_organization
 * @property string|null $contact_person
 * @property string|null $cellNumber
 * @property string|null $email
 * @property string|null $web_address
 * @property string|null $telNumber
 * @property int|null $region_id
 * @property int|null $province_id
 * @property int|null $municipality_city_id
 * @property string|null $address
 * @property int|null $is_philgeps_registered
 * @property string|null $certificate_ref_num
 * @property int|null $organization_status
 * @property int|null $isSupplier 
 * @property int|null $isFabricator 
 * @property int|null $isDeleted 
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Branch[] $branches
 * @property MunicipalityCity $municipalityCity
 * @property PartSupplier[] $partSuppliers
 * @property Part[] $parts
 * @property Province $province
 * @property Region $region
 * @property SupplierMedia[] $supplierMedia
 */
class Supplier extends \yii\db\ActiveRecord
{
    const APPROVAL_STATUS_PENDING = 0;
    const APPROVAL_STATUS_APPROVED = 1;
    const APPROVAL_STATUS_REJECTED = 2;

    const ORGANIZATION_STATUS_INACTIVE = 0;
    const ORGANIZATION_STATUS_ACTIVE = 1;

    public $partsField;
    public $businessFiles;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_name', 'region_id', 'province_id', 'municipality_city_id'], 'required'],
            [['region_id', 'province_id', 'municipality_city_id', 'is_philgeps_registered', 'organization_status', 'isSupplier', 'isFabricator', 'isDeleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['organization_name', 'contact_person', 'cellNumber', 'email', 'telNumber', 'address', 'certificate_ref_num', 'web_address'], 'string', 'max' => 255],
            [['form_of_organization'], 'string', 'max' => 100],
            [['organization_name'], 'unique'],
            [['municipality_city_id'], 'exist', 'skipOnError' => true, 'targetClass' => MunicipalityCity::class, 'targetAttribute' => ['municipality_city_id' => 'id']],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Province::class, 'targetAttribute' => ['province_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::class, 'targetAttribute' => ['region_id' => 'id']],
            [['businessFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, pdf', 'maxFiles' => 0],
            [['partsField'], 'safe'],
            // [['approval_status'], 'default', 'value' => self::APPROVAL_STATUS_APPROVED],
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
            'organization_name' => 'Organization Name',
            'form_of_organization' => 'Form Of Organization',
            'contact_person' => 'Contact Person',
            'cellNumber' => 'Cell Number',
            'email' => 'Email',
            'web_address' => 'Web Address',
            'telNumber' => 'Tel Number',
            'region_id' => 'Region',
            'province_id' => 'Province',
            'municipality_city_id' => 'Municipality/City',
            'address' => 'Address',
            'is_philgeps_registered' => 'Is Philgeps Registered',
            'certificate_ref_num' => 'Certificate Ref Num',
            // 'approval_status' => 'Approval Status',
            'organization_status' => 'Organization Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'partsField' => 'Parts'
        ];
    }

    public function behaviors()
    {
        return [
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::class,
                'softDeleteAttributeValues' => [
                    'isDeleted' => true
                ],
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery|SoftDeleteQueryBehavior
     */
    public static function find()
    {
        $query = parent::find();
        $query->attachBehavior('softDelete', SoftDeleteQueryBehavior::class);
        return $query->notDeleted();
    }

    /**
     * Gets query for [[Branches]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branch::class, ['supplier_id' => 'id']);
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

    /**
     * Gets query for [[PartSuppliers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPartSuppliers()
    {
        return $this->hasMany(PartSupplier::class, ['supplier_id' => 'id']);
    }

    /**
     * Gets query for [[Parts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParts()
    {
        return $this->hasMany(Part::class, ['id' => 'part_id'])->via('partSuppliers');
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
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::class, ['id' => 'region_id']);
    }

    /**
     * Gets query for [[SupplierMedia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplierMedias()
    {
        return $this->hasMany(SupplierMedia::class, ['supplier_id' => 'id']);
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
     * Gets query for [[SupplierMedia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMySupplierMedias()
    {
        return $this->hasMany(SupplierMedia::class, ['supplier_id' => 'id'])->onCondition(['branch_id' => null]);
    }

    /**
     * Gets query for [[Metadata]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMyMedias()
    {
        return $this->hasMany(Metadata::class, ['id' => 'media_id'])->via('mySupplierMedias');
    }

    /**
     * Gets query for [[EquipmentComponentPart]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentComponentParts()
    {
        return $this->hasMany(EquipmentComponentPart::class, ['part_id' => 'id'])->via('parts');
    }

    /**
     * Gets query for [[EquipmentComponent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentComponents()
    {
        return $this->hasMany(EquipmentComponent::class, ['id' => 'equipment_component_id'])->via('equipmentComponentParts');
    }

    /**
     * Gets query for [[Equipment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipments()
    {
        return $this->hasMany(Equipment::class, ['id' => 'equipment_id'])->via('equipmentComponents');
    }

    // public function getApprovalStatus()
    // {
    //     $approvalStatus = self::APPROVAL_STATUS_PENDING;
    //     switch ($this->approval_status) {
    //         case self::APPROVAL_STATUS_PENDING:
    //             $approvalStatus = 'pending';
    //             break;
    //         case self::APPROVAL_STATUS_APPROVED:
    //             $approvalStatus = 'approved';
    //             break;
    //         case self::APPROVAL_STATUS_REJECTED:
    //             $approvalStatus = 'rejected';
    //             break;
    //         default:
    //             $approvalStatus = 'pending';
    //             break;
    //     }

    //     return $approvalStatus;
    // }

    public function getOrganizationStatus()
    {
        $organizationStatus = self::ORGANIZATION_STATUS_INACTIVE;
        switch ($this->organization_status) {
            case self::ORGANIZATION_STATUS_ACTIVE:
                $organizationStatus = 'active';
                break;
            case self::ORGANIZATION_STATUS_INACTIVE:
                $organizationStatus = 'inactive';
                break;
            default:
                $organizationStatus = 'inactive';
                break;
        }

        return $organizationStatus;
    }
}
