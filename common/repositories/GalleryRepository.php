<?php

namespace common\repositories;

use common\models\Gallery;
use Yii;
use yii\db\ActiveQuery;

class GalleryRepository
{
    /**
     * @return array
     */
    public function mostPopularMonth(): array
    {
        $start = date("Y-m-01 H:i:s", strtotime("-1 month"));
        $end = date("Y-m-t H:i:s", strtotime("-1 month"));

        return Gallery::find()
            ->where(['moderation' => true])
            ->andWhere(['between', 'created_at', $start, $end])
            ->orderBy(['rating' => SORT_DESC])
            ->limit(5)
            ->all();
    }

    /**
     * @return array
     */
    public function mostPopular(): array
    {
        return Gallery::find()
            ->where(['moderation' => true])
            ->orderBy(['rating' => SORT_DESC])
            ->limit(5)
            ->all();
    }


    /**
     * @return ActiveQuery
     */
    public function lastPictures(): ActiveQuery
    {
        return Gallery::find()
            ->where(['moderation' => true])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(20);
    }

    /**
     * @return bool
     */
    public function checkModeration(): bool
    {
        $user = Gallery::find()
            ->where(['user_id' => Yii::$app->user->identity->getId()])
            ->andWhere(['moderation' => true])
            ->count();

        if($user >= 5){
            return true;
        }

        return false;
    }
}