<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Comments;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comments-index">
    <div class="card">
        <div class="card-header-tab card-header-tab-animation card-header">
            <div class="card-header-title">
                Comments
            </div>
        </div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'formatter' => [
                    'class' => '\yii\i18n\Formatter',
                    'dateFormat' => 'MM/dd/yyyy',
                    'datetimeFormat' => 'dd-MM-yyyy HH:mm:ss',
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'id_owner',
                        'label'=>'Owner',
                        'format' => 'raw',
                        'value' => function($data){
                            return $data->owner->username;
                        }
                    ],
                    [
                        'attribute' => 'id_articles',
                        'label'=>'Article',
                        'format' => 'raw',
                        'value' => function($data){
                            return $data->article->title;
                        }
                    ],
                    'id_comment',
                    [
                        'attribute' => 'status',
                        'label'=>'Status',
                        'format' => 'raw',
                        'value' => function($data){
                            if($data->status == Comments::STATUS_ACTIVE){
                                return '<span class="text-success">Active</span>';
                            }else{
                                return '<span class="text-danger">Inactive</span>';
                            }
                        }
                    ],
                    'text:ntext',
                    'created_at:datetime',
                    'updated_at:datetime',

                    [
                        'label'=>'Actions',
                        'format' => 'raw',
                        'value' => function($data){
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['articles/view/'.$data->id_articles, 'comment' => $data->id], ['title' => 'View'])
                                .' '.Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['comments/update/'.$data->id], ['title' => 'Update'])
                                .' '.Html::a('<span class="glyphicon glyphicon-trash"></span>', ['comments/delete/'.$data->id], [
                                    'title' => 'Delete',
                                    'aria-label' => 'Delete',
                                    'data-pjax' => '0',
                                    'data-confirm' => 'Are you sure you want to delete this item?',
                                    'data-method' => 'post']);
                        }

                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
