<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'My Students');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
    <h3>filters</h3>
    <form >
        <select name="sec_id" >
            <?php foreach ($sections as $secId){ ?>
            <option value="<?= $secId ?>"><?= $secId ?></option>
            <?php } ?>
        </select>
        <div style="margin-top: 20px">
            <input class="btn btn-success" type="submit" value="find student for specific  section">
        </div>
    </form>
    </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'name',
            'dept_name',
            'tot_cred',

        ],
    ]); ?>


</div>
