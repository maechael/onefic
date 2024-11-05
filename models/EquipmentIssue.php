<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipment_issue".
 *
 * @property int $id
 * @property string $global_id
 * @property string $fic_equipment_gid
 * @property int $fic_equipment_id
 * @property string $title
 * @property string $description
 * @property int|null $status
 * @property string|null $reported_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property FicEquipment $ficEquipment
 */
class EquipmentIssue extends \yii\db\ActiveRecord
{
    const STATUS_CLOSED = 0;
    const STATUS_OPEN = 1;

    public $imageFile;
    public $relatedPartIds;
    public $relatedComponentIds;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment_issue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fic_equipment_id', 'title', 'description'], 'required'],
            [['fic_equipment_id', 'status'], 'integer'],
            [['description'], 'string'],
            [['global_id', 'fic_equipment_gid'], 'string', 'max' => 255],
            [['reported_by'], 'string', 'max' => 64],
            [['global_id'], 'safe'],
            [['created_at', 'updated_at', 'relatedPartIds', 'relatedComponentIds'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['fic_equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => FicEquipment::class, 'targetAttribute' => ['fic_equipment_id' => 'id']],
            [['imageFile'], 'file', 'skipOnEmpty' => true,],
            [['imageFile'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fic_equipment_id' => 'Fic Equipment ID',
            'title' => 'Title',
            'description' => 'Description',
            'imageFile' => 'Image File',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[FicEquipment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFicEquipment()
    {
        return $this->hasOne(FicEquipment::class, ['id' => 'fic_equipment_id']);
    }

    public function getFicEquipmentByGId()
    {
        return $this->hasOne(FicEquipment::class, ['global_id' => 'fic_equipment_gid']);
    }

    public function getEquipment()
    {
        return $this->hasOne(Equipment::class, ['id' => 'equipment_id'])->via('ficEquipment');
    }

    public function getIssueRelatedParts()
    {
        return $this->hasMany(IssueRelatedPart::class, ['equipment_issue_id' => 'id'])->andWhere(['type' => IssueRelatedPart::TYPE_PART]);
    }

    public function getIssueRelatedComponents()
    {
        return $this->hasMany(IssueRelatedPart::class, ['equipment_issue_id' => 'id'])->andWhere(['type' => IssueRelatedPart::TYPE_COMPONENT]);
    }

    public function getEquipmentIssueImages()
    {
        return $this->hasMany(EquipmentIssueImage::class, ['equipment_issue_id' => 'id']);
    }

    public function getEquipmentIssueRepairs()
    {
        return $this->hasMany(EquipmentIssueRepair::class, ['equipment_issue_id' => 'id'])->orderBy(['created_at' => SORT_DESC]);
    }

    public function getIssueImagePreviews()
    {
        $previews = ['previews' => [], 'configs' => []];
        foreach ($this->equipmentIssueImages as $issueImg) {
            $previews['previews'][] = $issueImg->localMedia->link;
            $previews['configs'][] = array('type' => $issueImg->localMedia->previewType, 'caption' => $issueImg->localMedia->basename, 'key' => $issueImg->localMedia->id);
        }
        return $previews;
    }

    public function getStatusDisplay()
    {
        $display = "";
        switch ($this->status) {
            case self::STATUS_OPEN:
                $display = "Open";
                break;
            case self::STATUS_CLOSED:
                $display = "Closed";
                break;
            default:
                $display = "N/A";
                break;
        }
        return $display;
    }
}
