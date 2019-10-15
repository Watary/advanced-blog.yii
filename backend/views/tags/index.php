<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tags-index">
    <div class="card">
        <div class="card-header-tab card-header-tab-animation card-header">
            <div class="card-header-title">
                Tags
            </div>
            <ul class="nav">
                <li class="nav-item"><?= Html::a('Create tag', ['/tags/create'], ['class' => 'nav-link']) ?></li>
            </ul>
        </div>
        <div class="card-body">
            <?= $this->render('grid-view-tags', [
                'dataProvider' => $dataProvider,
            ])
            ?>
        </div>
    </div>
</div>