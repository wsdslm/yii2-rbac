<?php
/**
 * @var \yii\web\View $this
 * @var \yii\data\ArrayDataProvider $dataProvider
 */
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = Yii::$app->request->isPjax ? null : Yii::t('app', 'Permission');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-index">
    <p>
        <a class="btn btn-default btn-sm" href="<?= Url::to(['create']) ?>">
            <span class="glyphicon glyphicon-plus"></span>
            <?= Yii::t('app', 'Create'); ?>
        </a>
    </p>
    <?php Pjax::begin(['options' => ['id' => 'pjax']]); ?>
    <?= GridView::widget([
        'layout' => "{items}\n{summary}\n{pager}",
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'description',
            'ruleName',
            'createdAt:date',
            'updatedAt:date',

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::to([$action, 'name' => $model->name]);
                },
            ],
        ],
    ]) ?>
    <?php Pjax::end(); ?>
</div>
