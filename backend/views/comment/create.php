<?php

use common\models\Gallery;
use common\models\News;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */
/* @var $news News */
/* @var $gallery Gallery */

$this->title = 'Создание комментария';
$this->params['breadcrumbs'][] = ['label' => 'Комментарии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-create">

    <?= $this->render('_form', [
        'model' => $model,
        'news' => $news,
        'gallery' => $gallery,
    ]) ?>

</div>
