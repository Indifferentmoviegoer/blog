<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
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

            <?php
            Pjax::begin(); ?>

            <?= GridView::widget(
                [
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'user_id',
                            'value' => static function ($data) {
                                if (empty($data->user->username)) {
                                    return "Пользователь удален";
                                }

                                return $data->user->username . ' ' .
                                    Html::a(
                                        '<span class="small glyphicon glyphicon-pencil"></span>',
                                        Url::toRoute(['/user/update', 'id' => $data->user->id])
                                    );
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'news_id',
                            'value' => function ($data) {
                                if (empty($data->news->name)) {
                                    return "Новость удалена";
                                }

                                return $data->news->name . ' ' .
                                    Html::a(
                                        '<span class="small glyphicon glyphicon-pencil"></span>',
                                        Url::toRoute(['/news/update', 'id' => $data->news->id])
                                    );
                            },
                            'format' => 'raw',
                        ],
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

            <?php
            Pjax::end(); ?>
        </div>
    </div>
</div>
