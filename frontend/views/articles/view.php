<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/**
 * @var array $articles
 * @var int $page
 * @var int $count_pages
 **/
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Blog articles'];

$count_pages = 10;
$page = 1;
?>
<div class="row">
    <div class="col-sm-8 col-md-9">
        <div class="blog">
            <?php for($i = 0; $i < 5; $i++) {?>
                <?= $this->render('article', ['model' => $model]) ?>
            <?php } ?>
            <?php /*foreach ($articles as $article) {?>
                <?= $this->render('/article',[
                    'article' => $article,
                ]) ?>
            <?php } */?>
            <?php /*if($count_pages > 1) {
                echo $this->render('/pagination/pagination',[
                    'count_pages' => $count_pages,
                    'page' => $page,
                    'url' => 'blog/',
                ]);
            }*/
            ?>
        </div>
    </div>

    <div class="col-sm-4 col-md-3">
        sidebar
    </div>
</div>
