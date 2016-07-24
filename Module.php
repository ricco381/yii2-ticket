<?php

namespace ricco\ticket;

use ricco\ticket\models\User;
use Yii;

/**
 * ticket module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'ricco\ticket\controllers';

    /** @var bool Уведомление на почту о тикетах */
    public $mailSend = false;

    /** @var string Тема email сообщения когда пользователю приходит ответ */
    public $subjectAnswer = 'Ответ на тикет сайта WallBtc.com';

    /** @var  User */
    public $userModel = false;

    public $qq = [
        'Вопрос  по обмену' => 'Вопрос  по обмену',
        'Пополнению ЛК'     => 'Пополнению ЛК',
        'Вводу средств'     => 'Вводу средств',
        'Выводу средств'    => 'Выводу средств',
        'Другое'            => 'Другое',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        User::$user = ($this->userModel !== false) ? $this->userModel : Yii::$app->user->identityClass;
        parent::init();
    }
}
