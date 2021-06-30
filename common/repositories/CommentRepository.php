<?php

namespace common\repositories;

use common\models\Comment;
use Yii;

/**
 * Class CommentRepository
 * @package common\repositories
 */
class CommentRepository
{
    /**
     * @param $id
     *
     * @return array
     */
    public function getNewsComments($id): array
    {
        return Comment::find()
            ->where(['news_id' => $id])
            ->andWhere(['moderation' => true])
            ->orderBy('created_at desc')
            ->all();
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function getGalleryComments($id): array
    {
        return Comment::find()
            ->where(['picture_id' => $id])
            ->andWhere(['moderation' => true])
            ->orderBy('created_at desc')
            ->all();
    }

    /**
     * @return bool|int|string|null
     */
    public function checkModeration()
    {
        return Comment::find()
            ->where(['user_id' => Yii::$app->user->identity->getId()])
            ->andWhere(['moderation' => true])
            ->count();
    }
}