<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Takes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="takes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($teacher, 'takes')->checkboxList($sectionItems)->label('Take Your New Lessons') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
