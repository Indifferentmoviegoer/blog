<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <div class="box">
        <div class="box-body">

            <p>
                <?= Html::a('Создать категорию', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?php Pjax::begin(); ?>

            <?= GridView::widget(
                [
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'parent_id',
                            'value' => function ($data) {
                                return !empty($data->category->name) ? $data->category->name : 'Категория без родителя';
                            },
                        ],
                        'name',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]
            ); ?>

            <?php Pjax::end(); ?>

        </div>
    </div>
</div>
