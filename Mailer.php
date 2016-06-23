<?php
namespace ricco\ticket;

use yii\helpers\Url;

class Mailer extends \yii\swiftmailer\Mailer
{
    public $viewPath = '@ricco/ticket/views/ticket/mail';

    private $nameTicket; /** @var string Название тикета */
    private $textTicket; /** @var string Тест сообщения */
    private $status; /** @var integer Статус тикета */
    private $subject; /** @var string Тема email сообщения */
    private $urlTicket; /** @var  string url тикета на который был дан ответ */
    private $setTo; /** @var string email юзера которому будет отправлено сообщение */

    /** @var  \yii\swiftmailer\Mailer $mail */
    protected $mail;

    public function init()
    {
        $this->mail = \Yii::$app->mailer;
        $this->mail->viewPath = $this->viewPath;
        $this->mail->getView()->theme = \Yii::$app->view->theme;

        parent::init();
    }

    /**
     * @param $nameTicket
     * @param $textTicket
     * @param $status integer Статус
     * @param $id int
     * @return $this
     */
    public function sendMailDataTicket($nameTicket, $status, $id, $textTicket = '')
    {
        $this->nameTicket = $nameTicket;
        $this->textTicket = $textTicket;
        $this->status = $status;
        $this->urlTicket = $this->getLinkTicket($id);

        return $this;
    }

    /**
     * @param $userEmail
     * @param $subject
     * @return $this
     */
    public function setDataFrom($userEmail, $subject)
    {
        $this->setTo = $userEmail;
        $this->subject = $subject;

        return $this;
    }

    /**
     * @param $view string Вит отображения email сообщения
     */
    public function senda($view)
    {
        $this->mail->compose($view, [
            'nameTicket' => $this->nameTicket,
            'textTicket' => $this->textTicket,
            'status' => $this->status,
            'link' => $this->urlTicket,
        ])
            ->setFrom(\Yii::$app->params['adminEmail'])
            ->setTo($this->setTo)
            ->setSubject($this->subject)
            ->send();
    }

    /**
     * @param $id int Id Тикета
     * @return string Возвращает ссылку на тикет
     */
    private function getLinkTicket($id)
    {
        return Url::to(['/ticket/ticket/view'], true) . "?id=" . $id;
    }
}