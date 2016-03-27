<?php
/**
 *
 * @var \yii\rbac\Permission $model
 */
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Permission'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-view">
    <p>
    <div class="btn-group pull-right btn-group-sm" style="margin-bottom: 15px;">
        <a type="button" class="btn btn-default" href="<?= Url::to(['update', 'name' => $model->name]); ?>">
            <span class="glyphicon glyphicon-edit"></span>
            <?= Yii::t('app', 'Update'); ?>
        </a>
        <a type="button" class="btn btn-danger" href="<?= Url::to(['delete', 'name' => $model->name]); ?>"
           data-method="post"
           data-confirm="<?= Yii::t('yii', 'Are you sure you want to delete this item?') ?>">
            <span class="glyphicon glyphicon-trash"></span>
            <?= Yii::t('app', 'Delete'); ?>
        </a>
    </div>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description',
            'ruleName',
            'createdAt:date',
            'updatedAt:date',
        ]
    ]) ?>
</div>
