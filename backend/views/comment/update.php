<?php

/* @var $this yii\web\View */
/* @var $model common\models\Comment */

$this->title = 'Редактирование комментария: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Комментарии', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="comment-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
