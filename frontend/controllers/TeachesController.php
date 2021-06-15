<?php

namespace frontend\controllers;

use common\models\Instructor;
use common\models\Section;
use common\models\Student;
use common\models\Takes;
use Yii;
use common\models\Teaches;
use common\models\TeachesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TeachesController implements the CRUD actions for Teaches model.
 */
class TeachesController extends Controller
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
     * Lists all Teaches models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TeachesSearch();
        $params = Yii::$app->request->queryParams;
        $searchModel->ID = Yii::$app->user->id;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Teaches model.
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
     * Creates a new Teaches model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Teaches();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID, 'course_id' => $model->course_id, 'sec_id' => $model->sec_id, 'semester' => $model->semester, 'year' => $model->year]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Teaches model.
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

    public function actionTeachLesson(){
        $sections = Section::find()->all();
        $sectionItems = array();
        $delimiter = ' / ';
        if(!Yii::$app->user->isGuest) {
            $teacher = Instructor::findOne(['ID' => Yii::$app->user->id]);
            foreach ($sections as $section) {
                $data = $section->sec_id.$delimiter.$section->course_id . $delimiter . $section->semester . $delimiter . $section->year . $delimiter . $section->building . $delimiter . $section->room_number;
                array_push($sectionItems, $data);
            }
            if($teacher->load(Yii::$app->request->post())){
                $allSaved = true;
                foreach ($teacher->takes as $sectionIndex){
                    $section = explode($delimiter, $sectionItems[$sectionIndex]);
                    $teaches = new Teaches();
                    $teaches->ID = $teacher->ID;
                    $teaches->sec_id = $section[0];
                    $teaches->course_id = $section[1];
                    $teaches->semester = $section[2];
                    $teaches->year = intval($section[3]);
                    if(!$teaches->saveModel()){
                        $allSaved = false;
                    }
                }
                if($allSaved){
                    return $this->redirect(['teaches/index']);
                }
            }
            return $this->render('teach-lesson', [
                'teacher' => $teacher,
                'sectionItems' => $sectionItems
            ]);
        }
        return $this->redirect(['site/login']);

    }

    /**
     * Deletes an existing Teaches model.
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
     * Finds the Teaches model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $ID
     * @param string $course_id
     * @param string $sec_id
     * @param string $semester
     * @param string $year
     * @return Teaches the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID, $course_id, $sec_id, $semester, $year)
    {
        if (($model = Teaches::findOne(['ID' => $ID, 'course_id' => $course_id, 'sec_id' => $sec_id, 'semester' => $semester, 'year' => $year])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
