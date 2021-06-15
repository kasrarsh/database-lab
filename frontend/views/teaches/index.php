<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TeachesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'My Lessons');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teaches-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Teach A New Lesson'), ['teaches/teach-lesson'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'course_id',
            'sec_id',
            'semester',
            'year',
            [
                    'label'=>'students',
                'format' => 'html',
                'value' => function($model){
                    return Html::a('see students for this lesson',\yii\helpers\Url::to(['instructor/my-students','sec_id'=>$model->sec_id,'year'=>$model->year]));
                }
            ],
            [
                'label'=>false,
                'format' => 'html',
                'value' => function($model){
                    return Html::a('give grades',\yii\helpers\Url::to(['instructor/give-grade','sec_id'=>$model->sec_id,'year'=>$model->year]));
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
