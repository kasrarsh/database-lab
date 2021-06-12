<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
$user = \common\models\User::findOne(['id'=>Yii::$app->user->id])
?>
<div class="site-index">

    <?php if(!Yii::$app->user->isGuest){ ?>
    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row text-center">
            <div class="col-lg-4">
                <?php
                    $url='';
                    if($user) {
                        if ( $user->role == \common\models\User::ROLE_STUDENT) {
                            $url = ['takes/index','TakesSearch'=>['ID'=>$user->id]];
                        } elseif ( $user->role == \common\models\User::ROLE_TEACHER) {
                            $url = ['teaches/index','TeachesSearch'=>['ID'=>$user->id]];
                        }
                    }
                ?>
              <a class="btn btn-success" href=<?= \yii\helpers\Url::to($url) ?>> my lessons</a>
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
    <?php }else{ ?>
        <div class="jumbotron">
            <a class="btn btn-lg btn-success" href=<?= \yii\helpers\Url::to(['site/login']) ?> >Login</a>
        </div>
    <?php } ?>
</div>
