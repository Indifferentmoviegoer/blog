<?php

use common\models\Gallery;
use common\models\GalleryCategory;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

/* @var $popularPictures Gallery */
/* @var $lastPictures Gallery */
/* @var $categories GalleryCategory */
/* @var $pages LinkPager */
/* @var $model Gallery */
?>
<div class="news-detail">
    <div class="container">
        <h1>Популярные изображения</h1>
        <div class="row">
            <div class="col-lg-12">
                <?php foreach ($popularPictures as $picture): ?>
                    <div class="col-lg-4">
                        <a href="<?= Url::toRoute(['gallery/detail', 'id' => $picture->id]) ?>">
                            <img src=" <?= $picture->name ?>" width="125px" alt="">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<br>
<div class="news-detail">
    <div class="container">
        <h1>Последние изображения</h1>
        <div class="row">
            <div class="col-lg-12">
                <?php foreach ($lastPictures as $picture): ?>
                    <div class="col-lg-4">
                        <a href="<?= Url::toRoute(['gallery/detail', 'id' => $picture->id]) ?>">
                            <img src=" <?= $picture->name ?>" width="125px" alt="">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            <?= LinkPager::widget(['pagination' => $pages]) ?>
        </div>
    </div>
</div>
<br>

<?php if (!Yii::$app->user->isGuest): ?>

    <?php $form = ActiveForm::begin(); ?>
    <?php
    echo $form->field($model, 'name')->widget(
        FileInput::class,
        [
            'options' => ['accept' => 'image/*'],
        ]
    ); ?>
    <div class="form-group">
        <?= Html::submitButton('Загрузить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

<?php endif; ?>
