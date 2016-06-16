<?php
namespace ricco\ticket;

class Mailer extends \yii\swiftmailer\Mailer
{
    public $viewPath = '@app/module/ticket/views/ticket/mail';

    public function sendMail()
    {
        $mail = \Yii::$app->mail;
        $mail->viewPath = $this->viewPath;
        $mail->getView()->theme = \Yii::$app->view->theme;
        $mail->compose(2323)->send();
    }
}