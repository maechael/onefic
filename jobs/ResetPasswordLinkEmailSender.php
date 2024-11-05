<?php

namespace app\jobs;

use Exception;
use Yii;
use yii\helpers\Url;

/**
 * Class ResetPasswordLinkEmailSender.
 */
class ResetPasswordLinkEmailSender extends \yii\base\BaseObject implements \yii\queue\RetryableJobInterface
{
    public $url;
    public $sender;
    public $receiver;
    public $subject;
    public $token;
    public $mailer;
    public $templatePath;
    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        $testVar = Url::to('@app/views/mailer/reset-password');
        $test =  Yii::$app->mailer->compose('/mailer/reset-password', [
            'url' => $this->url
        ])
            ->setFrom($this->sender)
            ->setTo($this->receiver)
            ->setSubject($this->subject)
            ->send();

        throw new Exception();
    }

    /**
     * @inheritdoc
     */
    public function getTtr()
    {
        return 60 * 3;
    }

    /**
     * @inheritdoc
     */
    public function canRetry($attempt, $error)
    {
        return $attempt < 99;
    }
}
