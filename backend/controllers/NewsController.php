<?php

namespace backend\controllers;

use common\models\Picture;
use common\repositories\CategoryRepository;
use common\repositories\NewsRepository;
use Throwable;
use Yii;
use common\models\News;
use backend\models\NewsSearch;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['user']
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin', 'redactor'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $newsRepository = new NewsRepository();

        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'newsRepository' => $newsRepository,
            ]
        );
    }

    /**
     * Displays a single News model.
     *
     * @param integer $id
     *
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id): string
    {
        $newsRepository = new NewsRepository();

        return $this->render(
            'view',
            [
                'model' => $this->findModel($id),
                'newsRepository' => $newsRepository,
            ]
        );
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new News();
        $picture = new Picture();
        $categoryRepository = new CategoryRepository();
        $newsRepository = new NewsRepository();
        $tree = $categoryRepository::getTree();

        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($picture, 'name');

            if (!$file) {
                Yii::$app->session->setFlash('error', 'Изображение не загружено!');
            }

            if (empty(Yii::$app->request->post()['News']['rel'])) {
                Yii::$app->session->setFlash('error', 'Категория не выбрана!');
            }

            if ($file && !empty(Yii::$app->request->post()['News']['rel'])) {
                $picture->name = Yii::$app->image->uploadFile($file, "uploads");

                if ($picture->save()) {
                    $model->picture_id = $picture->id;
                    if ($model->save()) {
                        $newsRepository->loadCategoryList($model);
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
        }

        $newsRepository->setCategoryList($model);

        return $this->render(
            'create',
            [
                'model' => $model,
                'picture' => $picture,
                'tree' => $tree,
            ]
        );
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);
        $picture = Picture::findOne(['id' => $model->picture_id]);
        $newsRepository = new NewsRepository();
        $categoryRepository = new CategoryRepository();
        $tree = $categoryRepository::getTree();

        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($picture, 'name');

            if ($file) {
                $picture->name = Yii::$app->image->uploadFile($file, "uploads");
            } else {
                $picture->name = $picture->getOldAttribute("name");
            }

            if (empty(Yii::$app->request->post()['News']['rel'])) {
                Yii::$app->session->setFlash('error', 'Категория не выбрана!');
            }

            if (!empty(Yii::$app->request->post()['News']['rel']) && $picture->save() && $model->save()) {
                $newsRepository->loadCategoryList($model);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $newsRepository->setCategoryList($model);

        return $this->render(
            'update',
            [
                'model' => $model,
                'picture' => $picture,
                'tree' => $tree,
            ]
        );
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete(int $id): Response
    {
        $model = $this->findModel($id);
        Yii::$app->image->deleteFile($model->picture->name);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): News
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
