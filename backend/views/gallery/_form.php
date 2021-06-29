<?php

use common\models\GalleryCategory;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Gallery */
/* @var $form yii\widgets\ActiveForm */
/* @var $categories GalleryCategory */

$path = env('APP_URL');
?>

<div class="gallery-form">
    <div class="box">
        <div class="box-body">
            <?php if (!$model->isNewRecord): ?>
                <img src="<?= $model->name ?>" alt="" width="450px" height="450px">
            <?php endif; ?>

            <?php $form = ActiveForm::begin(); ?>

            <?php
            echo $form->field($model, 'name')->widget(
                FileInput::class,
                [
                    'options' => ['accept' => 'image/*'],
                ]
            ); ?>

            <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map($categories, 'id', 'name')) ?>
            <?= $form->field($model, 'moderation')->dropDownList(['0' => 'Да', '1' => 'Нет']) ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
