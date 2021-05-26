<?php

namespace console\controllers;

use Yii;
use yii\base\Exception;
use yii\console\Controller;
use common\models\User;

/**
 * Class RbacController
 * @package console\controllers
 */
class RbacController extends Controller
{
    public $auth;
    public $userRole;
    public $adminRole;
    public $redactorRole;

    /**
     * @throws Exception
     */
    public function actionInit()
    {
        $this->auth = Yii::$app->authManager;

        $this->createPermission('signAdmin');
        $this->createPermission('signRedactor');

        $this->userRole = $this->auth->createRole('user');
        $this->auth->add($this->userRole);
        $this->adminRole = $this->auth->createRole('admin');
        $this->auth->add($this->adminRole);
        $this->redactorRole = $this->auth->createRole('redactor');
        $this->auth->add($this->redactorRole);

        $this->addPermission('signAdmin', $this->adminRole);
        $this->addPermission('signRedactor', $this->redactorRole);
        $this->createData();
    }

    /**
     * @param string $namePermission
     */
    public function createPermission(string $namePermission)
    {
        $viewComplaintsListPermission = $this->auth->createPermission($namePermission);
        $this->auth->add($viewComplaintsListPermission);
    }

    /**
     * @param string $namePermission
     * @param $role
     */
    public function addPermission(string $namePermission, $role)
    {
        $permission = $this->auth->getPermission($namePermission);
        $this->auth->addChild($role, $permission);
    }

    /**
     * @throws Exception
     */
    public function createData()
    {
        $passwordHash = Yii::$app->security->generatePasswordHash('adios12');

        $admin = new User(
            [
                'username' => 'admin',
                'email' => 'admin@admin.com',
                'status' => 10,
                'password_hash' => $passwordHash
            ]
        );
        $this->createUserWithRole($admin, $this->adminRole);

        $user = new User(
            [
                'username' => 'user',
                'email' => 'user@user.com',
                'status' => 10,
                'password_hash' => $passwordHash
            ]
        );
        $this->createUserWithRole($user, $this->userRole);

        $user = new User(
            [
                'username' => 'redactor',
                'email' => 'redactor@redactor.com',
                'status' => 10,
                'password_hash' => $passwordHash
            ]
        );
        $this->createUserWithRole($user, $this->userRole);
    }

    /**
     * @param User $user
     * @param $role
     *
     * @throws Exception
     */
    public function createUserWithRole(User $user, $role)
    {
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->generatePasswordResetToken();
        $user->save();

        $this->auth->assign($role, $user->getId());
    }

    public function actionDelete()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        User::deleteAll();
    }
}
