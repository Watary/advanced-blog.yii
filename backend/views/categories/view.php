<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Categories */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['/categories']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['category-alias'] = $model->alias ? $model->alias : 'uncategorized';
\yii\web\YiiAsset::register($this);
?>
<div class="categories-view">
    <div class="card">
        <div class="card-header-tab card-header-tab-animation card-header">
            <div class="card-header-title">
                Category: <?= $this->title ?>
            </div>
            <ul class="nav">
                <li class="nav-item"><?= Html::a('Update this category', ['/categories/update/'.$model->id], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= Html::a('Create category', ['create', 'category' => $model->id], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= Html::a('Create article', ['/articles/create', 'category' => $model->id], ['class' => 'nav-link']) ?></li>
            </ul>
        </div>
        <div class="card-body">
            <?= $model->description ?>

            <hr>

            <?= $this->render('/articles/grid-view-articles', [
                'dataProvider' => $dataProvider,
            ])
            ?>
        </div>
    </div>
</div>
