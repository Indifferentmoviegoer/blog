<?php

use common\models\Picture;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $picture Picture */
/* @var $tree array */

$this->title = 'Создание новости';
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-create">

    <?= $this->render('_form', [
        'model' => $model,
        'picture' => $picture,
        'tree' => $tree,
    ]) ?>

</div>
