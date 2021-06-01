<?php

use frontend\models\News;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use yii2mod\comments\widgets\Comment;

/* @var $news News */

$path = env('APP_URL') . "/img/uploads/";

if (Yii::$app->user->isGuest && $news->forbidden == 1) {
    throw new ForbiddenHttpException();
}
?>
<div class="news-detail">
    <h1><?= $news->name ?></h1>
    <p><?= $news->published_at ?></p>
    <img src="<?= $path . $news->picture->name ?>" alt="">
    <?= $news->text ?>

    <?php
    echo Comment::widget(
        [
            'model' => $news,
            'relatedTo' => 'Пользователь ' . Yii::$app->user->identity->username . ' оставил комментарий на ' . $news->name . Url::current(
                ),
            'maxLevel' => 2,
            'dataProviderConfig' => [
                'pagination' => [
                    'pageSize' => 10
                ],

            ],
            'listViewConfig' => [
                'emptyText' => 'Нет комментариев.',
            ],
        ]
    ); ?>
</div>
