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
    /**
     * @return Comment[]
     * @throws BadRequestHttpException
     */
    public function actionCreate(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;

        if (!$request->isPost) {
            throw new BadRequestHttpException();
        }

        $model = new Comment();

        $user = Comment::find()
            ->where(['user_id' => Yii::$app->user->identity->getId()])
            ->andWhere(['moderation' => true])
            ->count();

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->identity->getId();
            if ($user >= 5) {
                $model->moderation = true;
            }
            $model->save();
        }

        $model->user_id = $model->user->username;
        $model->created_at = date("Y-m-d") . " " . date("H:i:s");

        return [
            "data" => $model
        ];
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionUpload(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;

        if (!$request->isPost || !isset(Yii::$app->request->post()['length'])) {
            throw new BadRequestHttpException();
        }

        $pictureID = Yii::$app->request->post()['picture_id'];
        $newsID = Yii::$app->request->post()['news_id'];

        $length = Yii::$app->request->post()['length'];
        if (!empty($newsID)) {
            $comments = Comment::find()
                ->where(['news_id' => $newsID])
                ->andWhere(['moderation' => true])
                ->orderBy('created_at desc')
                ->all();
        } elseif (!empty($pictureID)) {
            $comments = Comment::find()
                ->where(['picture_id' => $pictureID])
                ->andWhere(['moderation' => true])
                ->orderBy('created_at desc')
                ->all();
        }


        foreach ($comments as $comment) {
            $comment->user_id = $comment->user->username;
        }

        $comments = array_slice($comments, $length);

        return [
            "data" => $comments
        ];
    }
}