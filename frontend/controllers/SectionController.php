<?php

namespace frontend\controllers;

use common\models\Classroom;
use common\models\Course;
use Yii;
use common\models\Section;
use common\models\SectionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SectionController implements the CRUD actions for Section model.
 */
class SectionController extends Controller
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
     * Lists all Section models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SectionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Displays a single Section model.
     * @param string $course_id
     * @param string $sec_id
     * @param string $semester
     * @param string $year
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($course_id, $sec_id, $semester, $year)
    {
        return $this->render('view', [
            'model' => $this->findModel($course_id, $sec_id, $semester, $year),
        ]);
    }

    /**
     * Creates a new Section model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Section();
        $courses = Course::find()->select('title')->indexBy('course_id')->column();
        $buildings = Classroom::find()->select('building')->indexBy('building')->column();
        $roomNumbers = Classroom::find()->select('room_number')->indexBy('building')->column();
        $classrooms = array();
        foreach ($buildings as $index=>$building){
            $classrooms[] = $building.'-'.$roomNumbers[$index];
        }

        if ($model->load(Yii::$app->request->post())) {
            $selectedClassroom = explode('-',$classrooms[$model->classroom]);
            $model->building = $selectedClassroom[0];
            $model->room_number = $selectedClassroom[1];
            if($model->saveModel()) {
                return $this->redirect(['view', 'course_id' => $model->course_id, 'sec_id' => $model->sec_id, 'semester' => $model->semester, 'year' => $model->year]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'courses' => $courses,
//            'buildings' => $buildings,
//            'roomNumbers' => $roomNumbers
            'classrooms' => $classrooms
        ]);
    }

    /**
     * Updates an existing Section model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $course_id
     * @param string $sec_id
     * @param string $semester
     * @param string $year
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($course_id, $sec_id, $semester, $year)
    {
        $model = $this->findModel($course_id, $sec_id, $semester, $year);
        $courses = Course::find()->select('title')->indexBy('course_id')->column();
        $buildings = Classroom::find()->select('building')->indexBy('building')->column();
        $roomNumbers = Classroom::find()->select('room_number')->indexBy('building')->column();
        $classrooms = array();
        foreach ($buildings as $index=>$building){
            $classrooms[] = $building.'-'.$roomNumbers[$index];
        }
        $model->classroom = $model->building.'-'.$model->room_number;
        if($key = array_search($model->classroom,$classrooms)){
            $model->classroom = $key;
        }
        if ($model->load(Yii::$app->request->post())) {
            $selectedClassroom = explode('-',$classrooms[$model->classroom]);
            $model->building = $selectedClassroom[0];
            $model->room_number = $selectedClassroom[1];
            if($model->saveModel()) {
                return $this->redirect(['view', 'course_id' => $model->course_id, 'sec_id' => $model->sec_id, 'semester' => $model->semester, 'year' => $model->year]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'courses' => $courses,
            'classrooms' => $classrooms
        ]);
    }

    /**
     * Deletes an existing Section model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $course_id
     * @param string $sec_id
     * @param string $semester
     * @param string $year
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($course_id, $sec_id, $semester, $year)
    {
        $this->findModel($course_id, $sec_id, $semester, $year)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Section model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $course_id
     * @param string $sec_id
     * @param string $semester
     * @param string $year
     * @return Section the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($course_id, $sec_id, $semester, $year)
    {
        if (($model = Section::findOne(['course_id' => $course_id, 'sec_id' => $sec_id, 'semester' => $semester, 'year' => $year])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
