<?php

use common\models\Gallery;
use common\models\News;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */
/* @var $form yii\widgets\ActiveForm */
/* @var $news News */
/* @var $gallery Gallery */
?>

<div class="comment-form">
    <div class="box">
        <div class="box-body">

            <?php $form = ActiveForm::begin(); ?>
            <?php if ($model->isNewRecord): ?>

                <?php
                $format = <<< SCRIPT
                function format(state) {
                    if (!state.id) return state.text;
                    return '<img class="flag" src="' + state.text + '" width="25px"/>' + state.text;
                }
                SCRIPT;
                $escape = new JsExpression("function(m) { return m; }");
                $this->registerJs($format, View::POS_HEAD);
                echo $form->field($model, 'picture_id')->widget(
                    Select2::class,
                    [
                        'name' => 'state_12',
                        'data' => $gallery,
                        'options' => ['placeholder' => 'Выберите изображение ...'],
                        'pluginOptions' => [
                            'templateResult' => new JsExpression('format'),
                            'templateSelection' => new JsExpression('format'),
                            'escapeMarkup' => $escape,
                            'allowClear' => true
                        ],
                    ]
                ); ?>
                <?php
                echo $form->field($model, 'news_id')->widget(
                    Select2::class,
                    [
                        'data' => $news,
                        'language' => 'ru',
                        'options' => ['multiple' => false, 'placeholder' => 'Выберите новость...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]
                ); ?>
            <?php endif; ?>
            <?= $form->field($model, 'text')->textInput() ?>
            <?= $form->field($model, 'moderation')->dropDownList(['0' => 'Да', '1' => 'Нет']) ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
