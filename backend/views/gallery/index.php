<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\GallerySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Галерея';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-index">
    <div class="box">
        <div class="box-body">
            <p>
                <?= Html::a('Загрузить изображение', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?php Pjax::begin(); ?>

            <?php
            echo GridView::widget(
                [
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'name',
                            'value' => function ($data) {
                                $path = env('APP_URL');
                                return '<img src="' . $path . $data->name . '"  width="240px" alt="">';
                            },
                            'format' => 'raw'
                        ],

                        [
                            'attribute' => 'category_id',
                            'value' => function ($data) {
                                return $data->category->name;
                            },
                        ],
                        'user_id',
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
