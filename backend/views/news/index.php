<?php

use backend\models\Category;
use backend\models\NewsCategories;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'News';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create News', ['create'], ['class' => 'btn btn-success']) ?>
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
                        $categories = NewsCategories::find()->where(['news_id' => $data->id])->all();

                        if (empty($categories)) {
                            return 'Новость без категории';
                        }

                        $categoryItems = [];
                        foreach ($categories as $category) {
                            $categoryItems[] = $category->category->id;
                        }

                        $index = 0;
                        foreach ($categories as $category) {
                            if ($category->category->parent_id != 0) {
                                if (!in_array($category->category->parent_id, $categoryItems)) {
                                    array_splice(
                                        $categoryItems,
                                        $index + $index,
                                        0,
                                        $category->category->parent_id
                                    );
                                }
                            }
                            $index++;
                        }

                        for ($i = 0; $i < count($categoryItems); $i++) {
                            $category = Category::findOne(['id' => $categoryItems[$i]]);
                            $categoryItems[$i] = $category->name;
                        }

                        $categories = '';
                        foreach ($categoryItems as $item) {
                            $categories .= $item . ' - ';
                        }

                        return substr($categories, 0, -3);
                    },
                ],
                [
                    'attribute' => 'picture_id',
                    'value' => function ($data) {
                        $path = env('APP_URL') . "/img/uploads/";
                        return '<img src="' . $path . $data->picture->name . '" alt="">';
                    },
                    'format' => 'raw'
                ],
                'name',
                'desc',
                'text:html',
                'published_at',
                'forbidden',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]
    ); ?>

    <?php Pjax::end(); ?>

</div>
