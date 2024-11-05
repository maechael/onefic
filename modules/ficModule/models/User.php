<?php

namespace app\modules\ficModule\models;

use app\models\User as ModelsUser;
use app\models\UserProfile;
use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property int|null $user_profile_id
 * @property int|null $status
 * @property string|null $auth_token
 * @property string|null $access_token
 * @property string $created_at
 * @property string $updated_at
 *
 * @property UserProfile $userProfile
 */
class User extends ModelsUser
{
    public static function findByUsername($username)
    {
        return static::find()->joinWith('authAssignments')->where(['username' => $username, 'status' => self::STATUS_ACTIVE, 'auth_assignment.item_name' => 'FIC User'])->one();
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_token = Yii::$app->security->generateRandomString();
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
}
