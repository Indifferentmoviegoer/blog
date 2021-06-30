<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\GalleryCategory */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Категории изображений', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>

<div class="gallery-category-view">
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
                        'name',
                    ],
                ]
            ); ?>

        </div>
    </div>
</div>
