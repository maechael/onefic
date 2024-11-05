<?php

namespace app\controllers;

use app\jobs\ResetPasswordLinkEmailSender;
use app\models\ForgotPasswordForm;
use app\models\LoginForm;
use app\models\PasswordResetRequestForm;
use app\models\User;
use dominus77\sweetalert2\Alert;
use InvalidArgumentException;
use app\models\ResetPasswordForm;
use Yii;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;

class AuthController extends \yii\web\Controller
{
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'main-login';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        $emailModel = new PasswordResetRequestForm();
        return $this->render('login', [
            'model' => $model,
            'emailModel' => $emailModel
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        //return $this->goHome();

        return Yii::$app->getResponse()->redirect(array(Url::to(['auth/login'])));
    }

    public function actionForgotPassword()
    {
        $emailModel = new PasswordResetRequestForm();
        $model = new LoginForm();
        if ($emailModel->load(Yii::$app->request->post()) && $this->request->isPost) {
            if (!$emailModel->generatePasswordResetToken()) {

                // Yii::$app->queue->push(new ResetPasswordLinkEmailSender([
                //     'url' => "ficphil.test/auth/reset-password?token={$token}",
                //     'sender' => 'itdi_dev@ficphil.com',
                //     'receiver' => $emailModel->email,
                //     'subject' => 'Email Reset Link',
                //     'token' => $token,
                //     'mailer' => Yii::$app->mailer,
                //     'templatePath' => '@app/views/mailer/reset-password'

                // ]));
                Yii::$app->session->setFlash(Alert::TYPE_SUCCESS, [
                    'title' => 'Email Sent',
                    'text' => "The Reset Password link is sent in your email",
                ]);
            } else {
                Yii::$app->session->setFlash(Alert::TYPE_ERROR, [
                    'title' => 'ERORR',
                    'text' => "The email does not exist",
                ]);
            }
        }
        return $this->redirect('login');
    }


    public function actionResetPassword($token)
    {
        try {
            //$model = new ResetPasswordForm($token);
            $model = new ResetPasswordForm($token);
            $this->layout = 'password_reset_layout';
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        $model->load(Yii::$app->request->post());
        if ($model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->redirect('login');
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
