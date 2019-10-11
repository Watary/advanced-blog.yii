<?php
namespace app\widgets;

class BlogCategories extends \yii\bootstrap\Widget
{
    public function init(){}

    public function run() {
        return $this->render('blog-categories/view', [
            'title' => 'Categories',
            'categories' => \app\modules\blog\models\BlogCategories::find()->all(),
        ]);
    }
}