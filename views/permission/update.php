<?php
/**
 * @var \yii\web\View $this
 * @var \yii\rbac\Permission $model
 */

$this->title = Yii::t('app', 'Update Permission') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Permission'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'name' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

echo $this->render('_form', [
    'create' => false,
    'model' => $model,
]);
