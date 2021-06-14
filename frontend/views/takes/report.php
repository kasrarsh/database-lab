<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TakesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'My Lessons');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="takes-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showFooter' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'course_id',
            'sec_id',
            'semester',
            'year',
            [
                    'attribute'=>'grade',
                    'footer'=>$average
            ],
        ],
    ]); ?>



</div>
