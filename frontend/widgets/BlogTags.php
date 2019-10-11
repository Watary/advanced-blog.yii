<?php
namespace app\widgets;
use app\models\Lang;

class BlogTags extends \yii\bootstrap\Widget
{
    public function init(){}

    public function run() {
        return $this->render('blog-tags/view', [
            'title' => 'Tags',
            'tags' => \app\modules\blog\models\BlogTags::find()->all(),
        ]);
    }
}