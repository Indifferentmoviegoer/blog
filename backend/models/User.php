<?php

namespace backend\models;

/**
 * Class User
 * @package backend\models
 */
class User extends \common\models\User
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return parent::tableName();
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return parent::rules();
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'email' => 'E-mail',
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'status' => 'Статус',
            'roles' => 'Роль',
            'role_user' => 'Роль',
        ];
    }
}