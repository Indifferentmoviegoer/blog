<?php

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $upload backend\models\UploadForm */

$this->title = 'Обновление новости: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="news-update">

    <?= $this->render('_form', [
        'model' => $model,
        'upload' => $upload,
    ]) ?>

</div>
