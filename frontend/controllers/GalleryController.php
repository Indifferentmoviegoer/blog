<?php

namespace frontend\controllers;

use common\models\Rating;
use common\models\UploadGalleryForm;
use common\models\Gallery;
use common\models\GalleryCategory;
use common\repositories\GalleryRepository;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * Gallery controller
 */
class GalleryController extends Controller
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
        $categories = GalleryCategory::find()->all();

        return $this->render('index', ['categories' => $categories]);
    }

    /**
     * @param $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id): string
    {
        if (empty($id)) {
            throw new NotFoundHttpException('Страница не найдена.');
        }

        $model = new Gallery();
        $upload = new UploadGalleryForm();
        $galleryRepository = new GalleryRepository();

        if (Yii::$app->request->post()) {
            $upload->imageFile = UploadedFile::getInstance($upload, 'imageFile');

            if ($upload->upload()) {
                $model->name = $upload->imageFile->name;
                $model->category_id = $id;
                $model->user_id = Yii::$app->user->identity->getId();

                if ($galleryRepository->checkModeration()) {
                    $model->moderation = true;
                }

                if($model->save()){
                    if ($galleryRepository->checkModeration()){
                        Yii::$app->session->setFlash('success', 'Изображение успешно загружено!');
                    } else{
                        Yii::$app->session->setFlash('success', 'Изображение отправлено на пре-модерацию!');
                    }

                }
            }
        }

        $popularPictures = $galleryRepository->mostPopular();
        $lastPictures = $galleryRepository->lastPictures();

        return $this->render(
            'view',
            [
                'model' => $model,
                'upload' => $upload,
                'popularPictures' => $popularPictures,
                'lastPictures' => $lastPictures,
            ]
        );
    }

    /**
     * @param $id
     *
     * @return string
     * @throws NotFoundHttpException
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDetail($id): string
    {
        if (empty($id)) {
            throw new NotFoundHttpException('Страница не найдена.');
        }

        $picture = Gallery::find()->where(['id' => $id])->one();

        $model = new Rating();

        if ($model->load(Yii::$app->request->post())) {
            $oldRating = Rating::find()
                ->where(['ip' => Yii::$app->request->userIP])
                ->andWhere(['picture_id' => $id])
                ->one();

            if ($oldRating) {
                $oldRating->delete();
            }

            $model->ip = Yii::$app->request->userIP;
            $model->picture_id = $id;

            if ($model->save()) {
                $rating = Rating::find()->where(['picture_id' => $id])->average('value');
                $picture->rating = $rating;
                if ($picture->save()) {
                    Yii::$app->session->setFlash('success', 'Спасибо за оценку изображения!');
                }
            }
        }

        return $this->render(
            'detail',
            [
                'model' => $model,
                'picture' => $picture,
            ]
        );
    }

    /**
     * @throws BadRequestHttpException
     */
    public function actionDislike()
    {
        $request = Yii::$app->request;

        if (!$request->isPost || !isset(Yii::$app->request->post()['picture_id'])) {
            throw new BadRequestHttpException();
        }

        $pictureID = Yii::$app->request->post()['picture_id'];

        $rating = Rating::find()
            ->where(['picture_id' => $pictureID])
            ->andWhere(['user_id' => Yii::$app->user->identity->getId()])
            ->one();

        $picture = Gallery::findOne($pictureID);

        if (!$rating) {
            $rating = new Rating();
            $rating->picture_id = $pictureID;
            $rating->value = -1;
            $rating->user_id = Yii::$app->user->identity->getId();
            $rating->save();

            if ($rating->value == -1) {
                $picture->rating = $picture->rating - 1;
                $picture->save();
            }
        } else {
            if ($rating->value != -1) {
                $rating->value = $rating->value - 1;
                $rating->save();

                $picture->rating = $picture->rating - 1;
                $picture->save();
            }
        }
    }

    /**
     * @throws BadRequestHttpException
     */
    public function actionLike()
    {
        $request = Yii::$app->request;

        if (!$request->isPost || !isset(Yii::$app->request->post()['picture_id'])) {
            throw new BadRequestHttpException();
        }

        $pictureID = Yii::$app->request->post()['picture_id'];

        $rating = Rating::find()
            ->where(['picture_id' => $pictureID])
            ->andWhere(['user_id' => Yii::$app->user->identity->getId()])
            ->one();

        $picture = Gallery::findOne($pictureID);

        if (!$rating) {
            $rating = new Rating();
            $rating->picture_id = $pictureID;
            $rating->value = 1;
            $rating->user_id = Yii::$app->user->identity->getId();
            $rating->save();

            if ($rating->value == 1) {
                $picture->rating = $picture->rating + 1;
                $picture->save();
            }
        } else {
            if ($rating->value != 1) {
                $rating->value = $rating->value + 1;
                $rating->save();

                $picture->rating = $picture->rating + 1;
                $picture->save();
            }
        }
    }

}
