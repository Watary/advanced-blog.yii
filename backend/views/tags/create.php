<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Tags */

$this->title = 'Create tag';
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['/tags']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tags-create">
    <div class="card">
        <div class="card-header-tab card-header-tab-animation card-header">
            <div class="card-header-title">
                <?= $this->title ?>
            </div>
        </div>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
