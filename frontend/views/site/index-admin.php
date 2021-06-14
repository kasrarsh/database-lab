<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
$user = \common\models\User::findOne(['id'=>Yii::$app->user->id])
?>
<div class="site-index">

    <?php if(!Yii::$app->user->isGuest){ ?>
        <div class="jumbotron">
            <h1>hello!</h1>

            <p class="lead">welocome to your profile in kharazmi university</p>

        </div>

        <div class="body-content">

            <div class="row text-center">
                <div class="col-lg-4">
                    <a class="btn btn-success" href=<?= \yii\helpers\Url::to(['instructor/index']) ?>> instructors</a>
                    <p>
                        see all your instructors
                    </p>

                </div>
                <div class="col-lg-4">
                    <a class="btn btn-success" href=<?= \yii\helpers\Url::to(['section/index']) ?>>sections</a>
                    <p>
                        see all sections
                    </p>

                </div>
                <div class="col-lg-4">
                    <a class="btn btn-success" href=<?= \yii\helpers\Url::to(['course/index']) ?>>courses</a>
                    <p>
                        see all courses
                    </p>

                </div>

            </div>

        </div>
    <?php }else{ ?>
        <div class="jumbotron">
            <a class="btn btn-lg btn-success" href=<?= \yii\helpers\Url::to(['site/login']) ?> >Login</a>
        </div>
    <?php } ?>
</div>
