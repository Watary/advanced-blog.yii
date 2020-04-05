<?php
use yii\grid\GridView;
use yii\helpers\Html;
use backend\models\Articles;
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'formatter' => [
        'class' => '\yii\i18n\Formatter',
        'dateFormat' => 'MM/dd/yyyy',
        'datetimeFormat' => 'dd-MM-yyyy HH:mm:ss',
    ],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'title',
        [
            'attribute' => 'id_author',
            'label'=>'Author',
            'format' => 'raw',
            'value' => function($data){
                return $data->author->username;
            }
        ],
        [
            'attribute' => 'id_category',
            'label'=>'Category',
            'format' => 'raw',
            'value' => function($data){
                if($data->category->id){
                    return Html::a($data->category->title, ['categories/view/'.$data->id]);
                }
                return false;
            }
        ],
        [
            'attribute' => 'status',
            'label'=>'Status',
            'format' => 'raw',
            'value' => function($data){
                if($data->status == Articles::STATUS_ACTIVE){
                    return '<span class="text-success" id="article-status-'.$data->id.'">Active</span>';
                }elseif ($data->status == Articles::STATUS_INACTIVE){
                    return '<span class="text-danger" id="article-status-'.$data->id.'">Inactive</span>';
                }elseif ($data->status == Articles::STATUS_DELETE){
                    return '<span class="text-danger" id="article-status-'.$data->id.'">Delete</span>';
                }
            }
        ],
        'count_show',
        'count_show_all',
        'mark',
        'created_at:datetime',
        [
            'attribute' => 'updated_at',
            'label'=>'Updated',
            'format' => 'raw',
            'value' => function($data){
                return "<span id='article-updated-".$data->id."'>".date('d-m-Y H:i:s', $data->updated_at)."</span>";
            }
        ],

        [
            'label'=>'Actions',
            'format' => 'raw',
            'value' => function($data){
                $result = Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['articles/view/'.$data->id], ['title' => 'View'])
                    .' '.Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['articles/update/'.$data->id], ['title' => 'Update'])
                    .' '.Html::a('<span class="glyphicon glyphicon-trash"></span>', ['articles/delete/'.$data->id], [
                        'title' => 'Delete',
                        'aria-label' => 'Delete',
                        'data-pjax' => '0',
                        'data-confirm' => 'Are you sure you want to delete this item?',
                        'data-method' => 'post']).' ';

                if($data->status == Articles::STATUS_ACTIVE) {
                    $result .= Html::a('<span class="glyphicon glyphicon-minus text-danger" id="article-span-'.$data->id.'"></span>', [''], [
                        'title' => 'Inactivate',
                        'id' => 'article-' . $data->id,
                        'onclick' => "changeStatus($data->id)"
                    ]);
                }else{
                    $result .= Html::a('<span class="glyphicon glyphicon-plus text-success" id="article-span-'.$data->id.'"></span>', [''], [
                        'title' => 'Activate',
                        'id' => 'article-' . $data->id,
                        'onclick' => "changeStatus($data->id)"
                    ]);
                }

                return $result;
            }
        ],
    ],
]); ?>

<button id="button-show-toastr-article-activate" type="button" class="show-toastr-article-activate hidden"></button>
<button id="button-show-toastr-article-inactivate" type="button" class="show-toastr-article-inactivate hidden"></button>

<script>
    function changeStatus(id_articles){
        var article_status = document.getElementById('article-status-' + id_articles);
        var article_updated = document.getElementById('article-updated-' + id_articles);
        var article = document.getElementById('article-span-' + id_articles);

        event.preventDefault();

        $.ajax({
            url: '<?= \yii\helpers\Url::toRoute('articles/change-status/', true) ?>',
            type: 'post',
            data: {
                id_article: id_articles,
                _csrf: '<?=Yii::$app->request->getCsrfToken()?>'
            },
            success: function (data) {
                if(data.status !== 'active') {
                    article.classList.remove("glyphicon-minus");
                    article.classList.remove("text-danger");

                    article.classList.add("glyphicon-plus");
                    article.classList.add("text-success");

                    article_status.classList.remove("text-success");
                    article_status.classList.add("text-danger");
                    article_status.innerHTML = 'Inactive';

                    article_updated.innerHTML = data.updated_at;

                    document.getElementById('button-show-toastr-article-inactivate').click();
                }else{
                    article.classList.remove("glyphicon-plus");
                    article.classList.remove("text-success");

                    article.classList.add("glyphicon-minus");
                    article.classList.add("text-danger");

                    article_status.classList.remove("text-danger");
                    article_status.classList.add("text-success");
                    article_status.innerHTML = 'Active';

                    article_updated.innerHTML = data.updated_at;

                    document.getElementById('button-show-toastr-article-activate').click();
                }
            }
        });
    }
</script>
