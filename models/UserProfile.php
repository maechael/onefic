<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string|null $middlename
 * @property int|null $fic_affiliation
 * @property int|null $designation_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ContactDetail[] $contactDetails
 * @property User $user
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['firstname', 'lastname', 'middlename'], 'string', 'max' => 32],
            [['fic_affiliation', 'designation_id'], 'integer'],
            [['fic_affiliation'], 'exist', 'skipOnError' => true, 'targetClass' => Fic::class, 'targetAttribute' => ['fic_affiliation' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'middlename' => 'Middlename',
            'fic_affiliation' => 'FIC',
            'designation_id' => 'Designation',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[ContactDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContactDetails()
    {
        return $this->hasMany(ContactDetail::class, ['user_profile_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_profile_id' => 'id']);
    }

    public function getActiveContacts()
    {
        return $this->hasMany(ContactDetail::class, ['user_profile_id' => 'id'])->andWhere(['isActive' => true]);
    }

    public function getFic()
    {
        return $this->hasOne(Fic::class, ['id' => 'fic_affiliation']);
    }

    public function getDesignation()
    {
        return $this->hasOne(Designation::class, ['id' => 'designation_id']);
    }
}
