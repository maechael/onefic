<?php

namespace app\models;

use Yii;
use yii\base\Model;


class PasswordResetRequestForm extends Model
{
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email', 'exist',
                'targetClass' => '\common\models\User',
                // 'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function generatePasswordResetToken()
    {
        $postedEmail = $this->email;

        /* @var $user User */
        $user = User::findOne(['email' => $postedEmail]);

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        Yii::$app->mailer->compose('@app/views/mailer/reset-password', [
            'url' => "ficphil.test/auth/reset-password?token={$user->password_reset_token}"
        ])
            ->setFrom(['itdi_dev@ficphil.com'])
            ->setTo($postedEmail)
            ->setSubject('reset password link')
            ->send();

        // Yii::$app->session->setFlash('success', 'The Password Link reset is sent on your email');



        // Yii::$app->session->setFlash(Alert::TYPE_SUCCESS, [
        //     'title' => 'Email has been sent',
        //     'text' => "Please wait for the reply",
        // ]);
    }
}
