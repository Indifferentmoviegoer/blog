<?php

use common\models\Picture;
use dominus77\tinymce\TinyMce;
use kartik\datetime\DateTimePicker;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */
/* @var $tree array */
/* @var $picture Picture */

$path = env('APP_URL');
$param = ['options' => [$model->forbidden => ['Selected' => true]]];
$dropDownItems = ['0' => 'Разрешен', '1' => 'Запрещен'];
?>

<div class="news-form">
    <div class="box">
        <div class="box-body">

            <?php if (!$model->isNewRecord): ?>
                <img src="<?= $path . $model->picture->name ?>" alt="" width="400px" height="200px">
            <?php endif; ?>

            <?php $form = ActiveForm::begin(); ?>


            <?php
            echo $form->field($picture, 'name')->widget(
                FileInput::class,
                [
                    'options' => ['accept' => 'image/*'],
                ]
            ); ?>

            <?php
            echo $form->field($model, 'rel')->widget(
                Select2::class,
                [
                    'data' => $tree,
                    'language' => 'ru',
                    'options' => ['placeholder' => 'Выберите категорию'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'multiple' => true
                    ],
                ]
            ); ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>

            <?php
            echo $form->field($model, 'text')->widget(
                TinyMce::class,
                [
                    'options' => ['rows' => 6],
                    'language' => 'ru',
                    'clientOptions' => [
                        'plugins' => [
                            "advlist autolink lists link charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu paste"
                        ],
                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                    ]
                ]
            ); ?>

            <?php
            echo $form->field($model, 'published_at')->widget(
                DateTimePicker::class,
                [
                    'name' => 'published_at',
                    'readonly' => true,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd hh:ii:ss'
                    ]
                ]
            ); ?>

            <?= $form->field($model, 'forbidden')->dropDownList($dropDownItems, ['value' => $model->forbidden]) ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
