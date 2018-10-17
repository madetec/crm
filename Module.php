<?php

namespace madetec\crm;

use madetec\crm\entities\User;

use Yii;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    public $layout = 'main';

    public $defaultRoute = 'default/index';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'madetec\crm\controllers';

    /**
     *
     */
    public function init()
    {
        parent::init();
    }
}
