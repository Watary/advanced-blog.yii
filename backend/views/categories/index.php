<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blog Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-categories-index">

    <p>
        <?= Html::a('Create category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('grid-view-categories', [
        'dataProvider' => $dataProvider,
    ])
    ?>
</div>