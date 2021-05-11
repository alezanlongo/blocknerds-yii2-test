<?php

namespace frontend\controllers;

use Yii;
use common\models\Collection;
use common\models\Photo;
use DateTime;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Response;

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
                'class' => VerbFilter::class,
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
        $dataProvider = new ActiveDataProvider([
            'query' => Collection::find()->where(['user_id' => Yii::$app->user->id]),
        ]);

        return $this->render('index', [
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
        $photos = Photo::find()->where(["collection_id" => $id])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'photos' => $photos,
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

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            try {
                $model->user_id =  Yii::$app->user->id;
                $model->save();
                Yii::$app->session->setFlash('success', "Collection created.");

                return $this->redirect(['unsplash/index']);
            } catch (\Throwable $th) {
                Yii::$app->session->setFlash('error', "Error creating new collection.");
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionGetall()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $collections = Collection::find()
            ->select(["id", "title"])
            ->where([
                "user_id" => Yii::$app->user->id
            ])
            ->all();

        return [
            "message" => "",
            "data" => $collections
        ];
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

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->updated_at = date_timestamp_get(new DateTime());
            $model->save();

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
        $model = $this->findModel($id);
        // FileController::removeDir(Yii::$app->user->id, $model->id);
        $model->delete();
        Yii::$app->session->setFlash('success', "Collection deleted.");

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
}
