<?php
namespace app\widgets;

class BlogAdministration extends \yii\bootstrap\Widget
{
    public $article;

    public function init(){}

    public function run() {
        return $this->render('blog-administration/view', [
            'title' => 'Administration',
            'article' => $this->article,
        ]);
    }
}