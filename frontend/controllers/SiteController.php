<?php

namespace frontend\controllers;

use common\models\NewsCategories;
use DateTime;
use common\models\Category;
use common\models\News;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\data\Pagination;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $weekAgo = (new DateTime())->modify('-7 days');
        $searchWeek = $weekAgo->format('Y-m-d');
        $categories = Category::find()->all();

        $allNews = News::find()
            ->where('published_at<=NOW()')
            ->andWhere(['>=', 'published_at', $searchWeek])
            ->orderBy(['published_at' => SORT_DESC]);
        $pages = new Pagination(['totalCount' => $allNews->count(), 'pageSize' => 20]);
        $news = $allNews->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', ['news' => $news, 'pages' => $pages, 'categories' => $categories]);
    }

    public function actionCategory($id)
    {
        $weekAgo = (new DateTime())->modify('-7 days');
        $searchWeek = $weekAgo->format('Y-m-d');

        $catIds = NewsCategories::find()->where(['category_id' => $id])->all();
        $ids = $this->arrayListProduct($catIds);

        $allNews = News::find()
            ->where('published_at<=NOW()')
            ->andWhere(['>=', 'published_at', $searchWeek])
            ->andWhere(['in', 'id', $ids])
            ->orderBy(['published_at' => SORT_DESC]);
        $pages = new Pagination(['totalCount' => $allNews->count(), 'pageSize' => 20]);
        $news = $allNews->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', ['news' => $news, 'pages' => $pages]);
    }

    public function arrayListProduct($items): array
    {
        if (!empty($items)) {
            foreach ($items as $item) {
                $arrayList[] = $item->news_id;
            }
            return $arrayList;
        } else {
            return ['message' => 'Ничего не найдено!'];
        }
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDetail(int $id): string
    {
        $news = News::findOne($id);

        if (empty($news)) {
            throw new NotFoundHttpException('Страница не найдена.');
        }

        return $this->render('detail', ['news' => $news]);
    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render(
                'login',
                [
                    'model' => $model,
                ]
            );
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail($model->email)) {
                Yii::$app->session->setFlash(
                    'success',
                    'Thank you for contacting us. We will respond to you as soon as possible.'
                );
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render(
                'contact',
                [
                    'model' => $model,
                ]
            );
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash(
                'success',
                'Thank you for registration. Please check your inbox for verification email.'
            );
            return $this->goHome();
        }

        return $this->render(
            'signup',
            [
                'model' => $model,
            ]
        );
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash(
                    'error',
                    'Sorry, we are unable to reset password for the provided email address.'
                );
            }
        }

        return $this->render(
            'requestPasswordResetToken',
            [
                'model' => $model,
            ]
        );
    }

    /**
     * Resets password.
     *
     * @param string $token
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render(
            'resetPassword',
            [
                'model' => $model,
            ]
        );
    }

    /**
     * Verify email address
     *
     * @param string $token
     *
     * @return yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash(
                'error',
                'Sorry, we are unable to resend verification email for the provided email address.'
            );
        }

        return $this->render(
            'resendVerificationEmail',
            [
                'model' => $model
            ]
        );
    }

    public function actionNews()
    {
        $allNews = News::find()
            ->where('published_at<=NOW()')
            ->orderBy(['published_at' => SORT_DESC]);
        $pages = new Pagination(['totalCount' => $allNews->count(), 'pageSize' => 20]);
        $news = $allNews->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('news', ['news' => $news, 'pages' => $pages]);
    }
}
