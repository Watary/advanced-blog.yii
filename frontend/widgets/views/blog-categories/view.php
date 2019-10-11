<?php
use yii\helpers\Url;
use app\modules\blog\models\BlogArticles;

/**
 * @var string $title
 * @var array $categories
*/

?>
<div class="blog-categories-widget">
    <div class="list-group">
        <span class="list-group-item list-group-item-action header">
            <?= $title ?>
        </span>
        <?php foreach ($categories as $category){ ?>
            <?php if($count = count($category->articles)){ ?>
                <a href="<?= Url::to(['/blog/category/'.$category->alias]) ?>" class="list-group-item <?= $this->params['category-alias'] == $category->alias ? 'select' : '' ?>"><?= $category->title ?><span class="badge badge-secondary"><?= $count ?></span></a>
            <?php } ?>
        <?php } ?>
        <?php if($uncategorized = BlogArticles::countArticlesUncategorized()){ ?>
            <a href="<?= Url::to(['/blog/category/uncategorized']) ?>" class="list-group-item  <?= $this->params['category-alias'] == 'uncategorized' ? 'select' : '' ?>">Uncategorized<span class="badge badge-secondary"><?= $uncategorized ?></span></a>
        <?php } ?>
    </div>
</div>