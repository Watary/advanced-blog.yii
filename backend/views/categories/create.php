<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BlogCategories */

$this->title = 'Create Blog Categories';
$this->params['breadcrumbs'][] = ['label' => 'Blog Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-categories-create">

    <?= $this->render('_form', [
        'model' => $model,
        'items_categories' => $items_categories,
    ]) ?>

</div>
