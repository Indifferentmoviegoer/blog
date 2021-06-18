<?php

namespace frontend\controllers;

use common\models\UploadGalleryForm;
use common\models\Gallery;
use common\models\GalleryCategory;
use Yii;
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

    public function actionView($id)
    {
        if (empty($id)){
            throw new NotFoundHttpException('Страница не найдена.');
        }

        $model = new Gallery();
        $upload = new UploadGalleryForm();
        $pictures = Gallery::find()->where(['category_id' => $id])->all();

        if (Yii::$app->request->post()) {
            $upload->imageFile = UploadedFile::getInstance($upload, 'imageFile');

            if ($upload->upload()) {
                $model->name = $upload->imageFile->name;
                $model->category_id = $id;
                $model->save();
            }
        }

        return $this->render('view', [
            'model' => $model,
            'upload' => $upload,
            'pictures' => $pictures,
        ]);
    }
}
