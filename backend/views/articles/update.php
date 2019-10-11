<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Articles */

$this->title = 'Update articles: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Blog articles', 'url' => ['/blog']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['article/'.$model->alias]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="articles-update">

    <?= $this->render('_form', [
        'model' => $model,
        'items_categories' => $items_categories,
        //'items_tags' => $items_tags,
    ]) ?>

</div>
