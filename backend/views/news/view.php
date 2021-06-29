<?php

use common\repositories\NewsRepository;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $newsRepository NewsRepository */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="news-view">
    <div class="box">
        <div class="box-body">
            <p>
                <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(
                    'Удалить',
                    ['delete', 'id' => $model->id],
                    [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]
                ) ?>
            </p>

            <?php
            echo DetailView::widget(
                [
                    'model' => $model,
                    'attributes' => [
                        'id',
                        [
                            'attribute' => 'rel',
                            'value' => function ($data) use ($newsRepository) {
                                return $newsRepository->categoryList($data);
                            },
                        ],
                        [
                            'attribute' => 'picture_id',
                            'value' => function ($data) {
                                $path = env('APP_URL');
                                return '<img src="' . $path . $data->picture->name . '"  width="240px" alt="">';
                            },
                            'format' => 'raw'
                        ],
                        'name',
                        'desc',
                        'text:html',
                        'published_at',
                    ],
                ]
            ); ?>

        </div>
    </div>
</div>
