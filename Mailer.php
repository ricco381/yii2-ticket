<?php
namespace ricco\ticket;

class Mailer extends \yii\swiftmailer\Mailer
{
    public $viewPath = '@ricco/ticket/views/ticket/mail';

    public function sendMail()
    {
        $mail = \Yii::$app->mail;
        $mail->viewPath = $this->viewPath;
        $mail->getView()->theme = \Yii::$app->view->theme;
    }
}