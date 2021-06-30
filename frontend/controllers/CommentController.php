<?php

namespace frontend\controllers;

use common\models\Comment;
use common\repositories\CommentRepository;
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
        $commentRepository = new CommentRepository();
        $model = new Comment();

        if (!$request->isPost) {
            throw new BadRequestHttpException();
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->identity->getId();
            $model->moderation = $commentRepository->checkModeration();
            $model->save();
        }

        $model->user_id = $model->user->username;
        $model->created_at = date("Y-m-d H:i:s");

        return [
            "data" => $model,
            "moderation" => $commentRepository->checkModeration(),
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
        $commentRepository = new CommentRepository();

        if (!$request->isPost || !isset(Yii::$app->request->post()['length'])) {
            throw new BadRequestHttpException();
        }

        $pictureID = empty(Yii::$app->request->post()['picture_id']) ? null : Yii::$app->request->post()['picture_id'];
        $newsID = empty(Yii::$app->request->post()['news_id']) ? null : Yii::$app->request->post()['news_id'];

        $length = Yii::$app->request->post()['length'];
        if (!empty($newsID)) {
            $comments = $commentRepository->getNewsComments($newsID);
        } elseif (!empty($pictureID)) {
            $comments = $commentRepository->getGalleryComments($pictureID);
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