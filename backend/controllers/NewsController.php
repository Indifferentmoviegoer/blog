<?php

namespace backend\controllers;

use backend\models\Picture;
use backend\models\UploadForm;
use Yii;
use backend\models\News;
use backend\models\NewsSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * Displays a single News model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
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
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();
        $upload = new UploadForm();
        $picture = new Picture();

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
            ]
        );
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $upload = new UploadForm();
        $picture = Picture::findOne(['id' => $model->picture_id]);

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
            ]
        );
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
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
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
