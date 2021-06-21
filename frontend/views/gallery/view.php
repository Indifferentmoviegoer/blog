<?php

use common\models\Gallery;
use common\models\GalleryCategory;
use kartik\file\FileInput;
use yii\helpers\Html;
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
                    <img src=" <?= $path . $picture->name ?>" width="125px" alt="">

                    <?php
                    Pjax::begin(
                        [
                            'id' => 'galleryPjax'
                        ]
                    ) ?>
                    <div>
<!--                        <img id="dislike" data-picture_id="--><?//= $picture->id ?><!--" src="--><?//= env('APP_URL') ?><!--/img/comment-dislike.svg" alt="">-->
                        <input type="button" id="dislike" data-picture_id="<?= $picture->id ?>" value="Дизлайк">
                        <span id="count" class="counter"><?= $picture->rating->value ?></span>
<!--                        <img id="like" src="--><?//= env('APP_URL') ?><!--/img/comment-like.svg" alt="">-->
                        <input type="button" id="like" data-picture_id="<?= $picture->id ?>" value="Лайк">
                    </div>
                    <?php Pjax::end() ?>
                </div>

            <?php endforeach; ?>
        </div>

    </div>

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