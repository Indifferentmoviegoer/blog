<?php

use common\models\Comment;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $comments Comment */
/* @var $model Comment */
/* @var $id integer */

$path = env('APP_URL') . "/img/";
?>

<?php
Pjax::begin(
    [
        'id' => 'commentPjax'
    ]
) ?>
<h1>Комментарии</h1>
<br>
<div>
    <?php foreach ($comments as $comment): ?>
        <div style="background-color: white">
            <img src=" <?= $path ?>profile.jpeg" width="50px" alt="">
            <p><?= $comment->user->username ?></p>
            <p><?= $comment->text ?></p>
            <p><?= $comment->created_at ?></p>
        </div>
        <br>
    <?php endforeach; ?>
</div>
<?php Pjax::end() ?>

<input type="button" id="button" class="show-comment" data-news_id="<?= $id ?>" value="Показать все ответы">
<div id="main"></div>

<?php
if (!Yii::$app->user->isGuest): ?>
    <?php
    $form = ActiveForm::begin(
        [
            'action' => false,
        ]
    ); ?>
    <?= $form->field($model, 'text')->textarea() ?>
    <?= $form->field($model, 'news_id')->hiddenInput(['value' => $id])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
<?php endif; ?>

