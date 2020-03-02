<?php

/* @var $this yii\web\View */

$this->title = 'Dashboard';
?>
<div class="site-index">

    <div class="jumbotron">
        <?php if (!Yii::$app->user->isGuest){ ?>
            <h1>Congratulations <?= Yii::$app->user->identity->username ?>!</h1>
        <?php }else{ ?>
            <h1>Congratulations!</h1>
        <?php } ?>
    </div>


</div>
