<?php

namespace backend\controllers;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class BaseController
 * @package backend\controllers
 */
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
                'pagination' => [
                    'pageSize' => 20,
                ],
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
}