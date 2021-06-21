<?php

namespace frontend\controllers;

use common\models\Comment;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class CommentController
 * @package frontend\controllers
 */
class CommentController extends Controller
{
    public function actionCreate()
    {
        $request = Yii::$app->request;

        if (!$request->isPost) {
            throw new BadRequestHttpException();
        }

        $model = new Comment();

        $user = Comment::find()
            ->where(['user_id' => Yii::$app->user->identity->getId()])
            ->andWhere(['moderation'=> true])
            ->count();

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->identity->getId();
            if($user>=5){
                $model->moderation = true;
            }
            $model->save();
        }
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionUpload(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;

        if (!$request->isPost) {
            throw new BadRequestHttpException();
        }

        if (isset(Yii::$app->request->post()['news_id'])) {
            $comments = Comment::find()
                ->where(['news_id' => Yii::$app->request->post()['news_id']])
                ->andWhere(['moderation' => true])
                ->orderBy('created_at desc')
                ->all();
        }

        foreach ($comments as $comment){
            $comment->user_id = $comment->user->username;
        }

        $comments = array_slice($comments, 5);

        return [
            "data" => $comments
        ];
    }
}