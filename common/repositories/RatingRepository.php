<?php

namespace common\repositories;

use common\models\Rating;
use Yii;
use yii\db\ActiveRecord;

/**
 * Class RatingRepository
 * @package common\repositories
 */
class RatingRepository
{
    /**
     * @param $id
     *
     * @return array|ActiveRecord|null
     */
    public function oldRating($id)
    {
        return Rating::find()
            ->where(['ip' => Yii::$app->request->userIP])
            ->andWhere(['picture_id' => $id])
            ->one();
    }

    /**
     * @param $id
     *
     * @return bool|int|mixed|string|null
     */
    public function avgRating($id)
    {
        return Rating::find()
            ->where(['picture_id' => $id])
            ->average('value');
    }
}