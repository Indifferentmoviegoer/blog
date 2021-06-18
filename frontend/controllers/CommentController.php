<?php

namespace frontend\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Class CommentController
 * @package frontend\controllers
 */
class CommentController extends Controller
{
    public function actionCreate()
    {
        $request = Yii::$app->request;

        if (!$request->isPost) {
            throw new BadRequestHttpException();
        }

        return [
            'success' => true
        ];
    }
}