<?php

use common\models\Gallery;
use common\models\GalleryCategory;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $pictures Gallery */
/* @var $upload common\models\UploadGalleryForm */
/* @var $categories GalleryCategory */

$path = env('APP_URL') . "/img/uploads/gallery/";
?>

    <div class="row">
        <div class="col-lg-12">
            <?php foreach ($pictures as $picture): ?>
                <div class="col-lg-4">
                    <a href="<?= Url::toRoute(['gallery/detail', 'id' => $picture->id]) ?>">
                        <img src=" <?= $path . $picture->name ?>" width="125px" alt="">
                    </a>

                    <div>
<!--                        <img id="dislike" data-picture_id="--><?//= $picture->id ?><!--" src="--><?//= env('APP_URL') ?><!--/img/comment-dislike.svg" alt="">-->
                        <input type="button" class="dislike" id="dislike" data-picture_id="<?= $picture->id ?>" value="Дизлайк">
                        <?php
                        Pjax::begin(
                            [
                                'id' => 'galleryPjax-' . $picture->id,
                            ]
                        ) ?>
                        <span id="count" class="counter"><?= $picture->rating ?></span>
                        <?php Pjax::end() ?>
<!--                        <img id="like" src="--><?//= env('APP_URL') ?><!--/img/comment-like.svg" alt="">-->
                        <input type="button" class="like" id="like" data-picture_id="<?= $picture->id ?>" value="Лайк">
                    </div>

                </div>

            <?php endforeach; ?>
        </div>

    </div>

<?php if (!Yii::$app->user->isGuest): ?>

<?php $form = ActiveForm::begin(); ?>

<?php
echo $form->field($upload, 'imageFile')->widget(
    FileInput::class,
    [
        'options' => ['accept' => 'image/*'],
    ]
); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>
<?php endif; ?>
