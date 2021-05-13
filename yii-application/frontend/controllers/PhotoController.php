<?php

namespace frontend\controllers;

use common\models\Collection;
use Yii;
use common\models\Photo;
use DateTime;
use Exception;
use igogo5yo\uploadfromurl\UploadFromUrl;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\BaseFileHelper;
use yii\helpers\VarDumper;
use yii\web\Response;
use ZipArchive;

/**
 * PhotoController implements the CRUD actions for Photo model.
 */
class PhotoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
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
     * Lists all Photo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Photo::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Photo model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Photo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Photo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Photo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Photo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        // FileController::removeFile(Yii::$app->user->id, $model->collection_id, $model->photo_id);
        $model->delete();

        return $this->redirect(['collection/view', "id" => $model->collection_id]);
    }

    /**
     * Finds the Photo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Photo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Photo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAdd($photoId, $collectionId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $userId = Yii::$app->user->id;

        if (!$userId) {
            return [
                "type" => "error",
                "message" => "You need be logged."
            ];
        }

        $photo = UnsplashController::searchOne($photoId);
        $transaction = Photo::getDb()->beginTransaction();

        try {
            $newPhoto = new Photo();
            $newPhoto->photo_id = $photoId;
            $newPhoto->collection_id = $collectionId;
            $newPhoto->url = $photo["urls"]["small"];
            $newPhoto->title = $photo["user"]["name"] ?? "";
            $newPhoto->description = $photo["description"];
            $newPhoto->save();
            // handle image file
            $url = $photo["urls"]["small"];
            FileController::uploadImage($url, $userId,  $collectionId, $photoId);
            // commit transaction, it's ok
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();

            return [
                "type" => "error",
                "message" => "something happend. Photo doesn't added."
            ];
        }

        return [
            "type" => "success",
            "message" => "favorite added."
        ];
    }
}
