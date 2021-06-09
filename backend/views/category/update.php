<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Category */

$this->title = 'Обновить категорию: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
