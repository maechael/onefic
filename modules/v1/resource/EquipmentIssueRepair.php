<?php

namespace app\modules\v1\resource;

use app\models\EquipmentIssueRepair as ModelsEquipmentIssueRepair;
use app\modules\v1\behaviors\GlobalIdBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

class EquipmentIssueRepair extends ModelsEquipmentIssueRepair
{
    public $issue_status;

    const SCENARIO_CUSTOM = 'custom';

    public function behaviors()
    {
        return [
            [
                'class' => GlobalIdBehavior::class
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [BaseActiveRecord::EVENT_BEFORE_INSERT => 'equipment_issue_id'],
                'value' => function ($event) {
                    return $this->equipmentIssueByGId->id;
                }
            ]
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['equipment_issue_id']);
        return $fields;
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CUSTOM] = [
            'equipment_issue_gid',
            'performed_by',
            'issue_status',
            'repair_activity',
            'remarks',
        ];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['global_id', 'equipment_issue_id', 'repair_activity', 'performed_by'], 'required', 'on' => self::SCENARIO_DEFAULT],
            [['repair_activity', 'performed_by', 'equipment_issue_gid'], 'required', 'on' => self::SCENARIO_CUSTOM],
            [['equipment_issue_id', 'issue_status'], 'integer'],
            [['repair_activity', 'remarks'], 'string'],
            [['created_at', 'updated_at', 'issue_status'], 'safe'],
            [['global_id'], 'string', 'max' => 255],
            [['performed_by'], 'string', 'max' => 128],
            [['equipment_issue_gid'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentIssue::class, 'targetAttribute' => ['equipment_issue_gid' => 'global_id']],
        ];
    }
}
