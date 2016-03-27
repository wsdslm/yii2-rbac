<?php
namespace ws\rbac\components;

use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

class RouteAccessFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        $auth = Yii::$app->authManager;
        $uid = Yii::$app->user->id;
        $controller = $action->controller;
        $module = $controller->module;
        if ($auth->checkAccess($uid, '*') || $auth->checkAccess($uid, '*.*.*'))
            return true;
        if ($auth->checkAccess($uid, $module->id . '.*.*'))
            return true;
        if ($auth->checkAccess($uid, $module->id . '.' . $controller->id . '.*'))
            return true;
        if ($auth->checkAccess($uid, $module->id . '.' . $controller->id . '.' . $action->id))
            return true;
        throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
    }
}
