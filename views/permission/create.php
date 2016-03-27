<?php
/**
 * @var \yii\web\View $this
 * @var \yii\rbac\Permission $model
 */

$this->title = Yii::t('app', 'Create Permission');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Permission'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_form', [
    'create' => true,
    'model' => $model,
]);
