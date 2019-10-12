<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
    <?= $this->render('header.php') ?>

    <?= $this->render('theme-settings.php') ?>

    <div class="app-main">

        <?= $this->render('sidebar-left.php') ?>

        <div class="app-main__outer">
            <div class="app-main__inner">

                <?= Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => 'Dashboard',
                        'url' => '/',
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>

                <?= $content ?>
            </div>

            <?= $this->render('footer.php') ?>

        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
