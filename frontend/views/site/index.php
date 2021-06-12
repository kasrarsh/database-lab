<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row text-center">
            <div class="col-lg-4">
              <a class="btn btn-success" href=<?= \yii\helpers\Url::to(['takes/index']) ?>> my lessons</a>
                <p>
                    see what you have for this semester
                </p>

            </div>
            <div class="col-lg-4">
                <a class="btn btn-success" href=<?= \yii\helpers\Url::to(['site/index']) ?>> my report</a>
                <p>
                    see what your reports and grades
                </p>

            </div>
            <div class="col-lg-4">
                <a class="btn btn-success" href=<?= \yii\helpers\Url::to(['site/index']) ?>> take lesson</a>
                <p>
                    take new lessons
                </p>

            </div>

        </div>

    </div>
</div>
