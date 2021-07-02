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
     * @param $id
     * @param int $page
     *
     * @return array|string[]
     */
    public function actionCategory($id, int $page = 1): array
    {
        if ($page == 0) {
            return ['error' => 'Ничего не найдено!'];
        }

        $catIds = NewsCategories::find()->where(['category_id' => $id])->all();
        $ids = $this->arrayListNews($catIds);
        $newsRepository = new NewsRepository();

        $allNews = $newsRepository->getCategoryNews($ids)->all();

        $news = array_slice($allNews, ($page - 1) * 5, 5);
        for ($i = 1; !empty(array_slice($allNews, ($i - 1) * 5, 5)); $i++) {
            $pages = $i;
        }

        foreach ($news as $item) {
            $item->picture_id = $item->picture->name;
            $item->text = $newsRepository->categoryList($item);
            $item->forbidden = $id;
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
        ];
    }
}