<?php

namespace common\widgets;

use Yii;
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
            ->all();

        $model = new Comment();

        $user = Comment::find()
            ->where(['user_id' => Yii::$app->user->identity->getId()])
            ->andWhere(['moderation'=> true])
            ->count();

        if ($model->load(Yii::$app->request->post())) {
            $model->news_id = $this->id;
            $model->user_id = Yii::$app->user->identity->getId();
            if($user>=5){
                $model->moderation = true;
            }
            if($model->save()){
                Yii::$app->session->setFlash('success', 'sdsdsd');
                return $this->render('comments', ['comments' => $comments, 'model' => $model]);
            } else {
                Yii::$app->session->setFlash('error', 'errore');
            }
        }

        return $this->render('comments', ['comments' => $comments, 'model' => $model]);
    }
}
