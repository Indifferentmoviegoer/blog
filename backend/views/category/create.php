<?php

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $parents array */

$this->title = 'Создание категории';
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
        'parents' => $parents,
    ]) ?>

</div>
