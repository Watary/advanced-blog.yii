<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\Categories;

/* @var $this yii\web\View */
/* @var $model backend\models\Categories */
/* @var $form yii\widgets\ActiveForm */
/* @var int $items_categories */
?>

    <div class="blog-categories-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'id_parent')->widget(Select2::classname(), [
            'data' => $items_categories,
            'language' => 'en',
            'options' => [
                'placeholder' => 'Select a category ...',
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]) ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'alias', ['template' => "{label}\n{hint}\n<div class='input-group'>{input}<div class='input-group-append'><button id='generate-alias' type='button' class='btn btn-light'>Generate alias</button></div></div>\n{error}"])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status')->radioList([Categories::STATUS_INACTIVE=>'Inactive', Categories::STATUS_ACTIVE => 'Active'], ['style' => 'display:inline-block'])?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'mb-2 mr-2 btn btn-light btn-lg btn-block']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
<?php
$script =  <<< JS
    $('#generate-alias').on( 'click', function( event ){
        title = document.getElementById('categories-title').value;
        $.ajax({
            url         : generate_alias,
            type        : 'POST',
            data        : {
                url:  title,
                category:  category,
            },
            success: function (data) {
                console.log(data.message);
                document.getElementById('categories-alias').value = data.message;
            }    
        });
    
    });
JS;
$this->registerJsVar('generate_alias',  Url::toRoute('/categories/generate-alias', true));
$this->registerJsVar('category',  $model->id);
$this->registerJs($script);
?>