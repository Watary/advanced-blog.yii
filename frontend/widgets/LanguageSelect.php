<?php
namespace app\widgets;
use app\models\Lang;

class LanguageSelect extends \yii\bootstrap\Widget
{
    public function init(){}

    public function run() {
        return $this->render('language-select/view', [
            'current' => Lang::getCurrent(),
            'langs' => Lang::find()->where('id != :current_id', [':current_id' => Lang::getCurrent()->id])->all(),
        ]);
    }
}