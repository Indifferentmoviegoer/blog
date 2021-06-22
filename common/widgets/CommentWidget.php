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
    public int $type;

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
        if($this->type == 1){
            $comments = Comment::find()
                ->where(['news_id'=>$this->id])
                ->andWhere(['moderation'=> true])
                ->orderBy('created_at desc')
                ->limit(20)
                ->all();
        } elseif ($this->type == 2){
            $comments = Comment::find()
                ->where(['picture_id'=>$this->id])
                ->andWhere(['moderation'=> true])
                ->orderBy('created_at desc')
                ->limit(20)
                ->all();
        }

        $model = new Comment();

        return $this->render('comments', ['comments' => $comments, 'model' => $model, 'id' => $this->id, 'type' => $this->type]);
    }
}
