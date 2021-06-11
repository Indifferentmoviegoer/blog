<?php

use frontend\models\Gallery;
use frontend\models\GalleryCategory;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
                    <div class="dislike" data-id="<?= $picture->id ?>">
                        <img src="<?= env('APP_URL') ?>/img/comment-dislike.svg" alt="">
                        <span class="counter"><?= $picture->rating->value ?></span>
                        <img src="<?= env('APP_URL') ?>/img/comment-like.svg" alt="">
                    </div>
                    <div class="like" data-id="<?= $picture->id ?>">
                    </div>
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