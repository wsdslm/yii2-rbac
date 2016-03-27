<?php
/**
 * @var \yii\web\View $this
 * @var \yii\data\ArrayDataProvider $dataProvider
 * @var \yii\rbac\Role $role
 */
use yii\bootstrap\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

$name = Yii::$app->request->get('name');
$this->title = Yii::$app->request->isPjax ? null : Yii::t('app', 'Add Child for Role#{name}', [
    'name' => $name,
]);
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Role'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-md-4">
        <label><?= Yii::t('app','Childes') ?></label>
        <?php Pjax::begin(['options' => ['id' => 'pjax']]); ?>
        <?= GridView::widget([
            'layout' => "{items}\n{summary}\n{pager}",
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
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
        <form onsubmit="return addChild();">
            <div class="form-group">
                <label><?= Yii::t('app', 'Add Child') ?></label>
                <?= Html::dropDownList('name', null,
                    ArrayHelper::map(Yii::$app->authManager->getPermissions(), 'name', 'name'), [
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
    var name = '<?= $name ?>';
    function addChild() {
        var url = '<?= Url::to(['ajax-child', 'name' => $name]) ?>';
        var permission = $('#item-name').val();
        $.post(url, {permission: permission}, function (data) {
            if (data == 'success')
                $.pjax.reload('#pjax');
        }, 'text');
        return false;
    }
    function revoke(permission) {
        var url = '<?= Url::to(['ajax-child-remove', 'name' => $name]) ?>';
        $.post(url, {permission: permission}, function (data) {
            if (data == 'success')
                $.pjax.reload('#pjax');
        }, 'text');
    }
</script>
