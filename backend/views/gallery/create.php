<?php

use common\models\GalleryCategory;

/* @var $this yii\web\View */
/* @var $model common\models\Gallery */
/* @var $categories GalleryCategory */

$this->title = 'Загрузка изображения';
$this->params['breadcrumbs'][] = ['label' => 'Галерея', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-create">

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>
