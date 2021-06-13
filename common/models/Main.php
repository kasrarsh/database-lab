<?php


namespace common\models;


use Yii;

class Main extends \yii\db\ActiveRecord
{
    public function saveModel(){
        if(!$this->save()){
            if($this->hasErrors()){
                foreach ($this->errors as $error){
                    if(Yii::$app->session){
                        Yii::$app->session->addFlash('danger',json_encode( $error));
                    }
                }
            }
            return false;
        }
        return true;
    }
}