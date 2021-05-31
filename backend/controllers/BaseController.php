<?php

namespace backend\controllers;

use backend\models\NewsCategories;
use Throwable;
use Yii;
use yii\base\Model;
use yii\db\StaleObjectException;
use yii\web\Controller;

class BaseController extends Controller
{
    /**
     * @param Model $model
     *
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function loadCategoryList(Model $model)
    {
        if (Yii::$app->request->post()['News']['rel']) {
            $rel = Yii::$app->request->post()['News']['rel'];

            $this->deleteCategoryList($model);

            for ($i = 0; $i < count($rel); $i++) {
                $categoryProducts = new NewsCategories();
                $categoryProducts->category_id = $rel[$i];
                $categoryProducts->news_id = $model->id;
                $categoryProducts->save();
            }
        }
    }

    /**
     * @param Model $model
     */
    public function deleteCategoryList(Model $model)
    {
        $news = $model->categories;

        if (!empty($news)) {
            foreach ($news as $item) {
                $item->delete();
            }
        }
    }

    /**
     * @param Model $model
     */
    public function setCategoryList(Model $model)
    {
        $categories = $model->categories;

        if (!empty($categories)) {
            foreach ($categories as $category) {
                $categoryItems[] = $category->category_id;
            }

            foreach ($categories as $category) {
                if ($category->category->parent_id != 0 && !in_array($category->category->parent_id, $categoryItems)) {
                    $parents = $category->category->getAllParents($category->category->parent_id);
                    foreach ($parents as $parent) {
                        $categoryItems[] = $parent->id;
                    }
                }
            }

            $model->rel = $categoryItems;
        }
    }
}