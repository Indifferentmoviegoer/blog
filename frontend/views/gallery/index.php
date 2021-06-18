<?php

use common\models\GalleryCategory;
use yii\helpers\Url;

/* @var $categories GalleryCategory */

$path = env('APP_URL') . "/img/";
?>
<div class="row">
<?php foreach ($categories as $category): ?>
<div class="col-lg-3">
    <a href="<?= Url::toRoute(['gallery/view', 'id' => $category->id]) ?>">
    <img src=" <?= $path ?>folder.png"  width="124px" alt="">
    <br><?= $category->name ?></a>
</div>
<?php endforeach;?>
</div>