<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-index">
    <div class="card">
        <div class="card-header-tab card-header-tab-animation card-header">
            <div class="card-header-title">
                <?= $this->title ?>
            </div>
            <ul class="nav">
                <li class="nav-item"><?= Html::a('Create category', ['create'], ['class' => 'nav-link']) ?></li>
            </ul>
        </div>
        <div class="card-body">
            <?= $this->render('grid-view-categories', [
                'dataProvider' => $dataProvider,
            ])
            ?>
        </div>
    </div>
</div>