<?php
/**
 * @var \yii\web\View $this
 * @var \yii\data\ArrayDataProvider $dataProvider
 */
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = Yii::$app->request->isPjax ? null : Yii::t('app', 'Role');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-index">
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
                'template' => '{view} {update} {child} {delete}',
                'buttons' => [
                    'child' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'Add Child'),
                            'aria-label' => Yii::t('yii', 'Add Child'),
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-cog"></span>', [
                            'child',
                            'name' => $model->name
                        ], $options);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::to([$action, 'name' => $model->name]);
                },
            ],
        ],
    ]) ?>
    <?php Pjax::end(); ?>
</div>


