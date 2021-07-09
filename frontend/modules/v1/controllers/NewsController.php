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
     *     path="/v1/news/all",
     *     summary="Список новостей",
     *     description="Список всех новостей",
     *     tags={"Новости"},
     *     @OA\Response(
     *          response=200,
     *          description="ОК",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/NewsArray",
     *          ),
     *     ),
     * )
     *
     * @return array|string[]
     */
    public function actionAll(): array
    {
        $newsRepository = new NewsRepository();
        $news = $newsRepository->getAllNews();

        foreach ($news as $item) {
            $item->picture_id = $item->picture->name;
            $item->text = $newsRepository->categoryList($item);
        }

        return [
            'data' => $news,
        ];
    }

    /**
     * @OA\Get (
     *     path="/v1/news/category?id={id}",
     *     summary="Новости по категориям",
     *     description="Список новостей по категориям",
     *     tags={"Новости"},
     *     @OA\Parameter (
     *          description="id категории",
     *          in="path",
     *          name="id",
     *          example="1",
     *          required=true,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="ОК",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/NewsArray",
     *          ),
     *     ),
     * )
     *
     * @param int $id
     *
     * @return array|string[]
     */
    public function actionCategory(int $id): array
    {
        $newsRepository = new NewsRepository();
        $categories = NewsCategories::find()->where(['category_id' => $id])->all();
        $ids = $this->arrayListNews($categories);
        $news = $newsRepository->getCategoryNews($ids)->all();

        foreach ($news as $item) {
            $item->picture_id = $item->picture->name;
            $item->text = $newsRepository->categoryList($item);
        }

        return [
            'data' => $news,
        ];
    }

    /**
     * @OA\Get (
     *     path="/v1/news/paginate?id={id}&page={page}",
     *     summary="Новости постранично",
     *     description="Список новостей с пагинация",
     *     tags={"Новости"},
     *     @OA\Parameter (
     *          description="id категории",
     *          in="path",
     *          name="id",
     *          example="1",
     *          required=true,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Parameter (
     *          description="Номер страницы пагинации",
     *          in="path",
     *          name="page",
     *          example="1",
     *          required=true,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="ОК",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/NewsArray",
     *          ),
     *     ),
     * )
     *
     * @param int $id
     * @param int $page
     *
     * @return array|string[]
     */
    public function actionPaginate(int $id = 0, int $page = 1): array
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
            'all' => ['GET'],
            'paginate' => ['GET'],
            'category' => ['GET'],
        ];
    }
}