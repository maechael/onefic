<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supplier_rating".
 *
 * @property int $id
 * @property int $supplier_id
 * @property int|null $equipment_issue_repair_id
 * @property int|null $fic_id
 * @property float $rating
 * @property string|null $review
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EquipmentIssueRepair $equipmentIssueRepair
 * @property Fic $fic
 * @property Supplier $supplier
 */
class SupplierRating extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier_rating';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['supplier_id'], 'required'],
            [['supplier_id', 'equipment_issue_repair_id', 'fic_id'], 'integer'],
            [['rating'], 'number'],
            [['review'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['equipment_issue_repair_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentIssueRepair::class, 'targetAttribute' => ['equipment_issue_repair_id' => 'id']],
            [['fic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fic::class, 'targetAttribute' => ['fic_id' => 'id']],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::class, 'targetAttribute' => ['supplier_id' => 'id']],
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
            'equipment_issue_repair_id' => 'Equipment Issue Repair ID',
            'fic_id' => 'Fic ID',
            'rating' => 'Rating',
            'review' => 'Review',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[EquipmentIssueRepair]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentIssueRepair()
    {
        return $this->hasOne(EquipmentIssueRepair::class, ['id' => 'equipment_issue_repair_id']);
    }

    /**
     * Gets query for [[Fic]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFic()
    {
        return $this->hasOne(Fic::class, ['id' => 'fic_id']);
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
}
