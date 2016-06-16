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
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
}
