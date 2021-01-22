<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FruitsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fruits-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'size') ?>

    <?= $form->field($model, 'status_id') ?>

    <?= $form->field($model, 'type_id') ?>

    <?= $form->field($model, 'color_id') ?>

    <?php // echo $form->field($model, 'appearance_time') ?>

    <?php // echo $form->field($model, 'fall_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
