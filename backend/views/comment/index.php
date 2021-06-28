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
    <div class="box">
        <div class="box-body">
            <p>
                <?= Html::a('Создать комментарий', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?php Pjax::begin(); ?>

            <?= GridView::widget(
                [
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'user_id',
                        'news_id',
                        'text',
                        [
                            'attribute' => 'moderation',
                            'value' => function ($data) {
                                if ($data->moderation == 1) {
                                    return "Нет";
                                }
                                return "Да";
                            },
                        ],
                        'created_at',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]
            ); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
