<?php

use frontend\models\News;
use yii\web\ForbiddenHttpException;

/* @var $news News */

$path = env('APP_URL') . "/img/uploads/";

if(Yii::$app->user->isGuest && $news->forbidden == 1){
   throw new ForbiddenHttpException();
}
?>
<div class="news-detail">
    <h1><?= $news->name ?></h1>
    <p><?= $news->published_at ?></p>
    <img src="<?= $path . $news->picture->name ?>" alt="">
    <?= $news->text ?>
</div>
