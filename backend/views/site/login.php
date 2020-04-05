<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
<div class="modal-body">
    <div class="h5 modal-title text-center">
        <h4 class="mt-2">
            <div>Welcome back,</div>
            <span>Please sign in to your account below.</span>
        </h4>
    </div>

    <div class="form-row">
        <div class="col-md-12">
            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
    </div>
    <?= $form->field($model, 'rememberMe')->checkbox() ?>
</div>
<div class="modal-footer clearfix">
    <div class="float-right">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>