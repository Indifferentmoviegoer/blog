<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Gallery */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Галерея', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>

<div class="gallery-view">
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
                            'attribute' => 'name',
                            'value' => function ($data) {
                                return '<img src="' . $data->name . '"  width="240px" alt="">';
                            },
                            'format' => 'raw'
                        ],

                        [
                            'attribute' => 'category_id',
                            'value' => function ($data) {
                                if (empty($data->category->name)) {
                                    return "Категория удалена";
                                }

                                return $data->category->name . ' ' .
                                    Html::a(
                                        '<span class="small glyphicon glyphicon-pencil"></span>',
                                        Url::toRoute(['/gallery-category/update', 'id' => $data->category->id])
                                    );
                            },
                            'format' => 'raw',
                        ],
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
                            'attribute' => 'moderation',
                            'value' => function ($data) {
                                if ($data->moderation == 1) {
                                    return "Нет";
                                }
                                return "Да";
                            },
                        ],
                        'created_at',
                    ],
                ]
            ); ?>

        </div>
    </div>
</div>
