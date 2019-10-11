<?php

/* @var $this yii\web\View */

$this->title = 'Setting';
$this->params['breadcrumbs'][] = 'Setting';
?>
<div class="main-card mb-3 card">
    <div class="card-body">
        <form class="">

            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">Title project:</span></div>
                <input name="title" placeholder="Title project" type="text" class="form-control">
            </div>
            <br>

            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">Administrator email:</span></div>
                <input name="email" placeholder="Title project" type="text" class="form-control">
            </div>
            <br>

           <button class="mb-2 mr-2 btn btn-light btn-block btn-lg">Save</button>
        </form>
    </div>
</div>