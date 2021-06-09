<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="news-index">

    <p>
        <?= Html::a('Создать новость', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'rel',
                    'value' => function ($data) {
                        return $data->categoryList();
                    },
                ],
                [
                    'attribute' => 'picture_id',
                    'value' => function ($data) {
                        $path = env('APP_URL') . "/img/uploads/";
                        return '<img src="' . $path . $data->picture->name . '"  width="240px" alt="">';
                    },
                    'format' => 'raw'
                ],
                'name',
                'desc',
                [
                    'attribute' => 'text',
                    'format' => 'html',
                    'value' => function ($data) {
                        return $data->getShortText();
                    },
                ],

                'published_at',
                [
                    'attribute' => 'forbidden',
                    'value' => function ($data) {
                        if ($data->forbidden == 1) {
                            return "Запрещен";
                        }
                        return "Разрешен";
                    },
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]
    ); ?>

    <?php Pjax::end(); ?>

</div>
