<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Teaches */

$this->title = Yii::t('app', 'Create Teaches');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teaches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teaches-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
