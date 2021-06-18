<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gallery-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>
    <?= $form->field($model, 'picture_id')->textInput() ?>
    <?= $form->field($model, 'news_id')->textInput() ?>
    <?= $form->field($model, 'text')->textInput() ?>
    <?= $form->field($model, 'moderation')->dropDownList(['0' => 'Да', '1' => 'Нет']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
