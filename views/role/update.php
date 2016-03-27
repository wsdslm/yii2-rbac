<?php
/**
 * @var \yii\rbac\Role $model
 */

$this->title = Yii::t('app', 'Update Role') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Role'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'name' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

echo $this->render('_form', [
    'create' => false,
    'model' => $model,
]);