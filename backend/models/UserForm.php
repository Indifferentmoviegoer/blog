<?php

namespace backend\models;

use Exception;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * User form
 */
class UserForm extends Model
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $status;
    public $roles;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            [['roles', 'status', 'id'], 'safe'],
        ];
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
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     * @throws Exception
     */
    public function signup(): ?bool
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->status = $this->status;
        $user->roles = $this->roles;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->save();
        $this->id = $user->id;

        return $this->sendEmail($user);
    }

    /**
     * @param $id
     *
     * @return bool
     * @throws \yii\base\Exception
     */
    public function update($id): bool
    {

        $user = User::findOne([$id]);
        $user->username = $this->username;
        $user->email = $this->email;
        $user->status = $this->status;
        $user->roles = $this->roles;

        if(!empty($this->password)){
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
        }

        if($user->save()){
            return true;
        }

        return false;
    }


    /**
     * Sends confirmation email to user
     *
     * @param User $user user model to with email should be send
     *
     * @return bool whether the email was sent
     */
    protected function sendEmail(User $user): bool
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
