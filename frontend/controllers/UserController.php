<?php


namespace frontend\controllers;


use common\models\Department;
use common\models\User;
use Yii;

class UserController extends \yii\web\Controller
{
    public function actionCreate($role){
        $model = new User();
        $departments = Department::find()->select('dept_name')->indexBy('dept_name')->column();

        if($model->load(Yii::$app->request->post())){
            $model->role = $role;
            $model->setPassword($model->password);
            $model->generateAuthKey();
            $model->generateEmailVerificationToken();
            if($model->save()) {
                if ($role == User::ROLE_STUDENT) {
                    return $this->redirect(['student/view', 'id' => $model->id]);
                }
                if ($role == User::ROLE_TEACHER) {
                    return $this->redirect(['instructor/view', 'id' => $model->id]);
                }
            }
        }
        return $this->render('create',[
            'model' => $model,
            'departments' => $departments,
        ]);

    }
}