<?php

namespace common\widgets;

use common\models\Gallery;
use yii\base\Widget;

/**
 * Class SliderWidget
 * @package common\widgets
 */
class SliderWidget extends Widget
{

    /**
     *{@inheritDoc}
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return string
     */
    public function run(): string
    {
        $start = date("Y-m-01 H:i:s", strtotime("-1 month"));
        $end = date("Y-m-t H:i:s", strtotime("-1 month"));
        $max = Gallery::find()->where(['between', 'created_at', $start, $end])->max('rating');

        $slider = Gallery::find()
            ->where(['rating' => $max])
            ->andWhere(['between', 'created_at', $start, $end])
            ->limit(5)
            ->all();

        return $this->render('slider', ['slider' => $slider]);
    }
}
