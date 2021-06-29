<?php

namespace common\repositories;

use common\models\Category;
use common\models\News;
use DateTime;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class NewsRepository
{

    /**
     * @param News $model
     *
     * @return false|string
     */
    public function categoryList(News $model)
    {
        $categories = $model->categories;
        $categoryRepository = new CategoryRepository();

        if (empty($categories)) {
            return 'Новость без категории';
        }

        $categoryItems = [];
        foreach ($categories as $category) {
            $categoryItems[] = $category->category_id;
        }

        $index = 0;
        foreach ($categories as $category) {
            if ($category->category->parent_id != 0 && !in_array($category->category->parent_id, $categoryItems)) {
                $parents = $categoryRepository->getAllParents($category->category->parent_id);
                foreach ($parents as $parent) {
                    array_splice(
                        $categoryItems,
                        $index + $index,
                        0,
                        $parent->id
                    );
                }
                $index++;
            }
        }

        $categories = '';
        for ($i = 0; $i < count($categoryItems); $i++) {
            $category = Category::findOne(['id' => $categoryItems[$i]]);
            $categories .= $category->name . ' - ';
        }

        return substr($categories, 0, -3);
    }

    /**
     * @param News $model
     *
     * @return string
     */
    public function getShortText(News $model): string
    {
        $text = strip_tags($model->text);
        $lengthText = mb_strlen($text);
        $text = mb_substr($text, 0, 220);
        $prob = mb_strripos($text, ' ');
        $text = mb_substr($text, 0, $prob);

        if ($lengthText >= 220) {
            $text = $text . '...';
        }

        return $text;
    }

    /**
     * @return ActiveQuery
     */
    public function getNews(): ActiveQuery
    {
        return News::find()
            ->where('published_at<=NOW()')
            ->orderBy(['published_at' => SORT_DESC]);
    }

    /**
     * @param $ids
     *
     * @return ActiveQuery
     */
    public function getCategoryNews($ids): ActiveQuery
    {
        return News::find()
            ->where('published_at<=NOW()')
            ->andWhere(['in', 'id', $ids])
            ->orderBy(['published_at' => SORT_DESC]);
    }

    /**
     * @return ActiveQuery
     */
    public function getWeekNews(): ActiveQuery
    {
        $weekAgo = (new DateTime())->modify('-7 days');
        $searchWeek = $weekAgo->format('Y-m-d');

        return News::find()
            ->where('published_at<=NOW()')
            ->andWhere(['>=', 'published_at', $searchWeek])
            ->orderBy(['published_at' => SORT_DESC]);
    }

    /**
     * @return array
     */
    public static function getList(): array
    {
        return ArrayHelper::map(News::find()->all(), 'id', 'name');
    }
}