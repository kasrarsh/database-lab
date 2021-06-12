<?php

namespace frontend\controllers;

use Yii;
use common\models\Classroom;
use common\models\ClassroomSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClassroomController implements the CRUD actions for Classroom model.
 */
class ClassroomController extends Controller
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
     * Lists all Classroom models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClassroomSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Classroom model.
     * @param string $building
     * @param string $room_number
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($building, $room_number)
    {
        return $this->render('view', [
            'model' => $this->findModel($building, $room_number),
        ]);
    }

    /**
     * Creates a new Classroom model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Classroom();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'building' => $model->building, 'room_number' => $model->room_number]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Classroom model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $building
     * @param string $room_number
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($building, $room_number)
    {
        $model = $this->findModel($building, $room_number);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'building' => $model->building, 'room_number' => $model->room_number]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Classroom model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $building
     * @param string $room_number
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($building, $room_number)
    {
        $this->findModel($building, $room_number)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Classroom model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $building
     * @param string $room_number
     * @return Classroom the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($building, $room_number)
    {
        if (($model = Classroom::findOne(['building' => $building, 'room_number' => $room_number])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
