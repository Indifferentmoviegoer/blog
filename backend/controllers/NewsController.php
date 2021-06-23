<?php

namespace backend\controllers;

use common\models\Picture;
use backend\models\UploadForm;
use common\repositories\CategoryRepository;
use common\repositories\NewsRepository;
use Throwable;
use Yii;
use common\models\News;
use backend\models\NewsSearch;
use yii\db\StaleObjectException;
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
        return $this->render(
            'view',
            [
                'model' => $this->findModel($id),
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
        $upload = new UploadForm();
        $picture = new Picture();
        $categoryRepository = new CategoryRepository();
        $tree = $categoryRepository::getTree();

        if ($model->load(Yii::$app->request->post())) {
            $upload->imageFile = UploadedFile::getInstance($upload, 'imageFile');

            if ($upload->upload()) {
                $picture->name = $upload->imageFile->name;
                $picture->save();
                $model->picture_id = $picture->id;
                $model->save();
                $this->loadCategoryList($model);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }
        $this->setCategoryList($model);

        return $this->render(
            'create',
            [
                'model' => $model,
                'upload' => $upload,
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
        $upload = new UploadForm();
        $picture = Picture::findOne(['id' => $model->picture_id]);
        $categoryRepository = new CategoryRepository();
        $tree = $categoryRepository::getTree();

        if ($model->load(Yii::$app->request->post())) {
            $upload->imageFile = UploadedFile::getInstance($upload, 'imageFile');

            if ($upload->upload()) {
                $picture->name = $upload->imageFile->name;
                $picture->save();
            }

            $model->save();
            $this->loadCategoryList($model);

            return $this->redirect(['view', 'id' => $model->id]);
        }
        $this->setCategoryList($model);

        return $this->render(
            'update',
            [
                'model' => $model,
                'upload' => $upload,
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
        $this->findModel($id)->delete();

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
