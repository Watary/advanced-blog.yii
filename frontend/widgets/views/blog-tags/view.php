<?php
use yii\helpers\Url;

/**
 * @var string $title
 * @var array $tags
*/

?>
<div class="blog-categories-widget">
    <div class="list-group">
        <span class="list-group-item list-group-item-action header">
            <?= $title ?>
        </span>
        <span class="list-group-item list-group-item-action">
            <?php foreach ($tags as $tag){ ?>
                <a href="<?= Url::to(['/blog/tag/'.$tag->alias]) ?>" class=""><span class="badge badge-secondary"><?= $tag->title ?></span></a>
            <?php } ?>
        </span>
    </div>
</div>