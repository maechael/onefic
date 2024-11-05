<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipment_issue_repair".
 *
 * @property int $id
 * @property string $global_id
 * @property int $equipment_issue_id
 * @property string $repair_activity
 * @property string $remarks
 * @property string $performed_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EquipmentIssue $equipmentIssue
 */
class EquipmentIssueRepair extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment_issue_repair';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['global_id', 'equipment_issue_id', 'repair_activity', 'performed_by'], 'required'],
            [['equipment_issue_id'], 'integer'],
            [['repair_activity', 'remarks'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['global_id'], 'string', 'max' => 255],
            [['performed_by'], 'string', 'max' => 128],
            [['equipment_issue_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentIssue::class, 'targetAttribute' => ['equipment_issue_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'global_id' => 'Global ID',
            'equipment_issue_id' => 'Equipment Issue ID',
            'repair_activity' => 'Repair Activity',
            'remarks' => 'Remarks',
            'performed_by' => 'Performed By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[EquipmentIssue]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentIssue()
    {
        return $this->hasOne(EquipmentIssue::class, ['id' => 'equipment_issue_id']);
    }

    public function getEquipmentIssueByGId()
    {
        return $this->hasOne(EquipmentIssue::class, ['global_id' => 'equipment_issue_gid']);
    }
}
