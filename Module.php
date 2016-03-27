<?php

namespace ws\rbac;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'ws\rbac\controllers';

    public $usernameField = 'username';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
