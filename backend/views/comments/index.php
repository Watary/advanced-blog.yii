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
                                return '<span class="text-success" id="comment-status-'.$data->id.'">Active</span>';
                            }elseif ($data->status == Comments::STATUS_INACTIVE){
                                return '<span class="text-danger" id="comment-status-'.$data->id.'">Inactive</span>';
                            }elseif ($data->status == Comments::STATUS_DELETE){
                                return '<span class="text-danger" id="comment-status-'.$data->id.'">Delete</span>';
                            }
                        }
                    ],
                    'text:ntext',
                    'created_at:datetime',
                    [
                        'attribute' => 'updated_at',
                        'label'=>'Updated',
                        'format' => 'raw',
                        'value' => function($data){
                            return "<span id='comment-updated-".$data->id."'>".date('d-m-Y H:i:s', $data->updated_at)."</span>";
                        }
                    ],
                    [
                        'label'=>'Actions',
                        'format' => 'raw',
                        'value' => function($data){
                             $result = Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['articles/view/'.$data->id_articles.'#comment-'.$data->id], ['title' => 'View'])  //Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['articles/view/'.$data->id_articles, 'comment' => $data->id], ['title' => 'View'])
                                .' '.Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['comments/update/'.$data->id], ['title' => 'Update'])
                                .' '.Html::a('<span class="glyphicon glyphicon-trash"></span>', ['comments/delete/'.$data->id], [
                                    'title' => 'Delete',
                                    'aria-label' => 'Delete',
                                    'data-pjax' => '0',
                                    'data-confirm' => 'Are you sure you want to delete this item?',
                                    'data-method' => 'post']).' ';

                             if($data->status == Comments::STATUS_ACTIVE) {
                                 $result .= Html::a('<span class="glyphicon glyphicon-minus text-danger" id="comment-span-'.$data->id.'"></span>', [''], [
                                     'title' => 'Inactivate',
                                     'id' => 'comment-' . $data->id,
                                     'onclick' => "changeStatus($data->id)"
                                 ]);
                             }else{
                                 $result .= Html::a('<span class="glyphicon glyphicon-plus text-success" id="comment-span-'.$data->id.'"></span>', [''], [
                                     'title' => 'Activate',
                                     'id' => 'comment-' . $data->id,
                                     'onclick' => "changeStatus($data->id)"
                                 ]);
                             }

                            return $result;
                        }

                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

<button id="button-show-toastr-comment-activate" type="button" class="show-toastr-comment-activate hidden"></button>
<button id="button-show-toastr-comment-inactivate" type="button" class="show-toastr-comment-inactivate hidden"></button>

<script>
    function changeStatus(id_comment){
        var comment_status = document.getElementById('comment-status-' + id_comment);
        var comment_updated = document.getElementById('comment-updated-' + id_comment);
        var comment = document.getElementById('comment-span-' + id_comment);
        event.preventDefault();

        $.ajax({
            url: '<?= \yii\helpers\Url::toRoute('comments/change-status/', true) ?>',
            type: 'post',
            data: {
                id_comment: id_comment,
                _csrf: '<?=Yii::$app->request->getCsrfToken()?>'
            },
            success: function (data) {
                if(data.status !== 'active') {
                    comment.classList.remove("glyphicon-minus");
                    comment.classList.remove("text-danger");

                    comment.classList.add("glyphicon-plus");
                    comment.classList.add("text-success");

                    comment_status.classList.remove("text-success");
                    comment_status.classList.add("text-danger");
                    comment_status.innerHTML = 'Inactive';

                    comment_updated.innerHTML = data.updated_at;

                    document.getElementById('button-show-toastr-comment-inactivate').click();
                }else{
                    comment.classList.remove("glyphicon-plus");
                    comment.classList.remove("text-success");

                    comment.classList.add("glyphicon-minus");
                    comment.classList.add("text-danger");

                    comment_status.classList.remove("text-danger");
                    comment_status.classList.add("text-success");
                    comment_status.innerHTML = 'Active';

                    comment_updated.innerHTML = data.updated_at;

                    document.getElementById('button-show-toastr-comment-activate').click();
                }
            }
        });
    }
</script>