<?php

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $upload backend\models\UploadForm */

$this->title = 'Создание новости';
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-create">

    <?= $this->render('_form', [
        'model' => $model,
        'upload' => $upload,
    ]) ?>

</div>
