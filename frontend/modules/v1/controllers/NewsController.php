<?php

namespace frontend\modules\v1\controllers;

use common\models\News;
use common\models\NewsCategories;
use common\repositories\NewsRepository;
use frontend\modules\v1\traits\ControllerTrait;
use yii\rest\Controller;

/**
 * Class NewsController
 * @package frontend\modules\v1\controllers
 */
class NewsController extends Controller
{
    use ControllerTrait;

    /**
     * @return array
     *
     * @OA\Get (
     *     path="/v1/news/get-all",
     *     summary="Подгрузка новостей",
     *     description="Подгрузка новостей на вкладке news",
     *     tags={"Новости"},
     *     @OA\Response(
     *          response=200,
     *          description="ОК",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="string", example="1"),
     *                      @OA\Property(property="picture_id", type="string", example="/img/uploads/picture.jpg"),
     *                      @OA\Property(property="name", type="string", example="Австралийскую мышь Гульда, которую считали вымершей в 19 веке"),
     *                      @OA\Property(property="desc", type="string", example="Оказалось, что мышь джунгари, живущая на острове в заливе Шарк Бэй"),
     *                      @OA\Property(property="text", type="string", example="Список категорий"),
     *                      @OA\Property(property="published_at", type="string", example="2021-06-30 14:00:53"),
     *                      @OA\Property(property="forbidden", type="string", example="0"),
     *                      @OA\Property(property="count_views", type="string", example="3"),
     *                  ),
     *              ),
     *          ),
     *     ),
     * )
     */
    public function actionGetAll(): array
    {
        $news = News::find()->orderBy(['published_at' => SORT_DESC])->all();
        $newsRepository = new NewsRepository();

        foreach ($news as $item) {
            $item->picture_id = $item->picture->name;
            $item->text = $newsRepository->categoryList($item);
        }

        return [
            'data' => $news,
        ];
    }

    /**
     * @param int $page
     *
     * @return array|string[]
     *
     * @OA\Get (
     *     path="/v1/news/all-paginate",
     *     summary="Подгрузка новостей постранично",
     *     description="Подгрузка новостей на вкладке news",
     *     tags={"Новости"},
     *     @OA\Parameter (
     *          description="id категории",
     *          in="path",
     *          name="id",
     *          example="1",
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Parameter (
     *          description="Номер страницы пагинации",
     *          in="path",
     *          name="page",
     *          example="1",
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="ОК",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="string", example="1"),
     *                      @OA\Property(property="picture_id", type="string", example="/img/uploads/picture.jpg"),
     *                      @OA\Property(property="name", type="string", example="Австралийскую мышь Гульда, которую считали вымершей в 19 веке"),
     *                      @OA\Property(property="desc", type="string", example="Оказалось, что мышь джунгари, живущая на острове в заливе Шарк Бэй"),
     *                      @OA\Property(property="text", type="string", example="Список категорий"),
     *                      @OA\Property(property="published_at", type="string", example="2021-06-30 14:00:53"),
     *                      @OA\Property(property="forbidden", type="string", example="0"),
     *                      @OA\Property(property="count_views", type="string", example="3"),
     *                  ),
     *              ),
     *          ),
     *     ),
     * )
     */
    public function actionAllPaginate(int $page = 1): array
    {
        if ($page == 0) {
            return ['error' => 'Ничего не найдено!'];
        }

        $allNews = News::find()->orderBy(['published_at' => SORT_DESC])->all();
        $newsRepository = new NewsRepository();

        $news = array_slice($allNews, ($page - 1) * 20, 20);
        for ($i = 1; !empty(array_slice($allNews, ($i - 1) * 20, 20)); $i++) {
            $pages = $i;
        }

        foreach ($news as $item) {
            $item->picture_id = $item->picture->name;
            $item->text = $newsRepository->categoryList($item);
            $item->count_views = $pages;
        }

        if (empty($news)) {
            return ['error' => 'Ничего не найдено!'];
        }

        return [
            'data' => $news,
        ];
    }

    /**
     * @param int $id
     * @param int $page
     *
     * @return array|string[]
     *
     * @OA\Get (
     *     path="/v1/news/category",
     *     summary="Подгрузка новостей постранично по категориям",
     *     description="Подгрузка новостей на вкладке news",
     *     tags={"Новости"},
     *     @OA\Parameter (
     *          description="id категории",
     *          in="path",
     *          name="id",
     *          example="1",
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Parameter (
     *          description="Номер страницы пагинации",
     *          in="path",
     *          name="page",
     *          example="1",
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="ОК",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="string", example="1"),
     *                      @OA\Property(property="picture_id", type="string", example="/img/uploads/picture.jpg"),
     *                      @OA\Property(property="name", type="string", example="Австралийскую мышь Гульда, которую считали вымершей в 19 веке"),
     *                      @OA\Property(property="desc", type="string", example="Оказалось, что мышь джунгари, живущая на острове в заливе Шарк Бэй"),
     *                      @OA\Property(property="text", type="string", example="Список категорий"),
     *                      @OA\Property(property="published_at", type="string", example="2021-06-30 14:00:53"),
     *                      @OA\Property(property="forbidden", type="string", example="0"),
     *                      @OA\Property(property="count_views", type="string", example="3"),
     *                  ),
     *              ),
     *          ),
     *     ),
     * )
     */
    public function actionCategory(int $id = 0, int $page = 1): array
    {
        if ($page == 0) {
            return ['error' => 'Ничего не найдено!'];
        }

        $newsRepository = new NewsRepository();

        if ($id == 0) {
            $allNews = News::find()->orderBy(['published_at' => SORT_DESC])->all();
        } else {
            $catIds = NewsCategories::find()->where(['category_id' => $id])->all();
            $ids = $this->arrayListNews($catIds);
            $allNews = $newsRepository->getCategoryNews($ids)->all();
        }

        $news = array_slice($allNews, ($page - 1) * 20, 20);
        for ($i = 1; !empty(array_slice($allNews, ($i - 1) * 20, 20)); $i++) {
            $pages = $i;
        }

        foreach ($news as $item) {
            $item->picture_id = $item->picture->name;
            $item->text = $newsRepository->categoryList($item);
            if ($id != 0) {
                $item->forbidden = $id;
            }
            $item->count_views = $pages;
        }

        if (empty($news)) {
            return ['error' => 'Ничего не найдено!'];
        }

        return [
            'data' => $news,
        ];
    }

    /**
     * @return string[][]
     */
    protected function verbs(): array
    {
        return [
            'get-all' => ['GET'],
            'category' => ['GET'],
            'all-paginate' => ['GET'],
        ];
    }
}