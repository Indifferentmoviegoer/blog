<?php

namespace frontend\controllers;

use common\models\NewsCategories;
use common\repositories\CategoryRepository;
use common\repositories\NewsRepository;
use common\models\Category;
use common\models\News;
use Exception;
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
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
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
    public function actions(): array
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
     * @return string
     */
    public function actionIndex(): string
    {
        $categories = Category::find()->all();
        $newsRepository = new NewsRepository();

        $allNews = $newsRepository->getWeekNews();
        $pages = new Pagination(['totalCount' => $allNews->count(), 'pageSize' => 20]);
        $news = $allNews->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render(
            'index',
            [
                'news' => $news,
                'pages' => $pages,
                'categories' => $categories,
                'newsRepository' => $newsRepository
            ]
        );
    }

    /**
     * @param $id
     *
     * @return string
     */
    public function actionCategory($id): string
    {
        $catIds = NewsCategories::find()->where(['category_id' => $id])->all();
        $ids = $this->arrayListNews($catIds);

        $categoryRepository = new CategoryRepository();
        $newsRepository = new NewsRepository();

        $menu = $categoryRepository::viewMenuItems();

        $allNews = $newsRepository->getCategoryNews($ids);
        $pages = new Pagination(['totalCount' => $allNews->count(), 'pageSize' => 20]);
        $news = $allNews->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('news', ['news' => $news, 'pages' => $pages, 'menu' => $menu, 'newsRepository' => $newsRepository]);
    }

    /**
     * @param $items
     *
     * @return array|string[]
     */
    public function arrayListNews($items): array
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

        if (Yii::$app->user->isGuest && $news->forbidden == 1) {
            throw new ForbiddenHttpException();
        }

        $news->count_views = $news->count_views + 1;
        $news->save();

        return $this->render('detail', ['news' => $news]);
    }

    /**
     * @return string
     */
    public function actionNews(): string
    {
        $newsRepository = new NewsRepository();
        $allNews = $newsRepository->getNews();
        $categoryRepository = new CategoryRepository();
        $menu = $categoryRepository::viewMenuItems();

        $pages = new Pagination(['totalCount' => $allNews->count(), 'pageSize' => 20]);
        $news = $allNews->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render(
            'news',
            ['news' => $news, 'pages' => $pages, 'newsRepository' => $newsRepository, 'menu' => $menu]
        );
    }

    /**
     * Logs in a user.
     *
     * @return string|Response
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
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail($model->email)) {
                Yii::$app->session->setFlash(
                    'success',
                    'Спасибо, что связались с нами. Мы ответим вам как можно скорее.'
                );
            } else {
                Yii::$app->session->setFlash('error', 'Произошла ошибка при отправке вашего сообщения.');
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
     * @return string
     */
    public function actionAbout(): string
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return Response|string
     * @throws Exception
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash(
                'success',
                'Спасибо за регистрацию. Пожалуйста, проверьте свой почтовый ящик на наличие электронной почты.'
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
     * @return Response|string
     * @throws \yii\base\Exception
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте свою электронную почту для получения дальнейших инструкций.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash(
                    'error',
                    'К сожалению, мы не можем сбросить пароль для указанного адреса электронной почты.'
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
     * @return Response|string
     * @throws BadRequestHttpException
     * @throws \yii\base\Exception
     */
    public function actionResetPassword(string $token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Сохранен новый пароль.');

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
     * @return Response
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail(string $token): Response
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Ваша электронная почта подтверждена!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'К сожалению, мы не можем подтвердить вашу учетную запись с помощью предоставленного токена.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return Response|string
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте свою электронную почту для получения дальнейших инструкций.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash(
                'error',
                'К сожалению, мы не можем повторно отправить письмо с подтверждением на указанный адрес электронной почты.'
            );
        }

        return $this->render(
            'resendVerificationEmail',
            [
                'model' => $model
            ]
        );
    }
}
