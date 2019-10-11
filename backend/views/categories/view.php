<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Categories */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['/categories']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['category-alias'] = $model->alias ? $model->alias : 'uncategorized';
\yii\web\YiiAsset::register($this);
?>
<div class="blog">
    <h1><?= $this->title  ?></h1>

    <div class="category-description">
        <?= $model->description  ?>
    </div>

    <?= $this->render('/articles/grid-view-articles', [
        'dataProvider' => $dataProvider,
        ])
    ?>

</div>

<?php if($count_pages > 1) {
    echo $this->render('/pagination/pagination',[
        'count_pages' => $count_pages,
        'page' => $page,
        'url' => 'blog/category/'.$model->alias,
    ]);
}
?>
