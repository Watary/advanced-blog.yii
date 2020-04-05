<?php

use backend\models\Articles;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View
 * @var array $article
 */

$this->title = 'Dashboard';
?>
<div class="site-index">
    <div class="card">

        <div class="jumbotron">
            <?php if (!Yii::$app->user->isGuest){ ?>
                <h1>Congratulations <?= Yii::$app->user->identity->username ?>!</h1>
            <?php }else{ ?>
                <h1>Congratulations!</h1>
            <?php } ?>
        </div>

        <div class="col-sm-12 col-lg-4">
            <div class="mb-3 card">

                <div class="p-0 card-body">
                    <div class="p-1 slick-slider-sm mx-auto">
                        <div class="card mb-3 widget-content bg-midnight-bloom">
                            <div class="widget-content-wrapper text-white">
                                <div class="widget-content-left">
                                    <div class="widget-heading">Articles</div>
                                    <div class="widget-subheading"></div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-white"><span><?= Articles::count() ?></span></div>
                                </div>
                            </div>
                        </div>

						<?php if($article['count_all']){ ?>
                        <div class="mb-3 progress">
                            <div class="progress-bar bg-success" data-toggle="tooltip" data-placement="top" title="Active" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width: <?= $article['count_active'] / ($article['count_all'] / 100) ?>%;"><?= $article['count_active'] ?> | <?= $article['count_active'] / ($article['count_all'] / 100) ?>%</div>
                            <div class="progress-bar bg-danger" data-toggle="tooltip" data-placement="top" title="Inactive" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: <?= $article['count_inactive'] / ($article['count_all'] / 100) ?>%;"><?= $article['count_inactive'] ?> | <?= $article['count_inactive'] / ($article['count_all'] / 100) ?></div>
                            <div class="progress-bar bg-dark" data-toggle="tooltip" data-placement="top" title="Trash" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: <?= $article['count_delete'] / ($article['count_all'] / 100) ?>%;"><?= $article['count_delete'] ?> | <?= $article['count_delete'] / ($article['count_all'] / 100) ?></div>
                        </div>
                    	<?php } ?>

                        <ul class="list-group">
                            <?php foreach($article['last_articles'] as $item){ ?>
                                <a href="<?= Url::toRoute('/articles/update/'.$item->id) ?>" class="list-group-item-action list-group-item <?php if ($item->status === Articles::STATUS_ACTIVE) echo "list-group-item-success"; elseif($item->status === Articles::STATUS_INACTIVE) echo "list-group-item-danger"; else echo "list-group-item-dark"; ?>">
                                    <?= $item->title ?>
                                    <span class='badge badge-secondary badge-pill'><?= date('d-m-Y H:i:s', $item->created_at) ?></span>
                                </a>
                            <?php } ?>
                            <a href="<?= Url::toRoute('/articles') ?>" class="list-group-item text-center p-0">All articles</a>
                        </ul>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
