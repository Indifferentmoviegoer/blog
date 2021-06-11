<?php

use frontend\models\GalleryCategory;

/* @var $this yii\web\View */
/* @var $model backend\models\Gallery */
/* @var $upload common\models\UploadGalleryForm */
/* @var $categories GalleryCategory */

$this->title = 'Загрузка изображения';
$this->params['breadcrumbs'][] = ['label' => 'Галерея', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-create">

    <?= $this->render('_form', [
        'model' => $model,
        'upload' => $upload,
        'categories' => $categories,
    ]) ?>

</div>
