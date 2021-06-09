<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p><?= Html::a('Создать пользователя', ['create'], ['class' => 'btn btn-success']) ?></p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    echo GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'summary' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'username:text',
                'email:text',
                [
                    'attribute' => 'role',
                    'label' => 'Роль',
                    'format' => 'text',
                    'value' => function ($data) {
                        if (mb_strpos($data->roles[0], 'admin') !== false) {
                            return 'Админ';
                        } elseif (mb_strpos($data->roles[0], 'redactor') !== false) {
                            return 'Редактор';
                        }
                        return 'Пользователь';
                    }
                ],
                [
                    'attribute' => 'status',
                    'format' => 'text',
                    'value' => function ($data) {
                        if ($data->status == 10) {
                            return 'Активный';
                        }
                        return 'Неактивный';
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                ],
            ]
        ]
    ); ?>

    <?php Pjax::end(); ?>

</div>
