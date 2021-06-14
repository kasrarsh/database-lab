<?php

namespace frontend\controllers;

use common\models\Section;
use common\models\Student;
use common\models\User;
use Yii;
use common\models\Takes;
use common\models\TakesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TakesController implements the CRUD actions for Takes model.
 */
class TakesController extends Controller
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
     * Lists all Takes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TakesSearch();
        $searchModel->ID = Yii::$app->user->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Takes model.
     * @param string $ID
     * @param string $course_id
     * @param string $sec_id
     * @param string $semester
     * @param string $year
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($ID, $course_id, $sec_id, $semester, $year)
    {
        return $this->render('view', [
            'model' => $this->findModel($ID, $course_id, $sec_id, $semester, $year),
        ]);
    }

    /**
     * Creates a new Takes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Takes();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID, 'course_id' => $model->course_id, 'sec_id' => $model->sec_id, 'semester' => $model->semester, 'year' => $model->year]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionTakeLesson(){
        $sections = Section::find()->all();
        $sectionItems = array();
        $delimiter = '/';
        if(!Yii::$app->user->isGuest) {
            $student = Student::findOne(['ID' => Yii::$app->user->id]);
            foreach ($sections as $section) {
                $data = $section->sec_id.$delimiter.$section->course_id . $delimiter . $section->semester . $delimiter . $section->year . $delimiter . $section->building . $delimiter . $section->room_number;
                array_push($sectionItems, $data);
            }
            if($student->load(Yii::$app->request->post())){
                $allSaved = true;
                foreach ($student->takes as $sectionIndex){
                    $section = explode($delimiter, $sectionItems[$sectionIndex]);
                    $take = new Takes();
                    $take->ID = $student->ID;
                    $take->sec_id = $section[0];
                    $take->course_id = $section[1];
                    $take->semester = $section[2];
                    $take->year = intval($section[3]);
                    if(!$take->saveModel()){
                       $allSaved = false;
                    }
                }
                if($allSaved){
                    return $this->redirect(['takes/index']);
                }
            }
            return $this->render('take-lesson', [
                'student' => $student,
                'sectionItems' => $sectionItems
            ]);
        }
        return $this->redirect(['site/login']);

    }

    /**
     * Updates an existing Takes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $ID
     * @param string $course_id
     * @param string $sec_id
     * @param string $semester
     * @param string $year
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($ID, $course_id, $sec_id, $semester, $year)
    {
        $model = $this->findModel($ID, $course_id, $sec_id, $semester, $year);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID, 'course_id' => $model->course_id, 'sec_id' => $model->sec_id, 'semester' => $model->semester, 'year' => $model->year]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Takes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $ID
     * @param string $course_id
     * @param string $sec_id
     * @param string $semester
     * @param string $year
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($ID, $course_id, $sec_id, $semester, $year)
    {
        $this->findModel($ID, $course_id, $sec_id, $semester, $year)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Takes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $ID
     * @param string $course_id
     * @param string $sec_id
     * @param string $semester
     * @param string $year
     * @return Takes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID, $course_id, $sec_id, $semester, $year)
    {
        if (($model = Takes::findOne(['ID' => $ID, 'course_id' => $course_id, 'sec_id' => $sec_id, 'semester' => $semester, 'year' => $year])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
