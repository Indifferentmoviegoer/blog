<?php

namespace app\modules\v1\controllers;

use app\models\Comment;
use Yii;
use yii\base\BaseObject;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\web\Response;

/**
 * Class CommentController
 * @package app\modules\v1\controllers
 */
class CommentController extends Controller
{
    /**
     * @return array
     */
    public function actionGetNickname(): array
    {
        $comment = new Comment();
        $comment->generateNickname();
        $nickname = str_replace(["\r\n"],'',$comment->guest_nickname);

        $session = Yii::$app->session;
        $session->set('nickname', $nickname);

        return ['nickname' => $nickname];

    }

    /**
     * @return string[]
     */
    public function getOptionalAuthActions(): array
    {
        return [
            'get-nickname',
        ];
    }

    /**
     * @return string[][]
     */
    protected function verbs(): array
    {
        return [
            "get-nickname" => ["GET"]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
            ],
        ];
    }
}
