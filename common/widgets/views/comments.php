<?php

use common\models\Comment;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $comments Comment */
/* @var $model Comment */
/* @var $id integer */
/* @var $type integer */

$path = env('APP_URL') . "/img/";
?>

    <h1>Комментарии</h1>
    <br>
    <div id="main2"></div>
    <div>
        <?php foreach ($comments as $comment): ?>
            <div class="news-detail">
                <div class="container">
                        <img src=" <?= $path ?>profile.jpeg" width="50px" alt="">
                        <p><?= $comment->user->username ?></p>
                        <p><?= $comment->text ?></p>
                        <p><?= $comment->created_at ?></p>
                </div>
            </div>
            <br>
        <?php endforeach; ?>
    </div>

<?php if ($type == 1): ?>
    <input type="button" class="show-comment" data-news_id="<?= $id ?>" value="Показать все ответы">
<?php elseif ($type == 2): ?>
    <input type="button" class="show-comment" data-picture_id="<?= $id ?>" value="Показать все ответы">
<?php endif; ?>

    <div id="main"></div>
    <br>

<?php if (!Yii::$app->user->isGuest): ?>
    <?php
    $form = ActiveForm::begin(
        [
            'id' => 'commentForm',
            'action' => false,
        ]
    ); ?>
    <?= $form->field($model, 'text')->textarea() ?>
    <?php if ($type == 1): ?>
        <?= $form->field($model, 'news_id')->hiddenInput(['value' => $id])->label(false) ?>
    <?php elseif ($type == 2): ?>
        <?= $form->field($model, 'picture_id')->hiddenInput(['value' => $id])->label(false) ?>
    <?php endif; ?>
    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
<?php endif; ?>


<?php
$js = <<<JS
    $('#commentForm').on('beforeSubmit', function () {
    let data;
    data = $(this).serialize();
    $.ajax({
        url: '/comment/create',
        type: 'POST',
        data: data,
        success: function (res) {
            if (res.moderation) {
                alert('Комментарий отправлен на премодерацию!');
            } else {
                let list = document.getElementById('main2');
                let div = getComments(res.data);
                list.prepend(div);
                alert('Комментарий успешно добавлен!');
            }

            document.getElementById('comment-text').value = '';
        },
        error: function () {
            alert('Error!');
        }
    });

    return false;
});
JS;

$this->registerJs($js);
?>