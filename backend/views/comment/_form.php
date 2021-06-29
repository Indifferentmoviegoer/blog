<?php

use common\models\News;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */
/* @var $form yii\widgets\ActiveForm */
/* @var $news News */
?>

<div class="comment-form">
    <div class="box">
        <div class="box-body">

            <?php $form = ActiveForm::begin(); ?>
            <?php if($model->isNewRecord): ?>
                <?= $form->field($model, 'picture_id')->textInput() ?>
                <?php echo $form->field($model, 'news_id')->widget(
                    Select2::class,
                    [
                        'data' => $news,
                        'language' => 'ru',
                        'options' => ['multiple' => false, 'placeholder' => 'Введите наименование новости...'],
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
