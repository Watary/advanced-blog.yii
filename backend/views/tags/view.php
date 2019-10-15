<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\db\ActiveQuery */
/* @var $model \backend\models\Tags */

$this->title = 'Tag: '.$model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['/tags']];
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="tags-view">
    <div class="card">
        <div class="card-header-tab card-header-tab-animation card-header">
            <div class="card-header-title">
                <?= $this->title ?>
            </div>
        </div>
        <div class="card-body">
            <?= $this->render('/articles/grid-view-articles', [
                'dataProvider' => $dataProvider,
            ])?>
        </div>
    </div>
</div>