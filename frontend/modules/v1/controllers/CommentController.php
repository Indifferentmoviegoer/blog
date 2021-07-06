<?php

namespace frontend\modules\v1\controllers;

use common\models\Comment;
use common\repositories\CommentRepository;
use Yii;

/**
 * Class CommentController
 * @package frontend\modules\v1\controllers
 */
class CommentController extends CommonController
{
    /**
     * @OA\Post (
     *     path="/v1/comment/create",
     *     summary="Создание комментария",
     *     description="Создание комментария в блоке комментариев",
     *     tags={"Комментарии"},
     *     @OA\RequestBody(
     *          required=true,
     *          description="Передаваемые параметры",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="Comment",
     *                  ref="#/components/schemas/Comment"
     *              ),
     *          ),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="ОК",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/CommentArray"
     *              ),
     *          ),
     *     ),
     * )
     *
     * @return array
     *
     */
    public function actionCreate(): array
    {
        $commentRepository = new CommentRepository();
        $model = new Comment();

        if ($model->load(Yii::$app->request->post())) {
            $model->moderation = $commentRepository->checkModeration($model->user_id);
            $model->save();
        }

        $user = $model->user_id;
        $model->user_id = $model->user->username;
        $model->created_at = date("Y-m-d H:i:s");

        return [
            'data' => $model,
            'moderation' => $commentRepository->checkModeration($user),
        ];
    }

    /**
     * @OA\Post (
     *     path="/v1/comment/upload",
     *     summary="Подгрузка комментариев",
     *     description="Подгрузка комментариев в блоке комментариев",
     *     tags={"Комментарии"},
     *     @OA\RequestBody(
     *          required=true,
     *          description="Передаваемые параметры",
     *          @OA\JsonContent(
     *              @OA\Property(property="news_id", type="string", example="1"),
     *              @OA\Property(property="picture_id", type="string", example="0"),
     *              @OA\Property(property="length", type="string", example="20"),
     *          ),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="ОК",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/CommentArray"
     *              ),
     *          ),
     *     ),
     * )
     *
     * @return array
     *
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
