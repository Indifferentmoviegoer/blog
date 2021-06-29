<?php

use common\models\Gallery;
use common\models\GalleryCategory;
use yii\helpers\Url;

/* @var $categories GalleryCategory */
/* @var $popularWeek Gallery */

?>
<div class="news-detail">
    <div class="container">
        <h1>Категории</h1>
        <div class="row">
            <div class="col-lg-12">
                <?php foreach ($categories as $category): ?>
                    <div class="col-lg-3">
                        <a href="<?= Url::toRoute(['gallery/view', 'id' => $category->id]) ?>">
                            <img src="/img/folder.png" width="124px" alt="">
                            <br><?= $category->name ?></a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<br>

<div class="news-detail">
    <div class="container">
        <h1>Популярные изображения за неделю</h1>
        <div class="row">
            <div class="col-lg-12">
                <?php foreach ($popularWeek as $picture): ?>
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