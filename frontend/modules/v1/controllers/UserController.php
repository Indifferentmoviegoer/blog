<?php

namespace frontend\modules\v1\controllers;

use common\models\User;
use Yii;
use yii\filters\auth\HttpBasicAuth;

/**
 * Class UserController
 * @package frontend\modules\v1\controllers
 */
class UserController extends CommonController
{

    /**
     * @OA\Get (
     *     path="/v1/user/auth",
     *     summary="Аутентификация пользователя",
     *     description="Аутентификация по логину и паролю и получение токена",
     *     tags={"Пользователи"},
     *     security={ {"basic": {} }},
     *     @OA\Response(
     *          response=200,
     *          description="ОК",
     *          @OA\JsonContent(
     *              @OA\Property(property="token", type="string", example="sdADZXaY_z36dfd2fsdfMOSzk49"),
     *          ),
     *     ),
     * )
     * @return array
     */
    public function actionAuth(): array
    {
        return [
            'token' => Yii::$app->user->identity->getAuthKey(),
        ];
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function ($username, $password) {
                if ($user = User::find()->where(['username' => $username])->one()
                    and $user->validatePassword($password)
                ) {
                    return $user;
                }
                return null;
            }
        ];
        return $behaviors;
    }
}