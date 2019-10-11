<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Articles */

$this->title = 'Create Blog Articles';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['/blog']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-articles-create">

    <?= $this->render('_form', [
        'model' => $model,
        'items_categories' => $items_categories,
        //'items_tags' => $items_tags,
    ]) ?>

</div>
