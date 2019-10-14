<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Articles */
/* @var array $items_categories */
/* @var array $items_tags */

$this->title = 'Update articles: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['/articles']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['/articles/article/'.$model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="articles-update">
    <div class="card">
        <div class="card-header-tab card-header-tab-animation card-header">
            <div class="card-header-title">
                <?= $this->title ?>
            </div>
        </div>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'items_categories' => $items_categories,
                'items_tags' => $items_tags,
            ]) ?>
        </div>
    </div>
</div>
