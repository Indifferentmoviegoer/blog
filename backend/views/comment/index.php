<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Комментарии';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-index">

    <p>
        <?= Html::a('Создать комментарий', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php
    // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'user_id',
                'news_id',
                'text',
                'moderation',
                'created_at',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]
    ); ?>

    <?php Pjax::end(); ?>

</div>
