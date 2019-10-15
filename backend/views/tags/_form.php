<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Tags */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tags-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'alias', ['template' => "{label}\n{hint}\n<div class='input-group'>{input}<div class='input-group-append'><button id='generate-alias' type='button' class='btn btn-light'>Generate alias</button></div></div>\n{error}"])->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'mb-2 mr-2 btn btn-light btn-lg btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script =  <<< JS
    $('#generate-alias').on( 'click', function( event ){
        title = document.getElementById('tags-title').value;
        $.ajax({
            url         : generate_alias,
            type        : 'POST',
            data        : {
                title:  title,
                tag:  tag,
            },
            success: function (data) {
                console.log(data);
                document.getElementById('tags-alias').value = data;
            }    
        });
    
    });
JS;
$this->registerJsVar('generate_alias',  Url::toRoute('/tags/generate-alias', true));
$this->registerJsVar('tag',  $model->id);
$this->registerJs($script);
?>