<?php

/* @var $this yii\web\View */
/* @var $model common\models\GalleryCategory */

$this->title = 'Обновить категорию: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="gallery-category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
