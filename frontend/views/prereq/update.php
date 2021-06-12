<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Prereq */

$this->title = Yii::t('app', 'Update Prereq: {name}', [
    'name' => $model->course_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Prereqs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->course_id, 'url' => ['view', 'course_id' => $model->course_id, 'prereq_id' => $model->prereq_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="prereq-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
