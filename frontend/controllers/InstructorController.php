<?php

namespace frontend\controllers;

use common\models\Department;
use common\models\Section;
use common\models\Student;
use common\models\StudentSearch;
use common\models\Takes;
use common\models\Teaches;
use common\models\TeachesSearch;
use Yii;
use common\models\Instructor;
use common\models\InstructorSearch;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InstructorController implements the CRUD actions for Instructor model.
 */
class InstructorController extends Controller
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
     * Lists all Instructor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InstructorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMyStudents(){
        $params = Yii::$app->request->queryParams;
        $sections = Section::find()->select('sec_id')->indexBy('sec_id')->column();
        array_push($sections,null);
        $secId = null;
        if(!empty($params['sec_id'])){
            $secId = $params['sec_id'];
        }
        $currentYear = date('Y');
        $secIds = Teaches::find()->where(['ID'=>Yii::$app->user->id])->andWhere(['year'=>$currentYear])->andFilterWhere(['sec_id'=>$secId])->select('sec_id')->indexBy('sec_id')->column();
        $studentIds = array();
        foreach ($secIds as $secId){
            $takes = Takes::find()->where(['sec_id'=>$secId])->one();
            $student = Student::findOne(['ID'=>$takes->ID]);
            array_push($studentIds,$student->ID);
        }
        $studentSearch = new StudentSearch();
        $studentSearch->idsList = $studentIds;
        $studentProvider = $studentSearch->searchMyStudent($params);

        return $this->render('my-students',[
            'dataProvider'=>$studentProvider,
            'searchModel' => $studentSearch,
            'sections' => $sections
        ]);
    }

    /**
     * Displays a single Instructor model.
     * @param string $id
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
     * Creates a new Instructor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Instructor();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Instructor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionMyInfo(){
        $model = $this->findModel(Yii::$app->user->id);

        $departments = Department::find()->select('dept_name')->indexBy('dept_name')->column();
        if($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(['view','id'=>$model->ID]);
        }
        return $this->render('my-info',[
            'model'=>$model,
            'departments' => $departments
        ]);
    }

    /**
     * Deletes an existing Instructor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Instructor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Instructor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Instructor::findOne(['ID' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
