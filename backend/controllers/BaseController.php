<?php

namespace backend\controllers;

use common\models\NewsCategories;
use common\repositories\CategoryRepository;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BaseController extends Controller
{
    /**
     * @param Query $query
     *
     * @return ActiveDataProvider
     */
    public function createDataProvider(Query $query): ActiveDataProvider
    {
        return new ActiveDataProvider(
            [
                'query' => $query,
            ]
        );
    }

    /**
     * @param Model|string $value
     *
     * @throws NotFoundHttpException
     */
    public function checkEmpty($value)
    {
        if (empty($value)) {
            throw new NotFoundHttpException('Страница не найдена.');
        }
    }

    /**
     * @param Model $model
     */
    public function loadCategoryList(Model $model)
    {
        if (!empty(Yii::$app->request->post()['News']['rel'])) {
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
        $categoryRepository = new CategoryRepository();

        if (!empty($categories)) {
            foreach ($categories as $category) {
                $categoryItems[] = $category->category_id;
            }

            foreach ($categories as $category) {
                if ($category->category->parent_id != 0 && !in_array($category->category->parent_id, $categoryItems)) {
                    $parents = $categoryRepository->getAllParents($category->category->parent_id);
                    foreach ($parents as $parent) {
                        $categoryItems[] = $parent->id;
                    }
                }
            }

            $model->rel = $categoryItems;
        }
    }
}