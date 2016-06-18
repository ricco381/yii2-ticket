<?php

namespace ricco\ticket;

use Yii;
use yii\base\ViewContextInterface;

/**
 * ticket module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'ricco\ticket\controllers';

    /** @var bool Уведомление пользователя об ответе на тикет */
    public $mailSendAnswer = false;

    /** @var bool Уведомление пользователя о закрытии тикета */
    public $mailSendClosed = false;

    /** @var string Тема email сообщения когда пользователю приходит ответ */
    public $subjectAnswer = 'Ответ на тикет';

    /** @var string Тема email сообщения когда тикет пользователя закрыт */
    public $subjectCloset = 'Ваш тикет был закрыт';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
}
