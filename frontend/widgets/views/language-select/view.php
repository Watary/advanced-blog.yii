<?php
use yii\helpers\Html;

/**
 * @var $current
 * @var $langs
 */
?>
<div class="lang-widget pull-right">
    <span class="current-lang">
        <?= $current->name ?>
    </span>
    <ul class="langs">
        <?php foreach ($langs as $lang):?>
            <li class="item-lang">
                <?= Html::a($lang->name, '/'.$lang->url.Yii::$app->getRequest()->getLangUrl()) ?>
            </li>
        <?php endforeach;?>
    </ul>
</div>