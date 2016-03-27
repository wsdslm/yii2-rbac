<?php
/**
 * @var \yii\web\View $this
 * @var \yii\data\ArrayDataProvider $dataProvider
 */
use yii\bootstrap\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

$uid = Yii::$app->request->get('uid');
$this->title = Yii::$app->request->isPjax ? null : Yii::t('app', 'Assign for User#{uid}', [
    'uid' => $uid,
]);
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Assign'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-md-4">
        <label><?= Yii::t('app', 'Roles') ?></label>
        <?php Pjax::begin(['options' => ['id' => 'pjax']]); ?>
        <?= GridView::widget([
            'layout' => "{items}\n{summary}\n{pager}",
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                'createdAt:date',
                [
                    'class' => ActionColumn::className(),
                    'template' => '{revoke}',
                    'buttons' => [
                        'revoke' => function ($url, $model, $key) {
                            $options = [
                                'title' => Yii::t('yii', 'Revoke'),
                                'aria-label' => Yii::t('yii', 'Revoke'),
                                'onclick' => "revoke('{$model->name}')",
                            ];
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                                'javascript:void(0)',
                                $options);
                        }
                    ]
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
    <div class="col-md-4">
        <form onsubmit="return assign();">
            <div class="form-group">
                <label><?= Yii::t('app', 'Add Role') ?></label>
                <?= Html::dropDownList('name', null,
                    ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name'), [
                        'id' => 'item-name',
                        'class' => 'form-control',
                    ]) ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Assign'), ['class' => 'btn btn-default']) ?>
            </div>
        </form>
    </div>
</div>
<script>
    var uid = <?= $uid ?>;
    function assign() {
        var url = '<?= Url::to(['assign/ajax-assign']) ?>';
        var name = $('#item-name').val();
        $.post(url, {name: name, uid: uid}, function (data) {
            if (data == 'success')
                $.pjax.reload('#pjax');
        }, 'text');
        return false;
    }
    function revoke(name) {
        var url = '<?= Url::to(['assign/ajax-revoke']) ?>';
        $.post(url, {name: name, uid: uid}, function (data) {
            if (data == 'success')
                $.pjax.reload('#pjax');
        }, 'text');
    }
</script>
