<?php

namespace ws\rbac\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class AssignController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => call_user_func([Yii::$app->user->identityClass, 'find']),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAssign($uid)
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => Yii::$app->authManager->getRolesByUser($uid)
        ]);
        return $this->render('assign', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAjaxAssign()
    {
        $uid = Yii::$app->request->post('uid');
        $name = Yii::$app->request->post('name');
        $role = Yii::$app->authManager->getRole($name);
        if (!$role)
            return 'role no found.';
        Yii::$app->authManager->assign($role, $uid);
        return 'success';
    }

    public function actionAjaxRevoke()
    {
        $uid = Yii::$app->request->post('uid');
        $name = Yii::$app->request->post('name');
        $role = Yii::$app->authManager->getRole($name);
        if (!$role)
            return 'role no found.';
        Yii::$app->authManager->revoke($role, $uid);
        return 'success';
    }
}