<?php

namespace common\widgets;

use yii\base\Widget;
use common\models\Comment;

/**
 * Class CommentWidget
 * @package common\widgets
 */
class CommentWidget extends Widget
{
    public int $id;
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
        $comments = Comment::find()
            ->where(['news_id'=>$this->id])
            ->andWhere(['moderation'=> true])
            ->orderBy('created_at desc')
            ->limit(5)
            ->all();

        $model = new Comment();

        return $this->render('comments', ['comments' => $comments, 'model' => $model, 'id' => $this->id]);
    }
}
