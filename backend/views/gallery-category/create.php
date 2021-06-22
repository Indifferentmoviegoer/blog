<?php

/* @var $this yii\web\View */
/* @var $model common\models\GalleryCategory */

$this->title = 'Создание категории';
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
