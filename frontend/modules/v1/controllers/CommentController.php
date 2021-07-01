<?php

namespace frontend\modules\v1\controllers;

use common\models\Comment;
use common\repositories\CommentRepository;
use frontend\modules\v1\traits\ControllerTrait;
use Yii;
use yii\rest\Controller;


/**
 * Class CommentController
 * @package frontend\modules\v1\controllers
 */
class CommentController extends Controller
{
    use ControllerTrait;

    /**
     * @return array
     */
    public function actionCreate(): array
    {
        $commentRepository = new CommentRepository();
        $model = new Comment();

        if ($model->load(Yii::$app->request->post())) {
            $model->moderation = $commentRepository->checkModeration();
            $model->save();
        }

        $model->user_id = $model->user->username;
        $model->created_at = date("Y-m-d H:i:s");

        return [
            'data' => $model,
            'moderation' => $commentRepository->checkModeration(),
        ];
    }

    /**
     * @return array
     */
    public function actionUpload(): array
    {
        $body = Yii::$app->request->post();
        $error = $this->getError($body);
        if($error){
            return $error;
        }

        $commentRepository = new CommentRepository();
        $comments = empty($body['picture_id'])
            ? $commentRepository->getNewsComments($body['news_id'])
            : $commentRepository->getGalleryComments($body['picture_id']);

        foreach ($comments as $comment) {
            $comment->user_id = $comment->user->username;
        }

        $comments = array_slice($comments, $body['length']);

        return [
            'data' => $comments
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function verbs(): array
    {
        return [
            'create' => ['POST'],
            'upload' => ['POST'],
        ];
    }
}
