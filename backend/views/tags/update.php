<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Tags */

$this->title = 'Update tag';
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['/tags']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['/tags/view/'.$model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tags-update">
    <div class="card">
        <div class="card-header-tab card-header-tab-animation card-header">
            <div class="card-header-title">
                Update tag: <?= $model->title ?>
            </div>
        </div>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
