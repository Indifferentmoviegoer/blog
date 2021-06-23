<?php

use common\models\Gallery;
use common\models\Rating;
use common\widgets\CommentWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $picture Gallery */
/* @var $model Rating */

$path = env('APP_URL') . "/img/uploads/gallery/";
?>
<img src=" <?= $path . $picture->name ?>" width="125px" alt="">

<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'value')->input('number', ['min' => 1, 'max' => 5])->label('Оценка')->hint('Оценка: от 1 до 5') ?>
    <div class="form-group">
        <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>

<?= CommentWidget::widget(['id' => $picture->id, 'type' => 2]) ?>