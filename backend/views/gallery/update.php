<?php

use common\models\GalleryCategory;

/* @var $this yii\web\View */
/* @var $model common\models\Gallery */
/* @var $upload common\models\UploadGalleryForm */
/* @var $categories GalleryCategory */

$this->title = 'Обновить категорию: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="gallery-update">

    <?= $this->render('_form', [
        'model' => $model,
        'upload' => $upload,
        'categories' => $categories,
    ]) ?>

</div>
