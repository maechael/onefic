<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "fic_equipment".
 *
 * @property int $id
 * @property int|null $fic_id
 * @property string $global_id
 * @property int $equipment_id
 * @property string $serial_number
 * @property int $status
 * @property string|null $remarks
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Equipment $equipment
 * @property Fic $fic
 */
class FicEquipment extends \yii\db\ActiveRecord
{
    const STATUS_SERVICEABLE = 1;
    const STATUS_UNSERVICEABLE = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fic_equipment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fic_id', 'equipment_id', 'status'], 'integer'],
            [['equipment_id', 'serial_number'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['serial_number'], 'string', 'max' => 100],
            [['global_id'], 'string', 'max' => 255],
            [['global_id'], 'safe'],
            [['serial_number'], 'unique'],
            [['remarks'], 'string'],
            [['equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipment::class, 'targetAttribute' => ['equipment_id' => 'id']],
            [['fic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fic::class, 'targetAttribute' => ['fic_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fic_id' => 'Fic ID',
            'equipment_id' => 'Equipment',
            'serial_number' => 'Serial Number',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Equipment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipment()
    {
        return $this->hasOne(Equipment::class, ['id' => 'equipment_id']);
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

    public function getEquipmentIssues()
    {
        return $this->hasMany(EquipmentIssue::class, ['fic_equipment_id' => 'id']);
    }

    // public function getIssueRelatedParts(){
    //     return $this->hasMany(IssueRelatedPart::class);
    // }

    public function getIssueCount()
    {
        return $this->getEquipmentIssues()->count();
    }

    public function getMaintenanceChecklistLogs()
    {
        return $this->hasMany(MaintenanceChecklistLog::class, ['fic_equipment_id' => 'id']);
    }

    public function getMaintenanceLogs()
    {
        return $this->hasMany(EquipmentMaintenanceLog::class, ['fic_equipment_id' => 'id'])->orderBy(['maintenance_date' => SORT_DESC]);
    }

    public function getLatestMaintenanceLog()
    {
        return $this->getMaintenanceLogs()->one();
    }

    public function getIssueRelatedComponents()
    {
        return $this->hasMany(IssueRelatedPart::class, ['equipment_issue_id' => 'id'])->via('equipmentIssues')
            ->where(['type' => IssueRelatedPart::TYPE_COMPONENT]);
    }

    public function getIssueRelatedParts()
    {
        return $this->hasMany(IssueRelatedPart::class, ['equipment_issue_id' => 'id'])->via('equipmentIssues')
            ->where(['type' => IssueRelatedPart::TYPE_PART]);
    }

    public function getStatusDisplay()
    {
        $display = "";
        switch ($this->status) {
            case self::STATUS_SERVICEABLE:
                $display = "Serviceable";
                break;
            case self::STATUS_UNSERVICEABLE:
                $display = "Unserviceable";
                break;
            default:
                $display = "N/A";
                break;
        }
        return $display;
    }

    public function getIssueCountDatasets($lastNMonths = 6)
    {
        $monthsTableQuery = $this->generateNMonthsQuery(6);

        $sql = "SELECT
                    months.month_name,
                    months.month as month,
                    COALESCE(COUNT(ei.fic_equipment_id), 0) AS count
                FROM ({$monthsTableQuery}) months
                LEFT JOIN
                    equipment_issue ei ON ei.fic_equipment_id IS NOT NULL AND
                    date_format(created_at, '%Y-%m') = months.month and ei.fic_equipment_id = :fic_equipment_id
                GROUP BY
                    ei.fic_equipment_id, months.month
                ORDER BY
                    months.month ASC";

        $params = [
            ':fic_equipment_id' => $this->id,
        ];

        return $this::getDb()->createCommand($sql, $params)->queryAll();
    }

    public function getRepairCountDatasets($lastNMonths = 6)
    {
        $monthsTableQuery = $this->generateNMonthsQuery(6);

        $sql = "SELECT
                    months.month_name,
                    months.month as month,
                    coalesce(count(eir.fic_equipment_id), 0) as count
                FROM ({$monthsTableQuery}) months
                LEFT JOIN
                    (select ei.fic_equipment_id, eir.created_at from equipment_issue ei inner join equipment_issue_repair eir 
                    on ei.id = eir.equipment_issue_id and ei.fic_equipment_id = :fic_equipment_id
                    ) eir on eir.fic_equipment_id is not null and 
                    date_format(eir.created_at, '%Y-%m') = months.month
                GROUP BY
                    eir.fic_equipment_id, months.month
                ORDER BY
                    months.month ASC";

        $params = [
            ':fic_equipment_id' => $this->id,
        ];

        return $this::getDb()->createCommand($sql, $params)->queryAll();
    }

    public function getComponentIssueCountDatasets()
    {
        return $this->getIssueRelatedComponents()->select(['component.name', 'type', 'COUNT(equipment_issue_id) AS count'])
            ->joinWith('component')
            ->groupBy(['component.name', 'type'])
            ->orderBy(['count' => SORT_DESC])
            ->limit(5)
            ->asArray()
            ->all();
    }

    public function getPartIssueCountDatasets()
    {
        return $this->getIssueRelatedParts()->select(['part.name', 'type', 'COUNT(equipment_issue_id) AS count'])
            ->joinWith('part')
            ->groupBy(['part.name', 'type'])
            ->orderBy(['count' => SORT_DESC])
            ->limit(5)
            ->asArray()
            ->all();
    }

    /**
     * This function will generate the MySQL query for..
     * ..selecting the last n months
     */
    protected function generateNMonthsQuery($month = 6)
    {
        $months = '';
        for ($i = 1; $i <= $month; $i++) {
            $months .= "UNION ALL SELECT {$i} ";
        }

        $query = "SELECT 
                    DATE_FORMAT(DATE_SUB(NOW(), INTERVAL n MONTH), '%Y-%m') AS month,
                    MONTHNAME(DATE_SUB(NOW(), INTERVAL n MONTH)) AS month_name
                FROM (SELECT 0 n {$months}) months";
        return $query;
    }
}
