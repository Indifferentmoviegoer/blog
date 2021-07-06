<?php

namespace frontend\modules\v1\controllers;

use common\models\NewsCategories;
use common\repositories\NewsRepository;

/**
 * Class NewsController
 * @package frontend\modules\v1\controllers
 */
class NewsController extends CommonController
{
    /**
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
     *                  ref="#/components/schemas/NewsArray"
     *              ),
     *          ),
     *     ),
     * )
     *
     * @param int $page
     *
     * @return array|string[]
     *
     */
    public function actionAllPaginate(int $page = 1): array
    {
        if ($page == 0) {
            return ['error' => 'Ничего не найдено!'];
        }

        $newsRepository = new NewsRepository();
        $news = $newsRepository->getAllNews();

        $sliceNews = array_slice($news, ($page - 1) * 20, 20);
        for ($i = 1; !empty(array_slice($news, ($i - 1) * 20, 20)); $i++) {
            $pages = $i;
        }

        foreach ($sliceNews as $item) {
            $item->picture_id = $item->picture->name;
            $item->text = $newsRepository->categoryList($item);
            $item->count_views = $pages;
        }

        if (empty($sliceNews)) {
            return ['error' => 'Ничего не найдено!'];
        }

        return [
            'data' => $sliceNews,
        ];
    }

    /**
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
     *                  ref="#/components/schemas/NewsArray"
     *              ),
     *          ),
     *     ),
     * )
     *
     * @param int $id
     * @param int $page
     *
     * @return array|string[]
     */
    public function actionCategory(int $id = 0, int $page = 1): array
    {
        if ($page == 0) {
            return ['error' => 'Ничего не найдено!'];
        }

        $newsRepository = new NewsRepository();

        if ($id == 0) {
            $news = $newsRepository->getAllNews();
        } else {
            $categories = NewsCategories::find()->where(['category_id' => $id])->all();
            $ids = $this->arrayListNews($categories);
            $news = $newsRepository->getCategoryNews($ids)->all();
        }

        $sliceNews = array_slice($news, ($page - 1) * 20, 20);
        for ($i = 1; !empty(array_slice($news, ($i - 1) * 20, 20)); $i++) {
            $pages = $i;
        }

        foreach ($sliceNews as $item) {
            $item->picture_id = $item->picture->name;
            $item->text = $newsRepository->categoryList($item);
            if ($id != 0) {
                $item->forbidden = $id;
            }
            $item->count_views = $pages;
        }

        if (empty($sliceNews)) {
            return ['error' => 'Ничего не найдено!'];
        }

        return [
            'data' => $sliceNews,
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