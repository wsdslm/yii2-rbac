<?php
namespace ws\rbac\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\rbac\Permission;
use yii\web\Controller;
use yii\web\HttpException;

class PermissionController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $ps = Yii::$app->authManager->getPermissions();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $ps,
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $p = new Permission();
        if (Yii::$app->request->isPost) {
            $p->name = Yii::$app->request->post('name');
            $rule = Yii::$app->request->post('rule');
            $p->ruleName = $rule ? $rule : null;
            $p->description = Yii::$app->request->post('desc');
            $p->data = Yii::$app->request->post('data');
            Yii::$app->authManager->add($p);
            return $this->redirect(['view', 'name' => $p->name]);
        }
        return $this->render('create', [
            'model' => $p,
        ]);
    }

    public function actionUpdate($name)
    {
        $p = $this->findPermission($name);
        if (Yii::$app->request->isPost) {
            $p->name = Yii::$app->request->post('name');
            $rule = Yii::$app->request->post('rule');
            $p->ruleName = $rule ? $rule : null;
            $p->description = Yii::$app->request->post('desc');
            $p->data = Yii::$app->request->post('data');
            if (Yii::$app->authManager->update($name, $p))
                return $this->redirect(['view', 'name' => $p->name]);
        }
        return $this->render('update', [
            'model' => $p,
        ]);
    }

    public function actionView($name)
    {
        $p = $this->findPermission($name);
        return $this->render('view', [
            'model' => $p,
        ]);
    }

    public function actionDelete($name)
    {
        $p = $this->findPermission($name);
        Yii::$app->authManager->remove($p);
        return $this->redirect(['index']);
    }

    protected function findPermission($name)
    {
        $p = Yii::$app->authManager->getPermission($name);
        if ($p) {
            return $p;
        }
        throw new HttpException(404);
    }
}