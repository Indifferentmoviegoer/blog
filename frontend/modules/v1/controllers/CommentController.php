<?php

namespace frontend\modules\v1\controllers;

use common\models\Comment;
use common\models\User;
use common\repositories\CommentRepository;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

/**
 * Class CommentController
 * @package frontend\modules\v1\controllers
 */
class CommentController extends CommonController
{
    /**
     * @OA\Post (
     *     path="/v1/comment/all",
     *     summary="Список комментариев",
     *     description="Список комментариев по id новости или изображения",
     *     tags={"Комментарии"},
     *     @OA\RequestBody(
     *          required=true,
     *          description="Передаваемые параметры",
     *          @OA\JsonContent(
     *              @OA\Property(property="news_id", type="string", example="9"),
     *              @OA\Property(property="picture_id", type="string", example="0"),
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
    public function actionAll(): array
    {
        $body = Yii::$app->request->post();
        $error = $this->getError($body);
        if ($error) {
            return $error;
        }

        return [
            'data' => $this->getComments($body),
        ];
    }

    /**
     * @OA\Post (
     *     path="/v1/comment/create",
     *     summary="Создание комментария",
     *     description="Создание комментария в блоке комментариев",
     *     tags={"Комментарии"},
     *     security={{"Bearer":{ }}},
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

        if (empty($token = Yii::$app->request->post()['Comment']['token'])
            || empty($id = Yii::$app->request->post()['Comment']['user_id'])) {
            return ['error' => 'Ничего не найдено!'];
        }

        $user = User::find()->where(['auth_key' => $token])->one();
        if ($user->id != $id) {
            return ['error' => 'Ничего не найдено!'];
        }

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
     * @return array
     */
    public function actionUpload(): array
    {
        $body = Yii::$app->request->post();
        $error = $this->getError($body);
        if ($error) {
            return $error;
        }

        $comments = array_slice($this->getComments($body), $body['length']);

        return [
            'data' => $comments,
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function verbs(): array
    {
        return [
            'create' => ['POST'],
            'all' => ['POST'],
            'upload' => ['POST'],
        ];
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'except' => ['upload', 'all'],
            'authMethods' => [
                HttpBasicAuth::class,
                HttpBearerAuth::class,
                QueryParamAuth::class,
            ],
        ];
        return $behaviors;
    }
}
