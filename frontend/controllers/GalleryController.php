<?php

namespace frontend\controllers;

use common\models\Comment;
use common\models\Picture;
use common\models\Rating;
use common\models\UploadGalleryForm;
use common\models\Gallery;
use common\models\GalleryCategory;
use Yii;
use yii\base\BaseObject;
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
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                'class' => VerbFilter::className(),
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
        $rating = new Rating();
        $pictures = Gallery::find()->where(['category_id' => $id])->all();
        $user = Gallery::find()
            ->where(['user_id' => Yii::$app->user->identity->getId()])
            ->andWhere(['moderation' => true])
            ->count();

        if (Yii::$app->request->post()) {
            $upload->imageFile = UploadedFile::getInstance($upload, 'imageFile');

            if ($upload->upload()) {
                $model->name = $upload->imageFile->name;
                $model->category_id = $id;
                $model->user_id = Yii::$app->user->identity->getId();
                if ($user >= 5) {
                    $model->moderation = true;
                }
                $model->save();

                $rating->picture_id = $model->id;
                $rating->user_id = Yii::$app->user->identity->getId();
                $rating->save();
            }
        }

        return $this->render(
            'view',
            [
                'model' => $model,
                'upload' => $upload,
                'pictures' => $pictures,
            ]
        );
    }

    /**
     * @param $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDetail($id): string
    {
        if (empty($id)) {
            throw new NotFoundHttpException('Страница не найдена.');
        }

        $model = Gallery::find()->where(['id' => $id])->one();

        return $this->render(
            'detail',
            [
                'model' => $model,
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
