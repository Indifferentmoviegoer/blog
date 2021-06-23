<?php

use yii\web\View;
use yii\grid\GridView;
use yii\helpers\Url;

/**
 * @var View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Настройки';
?>

<?php
echo GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            'id',
            [
                'attribute' => 'label',
                'label' => 'Наименование',
                'format' => 'text',
                'value' => function ($data) {
                    return Yii::$app->settings->get($data['name'])->label;
                }
            ],
            [
                'attribute' => 'value',
                'label' => 'Значение',
                'format' => 'text',
                'value' => function ($data) {
                    return Yii::$app->settings->get($data['name'])->value;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'urlCreator' => function ($action, $model) {
                    return Url::to(['setting/'.$action, 'name' => $model['name']]);
                },
            ]
        ]
    ]
); ?>