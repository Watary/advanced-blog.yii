<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Categories */
/* @var array $items_categories list all categories */

$this->title = 'Create category';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['/categories']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-create">
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
            ]) ?>
        </div>
    </div>
</div>
