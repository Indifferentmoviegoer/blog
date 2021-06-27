<?php

use common\models\GalleryCategory;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Gallery */
/* @var $form yii\widgets\ActiveForm */
/* @var $upload common\models\UploadGalleryForm */
/* @var $categories GalleryCategory */

$path = env('APP_URL') . "/img/uploads/gallery/";
?>

<div class="gallery-form">

    <?php if (!$model->isNewRecord): ?>
        <img src="<?= $path . $model->name ?>" alt="" width="400px" height="300px">
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo $form->field($upload, 'imageFile')->widget(
        FileInput::class,
        [
            'options' => ['accept' => 'image/*'],
        ]
    ); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>
    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map($categories,'id','name')) ?>
    <?= $form->field($model, 'moderation')->dropDownList(['0' => 'Да', '1' => 'Нет']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
