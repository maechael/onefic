<?php

namespace app\modules\v1\resource;

use app\models\EquipmentIssue as ModelsEquipmentIssue;
use app\modules\v1\behaviors\GlobalIdBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

class EquipmentIssue extends ModelsEquipmentIssue
{
    const SCENARIO_CUSTOM = 'custom';
    const SCENARIO_UPLOAD = 'upload';

    public $equipmentIssueImgs;

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
                    return $this->ficEquipmentByGId->id;
                }
            ]
        ];
    }

    public function rules()
    {
        // $rules = parent::rules();
        // return $rules;

        return [
            [['fic_equipment_id', 'title', 'description'], 'required', 'on' => self::SCENARIO_DEFAULT],
            [['title', 'description'], 'required', 'on' => self::SCENARIO_CUSTOM],
            [['fic_equipment_id', 'status'], 'integer'],
            [['description'], 'string'],
            [['global_id', 'fic_equipment_gid'], 'string', 'max' => 255],
            [['reported_by'], 'string', 'max' => 64],
            [['global_id'], 'safe'],
            [['created_at', 'updated_at', 'relatedPartIds', 'relatedComponentIds'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['fic_equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => FicEquipment::class, 'targetAttribute' => ['fic_equipment_id' => 'id']],
            [['equipmentIssueImgs'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 0],
            [['imageFile'], 'file', 'skipOnEmpty' => true,],
            [['imageFile', 'equipmentIssueImgs'], 'safe']
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['fic_equipment_id']);
        return $fields;
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        // $scenarios[self::SCENARIO_CUSTOM] = self::fields();
        $scenarios[self::SCENARIO_CUSTOM] = [
            'fic_equipment_gid',
            'title',
            'description',
            'status',
            'reported_by',
            'relatedPartIds',
            'relatedComponentIds',
        ];

        $scenarios[self::SCENARIO_UPLOAD] = [
            'equipmentIssueImgs'
        ];
        return $scenarios;
    }

    public function extraFields()
    {
        // $extraFields = parent::extraFields();
        // return $extraFields;

        return [
            'issueRelatedParts',
            'issueRelatedComponents'
        ];
    }
}
