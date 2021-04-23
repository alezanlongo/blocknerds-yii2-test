<?php

namespace frontend\controllers;

use Yii;
use app\models\Collection;
use app\models\CollectionSearch;
use igogo5yo\uploadfromurl\UploadFromUrl;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\BaseFileHelper;
use yii\helpers\VarDumper;
use ZipArchive;

/**
 * CollectionController implements the CRUD actions for Collection model.
 */
class CollectionController extends Controller
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
     * Lists all Collection models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CollectionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Collection model.
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
     * Creates a new Collection model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Collection();

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
            $model = new Collection();

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
     * Updates an existing Collection model.
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
     * Deletes an existing Collection model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // $model = $this->findModel($id)->delete();
        $model = $this->findModel($id);
        $this->deleteFileImage($model);
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Collection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Collection the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Collection::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Download Collection.
     * If download is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDownload()
    {
        $user_id = \Yii::$app->user->identity->id;
        $path = Yii::$app->basePath . '/web/uploads/' . $user_id;

        $zip = new ZipArchive();

        $destination = $path . "/collection.zip";

        if ($zip->open($destination, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \yii\web\HttpException(500, 'Something went wrong creating zip, please try again later.');
        }

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            // Skip directories (they would be added automatically)
            if (!$file->isDir()) {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($path) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();

        header("Pragma: public");
        header("Content-Type: application/application/force-download");
        header("Content-Disposition: inline; filename=collection.zip");
        header('Content-Length: ' . filesize($destination));
        header("Accept Ranges: bytes");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        readfile("$destination");

        if (file_exists($destination)) {
            unlink($destination);
        }
    }

    protected function uploadImage($model)
    {
        $url = $model->image;
        $ext = explode("&", explode("&fm=", $url)[1], 2)[0];
        $path = 'uploads/' . $model->user_id;

        BaseFileHelper::createDirectory($path);

        $file = UploadFromUrl::initWithUrl($url);

        $file->saveAs($path . '/file_id_' . $model->id . '.' . $ext);
    }

    protected function deleteFileImage($model)
    {
        $ext = explode("&", explode("&fm=", $model->image)[1], 2)[0];
        $path = Yii::$app->basePath . '/web/uploads/' . $model->user_id . '/file_id_' . $model->id . '.' . $ext;

        if (file_exists($path)) {
            unlink($path);
        }

        return true;
    }
}
