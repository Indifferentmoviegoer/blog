<?php

use common\models\Gallery;
use common\models\GalleryCategory;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $popularPictures Gallery */
/* @var $lastPictures Gallery */
/* @var $upload common\models\UploadGalleryForm */
/* @var $categories GalleryCategory */

$path = env('APP_URL') . "/img/uploads/gallery/";
?>
<h1>Популярные изображения</h1>
    <div class="row">
        <div class="col-lg-12">
            <?php foreach ($popularPictures as $picture): ?>
                <div class="col-lg-4">
                    <a href="<?= Url::toRoute(['gallery/detail', 'id' => $picture->id]) ?>">
                        <img src=" <?= $path . $picture->name ?>" width="125px" alt="">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<h1>Последние изображения</h1>
<div class="row">
    <div class="col-lg-12">
        <?php foreach ($lastPictures as $picture): ?>
            <div class="col-lg-4">
                <a href="<?= Url::toRoute(['gallery/detail', 'id' => $picture->id]) ?>">
                    <img src=" <?= $path . $picture->name ?>" width="125px" alt="">
                </a>

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
