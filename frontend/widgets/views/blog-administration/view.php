<?php
use yii\helpers\Url;

/**
 * @var string $title
 * @var int $article
*/

?>
<?php if( Yii::$app->user->can('createArticle')
        || Yii::$app->user->can('updateArticle')
        || Yii::$app->user->can('ownUpdateArticle', ['article' => $this->params['widget']['article']])
        || Yii::$app->user->can('deleteArticle')
        || Yii::$app->user->can('ownDeleteArticle', ['article' => $this->params['widget']['article']])
){ ?>
    <div class="blog-administration-widget">
        <div class="list-group">
            <span class="list-group-item list-group-item-action header">
                <?= $title ?>
            </span>
            <?php if(Yii::$app->user->can('createArticle')){ ?>
                <a href="<?= Url::to(['/blog/articles/create/'.$article]) ?>" class="list-group-item list-group-item-action"><?= Yii::t('app', 'Create') ?></a>
            <?php } ?>
            <?php if($this->params['widget']['article']){ ?>
                <?php if(Yii::$app->user->can('updateArticle') || Yii::$app->user->can('ownUpdateArticle', ['article' => $this->params['widget']['article']])){ ?>
                    <a href="<?= Url::to(['/blog/articles/update/'.$article]) ?>" class="list-group-item list-group-item-action"><?= Yii::t('app', 'Edit') ?></a>
                <?php } ?>

                <?php if(Yii::$app->user->can('deleteArticle') || Yii::$app->user->can('ownDeleteArticle', ['article' => $this->params['widget']['article']])){ ?>
                    <a href="<?= Url::to(['/blog/articles/delete/'.$article]) ?>" class="list-group-item list-group-item-action"><?= Yii::t('app', 'Delete') ?></a>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
<?php } ?>