<?php
/**
 * @var boolean $create
 * @var \yii\rbac\Role $model
 */
use yii\bootstrap\Html;

?>
<div class="user-form col-md-8 col-lg-6">
    <?= Html::beginForm() ?>
    <div class="form-group">
        <label class="control-label"><?= Yii::t('app', 'Name') ?></label>
        <input class="form-control" type="text" name="name"
               value="<?= $model->name ?>"<?= $create ? '' : ' readonly' ?>/>
    </div>
    <div class="form-group">
        <label class="control-label"><?= Yii::t('app', 'Description') ?></label>
        <textarea class="form-control" name="desc"><?= $model->description ?></textarea>
    </div>
    <div class="form-group">
        <label class="control-label"><?= Yii::t('app', 'Rule Name') ?></label>
        <input class="form-control" name="rule" value="<?= $model->ruleName ?>"/>
    </div>
    <div class="form-group">
        <?= Html::submitButton($create ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-default']) ?>
    </div>
    <?= Html::endForm() ?>
</div>
