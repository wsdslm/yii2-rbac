<?php
namespace ws\rbac\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\rbac\ManagerInterface;
use yii\rbac\Role;
use yii\web\Controller;
use yii\web\HttpException;

class RoleController extends Controller
{

    /**
     * @var ManagerInterface
     */
    public $auth;

    public function init()
    {
        parent::init();
        $this->auth = Yii::$app->authManager;
    }

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
        $rs = $this->auth->getRoles();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rs,
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $role = new Role();
        if (Yii::$app->request->isPost) {
            $role->name = Yii::$app->request->post('name');
            $rule = Yii::$app->request->post('rule');
            $role->ruleName = $rule ? $rule : null;
            $role->description = Yii::$app->request->post('desc');
            $role->data = Yii::$app->request->post('data');
            $this->auth->add($role);
            return $this->redirect(['view', 'name' => $role->name]);
        }
        return $this->render('create', [
            'model' => $role,
        ]);
    }

    public function actionUpdate($name)
    {
        $role = $this->findRole($name);
        if (Yii::$app->request->isPost) {
            $role->name = Yii::$app->request->post('name');
            $role->description = Yii::$app->request->post('desc');
            $rule = Yii::$app->request->post('rule');
            $role->ruleName = $rule ? $rule : null;
            $role->data = Yii::$app->request->post('data');
            if ($this->auth->update($name, $role))
                return $this->redirect(['view', 'name' => $name]);
        }
        return $this->render('update', [
            'model' => $role,
        ]);
    }

    public function actionChild($name)
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => $this->auth->getPermissionsByRole($name)
        ]);
        return $this->render('assign', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAjaxChild($name)
    {
        $role = $this->findRole($name);
        $namePermission = Yii::$app->request->post('permission');
        $permission = $this->auth->getPermission($namePermission);
        return $this->auth->addChild($role, $permission) ? 'success' : 'fail';
    }

    public function actionAjaxChildRemove($name)
    {
        $role = $this->findRole($name);
        $namePermission = Yii::$app->request->post('permission');
        $permission = $this->auth->getPermission($namePermission);
        return $this->auth->removeChild($role, $permission) ? 'success' : 'fail';
    }

    public function actionView($name)
    {
        $role = $this->findRole($name);
        if (Yii::$app->request->isPost) {
            $rule = Yii::$app->request->post('rule');
            $role->ruleName = $rule ? $rule : null;
            $role->description = Yii::$app->request->post('desc');
            $role->data = Yii::$app->request->post('data');
            $this->auth->update($name, $role);
            return $this->redirect(['view', 'name' => $role->name]);
        }
        return $this->render('view', [
            'model' => $role,
        ]);
    }

    public function actionDelete($name)
    {
        $role = $this->findRole($name);
        $this->auth->remove($role);
        return $this->redirect(['index']);
    }

    protected function findRole($name)
    {
        $role = $this->auth->getRole($name);
        if ($role) {
            return $role;
        }
        throw new HttpException(404);
    }
}