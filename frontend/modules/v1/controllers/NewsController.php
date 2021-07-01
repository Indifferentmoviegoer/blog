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
        return News::find()->all();
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function actionCategory($id): array
    {
        $catIds = NewsCategories::find()->where(['category_id' => $id])->all();
        $ids = $this->arrayListNews($catIds);
        $newsRepository = new NewsRepository();

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