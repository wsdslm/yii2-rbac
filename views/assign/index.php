<?php
/**
 * @var yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \ws\rbac\Module $module
 */
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = Yii::$app->request->isPjax ? null : Yii::t('app', 'Assign');
$this->params['breadcrumbs'][] = $this->title;
$module = Yii::$app->controller->module;
?>

<div class="user-index">
    <?php Pjax::begin(['options' => ['id' => 'pjax']]); ?>
    <?= GridView::widget([
        'layout' => "{items}\n{summary}\n{pager}",
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            $module->usernameField,

            [
                'class' => ActionColumn::className(),
                'template' => '{assign}',
                'buttons' => [
                    'assign' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'Assign'),
                            'aria-label' => Yii::t('yii', 'Assign'),
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-user"></span>', [
                            'assign',
                            'uid' => $model->id
                        ], $options);
                    }
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
