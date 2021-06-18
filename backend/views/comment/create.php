<?php

/* @var $this yii\web\View */
/* @var $model common\models\Comment */

$this->title = 'Создание комментария';
$this->params['breadcrumbs'][] = ['label' => 'Комментарии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
