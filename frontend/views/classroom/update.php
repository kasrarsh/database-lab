<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Classroom */

$this->title = Yii::t('app', 'Update Classroom: {name}', [
    'name' => $model->building,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Classrooms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->building, 'url' => ['view', 'building' => $model->building, 'room_number' => $model->room_number]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="classroom-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
