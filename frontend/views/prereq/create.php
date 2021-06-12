<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Prereq */

$this->title = Yii::t('app', 'Create Prereq');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Prereqs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prereq-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
