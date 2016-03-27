<?php
/**
 * @var \yii\web\View $this
 * @var \yii\rbac\Role $model
 */

$this->title = Yii::t('app', 'Create Role');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Role'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_form', [
    'create' => true,
    'model' => $model,
]);
