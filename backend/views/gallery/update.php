<?php

use common\models\GalleryCategory;

/* @var $this yii\web\View */
/* @var $model common\models\Gallery */
/* @var $categories GalleryCategory */

$this->title = 'Обновить изображение: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="gallery-update">

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>
