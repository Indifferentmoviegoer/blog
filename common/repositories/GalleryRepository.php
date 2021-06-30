<?php

namespace common\repositories;

use common\models\Gallery;
use DateTime;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

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
    public function mostPopularWeek(): array
    {
        $weekAgo = (new DateTime())->modify('-7 days');
        $searchWeek = $weekAgo->format('Y-m-d');

        return Gallery::find()
            ->where(['moderation' => true])
            ->andWhere('created_at<=NOW()')
            ->andWhere(['>=', 'created_at', $searchWeek])
            ->all();
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function mostPopular($id): array
    {
        return Gallery::find()
            ->where(['category_id' => $id])
            ->andWhere(['moderation' => true])
            ->orderBy(['rating' => SORT_DESC])
            ->limit(5)
            ->all();
    }

    /**
     * @param $id
     *
     * @return ActiveQuery
     */
    public function lastPictures($id): ActiveQuery
    {
        return Gallery::find()
            ->where(['category_id' => $id])
            ->andWhere(['moderation' => true])
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

    /**
     * @return array
     */
    public static function getList(): array
    {
        return ArrayHelper::map(Gallery::find()->all(), 'id', 'name');
    }
}