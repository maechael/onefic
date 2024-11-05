<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job_order_request".
 *
 * @property int $id
 * @property int|null $fic_id
 * @property string $request_type
 * @property string|null $requestor
 * @property string|null $requestor_contact
 * @property int|null $requestor_profile_id
 * @property string|null $request_description
 * @property string $request_date
 * @property int|null $status
 * @property string|null $date_approved
 * @property string|null $request_approved_by
 * @property string|null $request_noted_by
 * @property string|null $request_personnel_in_charge
 * @property string|null $date_accomplished
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Fic $fic
 * @property UserProfile $requestorProfile
 */
class JobOrderRequest extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_DECLINED = 2;
    const STATUS_CANCELLED = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_order_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fic_id', 'requestor_profile_id', 'status'], 'integer'],
            [['request_type', 'request_date'], 'required'],
            [['request_description'], 'string'],
            [['request_date', 'date_approved', 'date_accomplished', 'created_at', 'updated_at'], 'safe'],
            [['request_type', 'requestor', 'requestor_contact', 'request_approved_by', 'request_noted_by', 'request_personnel_in_charge'], 'string', 'max' => 255],
            [['fic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fic::className(), 'targetAttribute' => ['fic_id' => 'id']],
            [['requestor_profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserProfile::className(), 'targetAttribute' => ['requestor_profile_id' => 'id']],
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
            'request_type' => 'Request Type',
            'requestor' => 'Requestor',
            'requestor_contact' => 'Requestor Contact',
            'requestor_profile_id' => 'Requestor Profile ID',
            'request_description' => 'Request Description',
            'request_date' => 'Request Date',
            'status' => 'Status',
            'date_approved' => 'Date Approved',
            'request_approved_by' => 'Request Approved By',
            'request_noted_by' => 'Request Noted By',
            'request_personnel_in_charge' => 'Request Personnel In Charge',
            'date_accomplished' => 'Date Accomplished',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Fic]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFic()
    {
        return $this->hasOne(Fic::className(), ['id' => 'fic_id']);
    }

    /**
     * Gets query for [[RequestorProfile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequestorProfile()
    {
        return $this->hasOne(UserProfile::className(), ['id' => 'requestor_profile_id']);
    }
}
