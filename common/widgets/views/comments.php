<?php

use common\models\Comment;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $comments Comment */
/* @var $model Comment */
/* @var $id integer */
/* @var $type integer */
?>

    <h1>Комментарии</h1>
    <br>
    <div id="new-comment"></div>
    <div>
        <?php foreach ($comments as $comment): ?>
            <div class="news-detail">
                <div class="container">
                    <div class="comment-item">
                        <div class="comment">
                            <img src="/img/profile.jpeg" width="50px" alt="">
                            <p><?= empty($comment->user->username) ? "Пользователь удален" : $comment->user->username ?></p>
                            <p><?= $comment->text ?></p>
                            <p><?= $comment->created_at ?></p>
                        </div>
                    </div>
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

    <div id="more-comment"></div>
    <br>

<?php if (!Yii::$app->user->isGuest): ?>
    <?php
    $form = ActiveForm::begin(
        [
            'id' => 'commentForm',
            'action' => false,
            'validateOnSubmit' => true,
        ]
    ); ?>
    <?= $form->field($model, 'text')->textarea(['id' => 'text-comment']) ?>
    <?php if ($type == 1): ?>
        <?= $form->field($model, 'news_id')->hiddenInput(['value' => $id])->label(false) ?>
    <?php elseif ($type == 2): ?>
        <?= $form->field($model, 'picture_id')->hiddenInput(['value' => $id])->label(false) ?>
    <?php endif; ?>
    <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->identity->getId()])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
<?php endif; ?>