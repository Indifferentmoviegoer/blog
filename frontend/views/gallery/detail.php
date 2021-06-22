<?php

use common\models\Gallery;
use common\widgets\CommentWidget;
use yii\widgets\Pjax;

/* @var $model Gallery */

$path = env('APP_URL') . "/img/uploads/gallery/";
?>
<img src=" <?= $path . $model->name ?>" width="125px" alt="">


                    <div>
<!--                        <img id="dislike" data-picture_id="--><?//= $picture->id ?><!--" src="--><?//= env('APP_URL') ?><!--/img/comment-dislike.svg" alt="">-->
                        <input type="button" class="dislike" id="dislike" data-picture_id="<?= $model->id ?>" value="Дизлайк">
                        <?php
                        Pjax::begin(
                            [
                                'id' => 'galleryPjax-' . $model->id,
                            ]
                        ) ?>
                        <span id="count" class="counter"><?= $model->rating ?></span>
                        <?php Pjax::end() ?>
<!--                        <img id="like" src="--><?//= env('APP_URL') ?><!--/img/comment-like.svg" alt="">-->
                        <input type="button" class="like" id="like" data-picture_id="<?= $model->id ?>" value="Лайк">
                    </div>

<?= CommentWidget::widget(['id' => $model->id, 'type' => 2]) ?>