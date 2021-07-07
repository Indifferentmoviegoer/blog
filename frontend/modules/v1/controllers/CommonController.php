<?php

namespace frontend\modules\v1\controllers;

use common\repositories\CommentRepository;
use yii\rest\Controller;

/**
 * @OA\Info(title="Новостной блог", version="1"),
 *
 * @OA\Schema(
 *   schema="Comment",
 *   @OA\Property(property="news_id", type="string", example="9"),
 *   @OA\Property(property="picture_id", type="string", example="0"),
 *   @OA\Property(property="user_id", type="string", example="31"),
 *   @OA\Property(property="text", type="string", example="Hello"),
 * ),
 *
 * @OA\Schema(
 *     schema="CommentArray",
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(property="id", type="string", example="1"),
 *             @OA\Property(property="user_id", type="string", example="admin"),
 *             @OA\Property(property="text", type="string", example="Текст комментария"),
 *             @OA\Property(property="moderation", type="string", example="1"),
 *             @OA\Property(property="created_at", type="string", example="2021-06-22 11:20:03"),
 *             @OA\Property(property="news_id", type="string", example="9"),
 *         ),
 *     ),
 * ),
 *
 * @OA\Schema(
 *      schema="NewsArray",
 *      @OA\Property(
 *          property="data",
 *          type="array",
 *          @OA\Items(
 *              @OA\Property(property="id", type="string", example="1"),
 *              @OA\Property(property="picture_id", type="string", example="/img/uploads/picture.jpg"),
 *              @OA\Property(property="name", type="string", example="Австралийскую мышь Гульда, которую считали вымершей в 19 веке"),
 *              @OA\Property(property="desc", type="string", example="Оказалось, что мышь джунгари, живущая на острове в заливе Шарк Бэй"),
 *              @OA\Property(property="text", type="string", example="Список категорий"),
 *              @OA\Property(property="published_at", type="string", example="2021-06-30 14:00:53"),
 *              @OA\Property(property="forbidden", type="string", example="0"),
 *              @OA\Property(property="count_views", type="string", example="3"),
 *         ),
 *      ),
 * )
 *
 * Class CommonController
 * @package frontend\modules\v1\controllers
 */
class CommonController extends Controller
{
    /**
     * @param array $body
     *
     * @return false|string[]
     */
    public function getError(array $body)
    {
        if (empty($body['picture_id']) && empty($body['news_id'])) {
            return ['error' => 'Ошибка! Отсутствуют необходимые параметры'];
        }

        return false;
    }

    /**
     * @param $items
     *
     * @return array|string[]
     */
    public function arrayListNews($items): array
    {
        if (!empty($items)) {
            foreach ($items as $item) {
                $arrayList[] = $item->news_id;
            }
            return $arrayList;
        } else {
            return ['error' => 'Ничего не найдено!'];
        }
    }

    /**
     * @return string[]
     */
    public function getComments($body): array
    {
        $commentRepository = new CommentRepository();
        $comments = empty($body['picture_id'])
            ? $commentRepository->getNewsComments($body['news_id'])
            : $commentRepository->getGalleryComments($body['picture_id']);

        foreach ($comments as $comment) {
            $comment->user_id = $comment->user->username;
        }

        return $comments;
    }
}