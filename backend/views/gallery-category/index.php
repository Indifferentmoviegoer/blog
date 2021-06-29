<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\GalleryCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории изображений';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="gallery-category-index">
    <div class="box">
        <div class="box-body">
            <p>
                <?= Html::a('Создать категорию', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?php Pjax::begin(); ?>

            <?php
            echo GridView::widget(
                [
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'name',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]
            ); ?>

            <?php Pjax::end(); ?>

        </div>
    </div>
</div>
