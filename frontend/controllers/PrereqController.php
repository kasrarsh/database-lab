<?php

namespace frontend\controllers;

use Yii;
use common\models\Prereq;
use common\models\PrereqSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PrereqController implements the CRUD actions for Prereq model.
 */
class PrereqController extends Controller
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
     * Lists all Prereq models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PrereqSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Prereq model.
     * @param string $course_id
     * @param string $prereq_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($course_id, $prereq_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($course_id, $prereq_id),
        ]);
    }

    /**
     * Creates a new Prereq model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Prereq();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'course_id' => $model->course_id, 'prereq_id' => $model->prereq_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Prereq model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $course_id
     * @param string $prereq_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($course_id, $prereq_id)
    {
        $model = $this->findModel($course_id, $prereq_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'course_id' => $model->course_id, 'prereq_id' => $model->prereq_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Prereq model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $course_id
     * @param string $prereq_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($course_id, $prereq_id)
    {
        $this->findModel($course_id, $prereq_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Prereq model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $course_id
     * @param string $prereq_id
     * @return Prereq the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($course_id, $prereq_id)
    {
        if (($model = Prereq::findOne(['course_id' => $course_id, 'prereq_id' => $prereq_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
