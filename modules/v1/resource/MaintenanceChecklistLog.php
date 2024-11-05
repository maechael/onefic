<?php

namespace app\modules\v1\resource;

use app\models\MaintenanceChecklistLog as ModelsMaintenanceChecklistLog;
use app\modules\v1\behaviors\GlobalIdBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

class MaintenanceChecklistLog extends ModelsMaintenanceChecklistLog
{
    const SCENARIO_CUSTOM = 'custom';
    public $fic_equipment_gid;
    public $criteriaResults;

    public function behaviors()
    {
        return [
            [
                'class' => GlobalIdBehavior::class
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [BaseActiveRecord::EVENT_BEFORE_INSERT => 'fic_equipment_id'],
                'value' => function ($event) {
                    $ficEquipment = FicEquipment::findOne(['global_id' => $this->fic_equipment_gid]);
                    return $ficEquipment->id;
                }
            ]
        ];
    }

    public function rules()
    {
        return [
            [['global_id', 'fic_equipment_id', 'accomplished_by_name', 'accomplished_by_designation', 'accomplished_by_office', 'endorsed_by_name', 'endorsed_by_designation', 'endorsed_by_office'], 'required', 'on' => self::SCENARIO_DEFAULT],
            [['accomplished_by_name', 'accomplished_by_designation', 'accomplished_by_office', 'endorsed_by_name', 'endorsed_by_designation', 'endorsed_by_office'], 'required', 'on' => self::SCENARIO_CUSTOM],
            [['fic_equipment_id'], 'integer'],
            [['accomplished_by_date', 'endorsed_by_date', 'created_at', 'updated_at', 'fic_equipment_gid', 'criteriaResults'], 'safe'],
            [['global_id', 'accomplished_by_office', 'endorsed_by_office'], 'string', 'max' => 255],
            [['accomplished_by_name', 'accomplished_by_designation', 'endorsed_by_name', 'endorsed_by_designation'], 'string', 'max' => 128],
            [['fic_equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => FicEquipment::class, 'targetAttribute' => ['fic_equipment_id' => 'id']],
        ];
    }

    public function extraFields()
    {
        return [
            'checklistCriterias'
        ];
    }
}
