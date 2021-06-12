<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Takes */

$this->title = Yii::t('app', 'Update Takes: {name}', [
    'name' => $model->ID,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Takes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'ID' => $model->ID, 'course_id' => $model->course_id, 'sec_id' => $model->sec_id, 'semester' => $model->semester, 'year' => $model->year]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="takes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
