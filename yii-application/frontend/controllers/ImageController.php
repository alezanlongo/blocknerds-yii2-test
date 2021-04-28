<?php

namespace frontend\controllers;

use Yii;
use common\models\Image;
use common\models\ImageSearch;
use Exception;
use igogo5yo\uploadfromurl\UploadFromUrl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\BaseFileHelper;
use yii\helpers\VarDumper;

/**
 * ImageController implements the CRUD actions for Image model.
 */
class ImageController extends Controller
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
     * Lists all Image models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Image model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Image model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Image();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->uploadImage($model);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionAjax()
    {

        if (Yii::$app->request->isAjax) {
            $model = new Image();

            // VarDumper::dump($model->load(Yii::$app->request->post()) && $model->save(false));
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $this->uploadImage($model);
                $response = Yii::$app->response;
                $response->format = \yii\web\Response::FORMAT_JSON;
                $response->data = ['image' => $model];
            } else {
                throw new \yii\web\BadRequestHttpException();
            }
        }
    }

    /**
     * Updates an existing Image model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->uploadImage($model);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Image model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Image model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Image the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Image::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function getExtension(string $url)
    {
        try {
            return explode("&", explode("&fm=", $url)[1], 2)[0];
        } catch (Exception $e) {
            return "";
        }
    }

    protected function uploadImage($model)
    {
        $url = $model->url;
        $ext = $this->getExtension($url);

        $path = 'uploads/' . $model->collection->user_id . '/' . $model->collection->id;

        $file = UploadFromUrl::initWithUrl($url);

        $file->saveAs($path . '/file_id_' . $model->id . '.' . $ext);
    }
}
