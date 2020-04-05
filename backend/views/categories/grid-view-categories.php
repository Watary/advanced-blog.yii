<?php
use yii\grid\GridView;
use yii\helpers\Html;
use backend\models\Categories;
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
            'attribute' => 'id_owner',
            'label'=>'Owner',
            'format' => 'raw',
            'value' => function($data){
                return $data->owner->username;
            }
        ],
        [
            'attribute' => 'id_parent',
            'label'=>'Parent',
            'format' => 'raw',
            'value' => function($data){
                if($data->parent->status == Categories::STATUS_ACTIVE)
                    return Html::a($data->parent->title, ['categories/view/'.$data->id]);
            }
        ],
        [
            'attribute' => 'status',
            'label'=>'Status',
            'format' => 'raw',
            'value' => function($data){
                if($data->status == Categories::STATUS_ACTIVE){
                    return '<span class="text-success" id="category-status-'.$data->id.'">Active</span>';
                }elseif ($data->status == Categories::STATUS_INACTIVE){
                    return '<span class="text-danger" id="category-status-'.$data->id.'">Inactive</span>';
                }elseif ($data->status == Categories::STATUS_DELETE){
                    return '<span class="text-danger" id="category-status-'.$data->id.'">Delete</span>';
                }
            }
        ],
        'created_at:datetime',

        [
            'label'=>'Actions',
            'format' => 'raw',
            'value' => function($data){
                $result = Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['categories/view/'.$data->id], ['title' => 'View'])
                    .' '.Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['categories/update/'.$data->id], ['title' => 'Update'])
                    .' '.Html::a('<span class="glyphicon glyphicon-trash"></span>', ['categories/delete/'.$data->id], [
                        'title' => 'Delete',
                        'aria-label' => 'Delete',
                        'data-pjax' => '0',
                        'data-confirm' => 'Are you sure you want to delete this item?',
                        'data-method' => 'post']).' ';

                if($data->status == Categories::STATUS_ACTIVE) {
                    $result .= Html::a('<span class="glyphicon glyphicon-minus text-danger" id="category-span-'.$data->id.'"></span>', [''], [
                        'title' => 'Inactivate',
                        'id' => 'category-' . $data->id,
                        'onclick' => "changeStatus($data->id)"
                    ]);
                }else{
                    $result .= Html::a('<span class="glyphicon glyphicon-plus text-success" id="category-span-'.$data->id.'"></span>', [''], [
                        'title' => 'Activate',
                        'id' => 'category-' . $data->id,
                        'onclick' => "changeStatus($data->id)"
                    ]);
                }

                return $result;
            }
        ],
    ],
]); ?>


<button id="button-show-toastr-category-activate" type="button" class="show-toastr-category-activate hidden"></button>
<button id="button-show-toastr-category-inactivate" type="button" class="show-toastr-category-inactivate hidden"></button>

<script>
    function changeStatus(id_category){
        var category_status = document.getElementById('category-status-' + id_category);
        var category = document.getElementById('category-span-' + id_category);

        event.preventDefault();

        $.ajax({
            url: '<?= \yii\helpers\Url::toRoute('categories/change-status/', true) ?>',
            type: 'post',
            data: {
                id_category: id_category,
                _csrf: '<?=Yii::$app->request->getCsrfToken()?>'
            },
            success: function (data) {
                if(data.status !== 'active') {
                    category.classList.remove("glyphicon-minus");
                    category.classList.remove("text-danger");

                    category.classList.add("glyphicon-plus");
                    category.classList.add("text-success");

                    category_status.classList.remove("text-success");
                    category_status.classList.add("text-danger");
                    category_status.innerHTML = 'Inactive';

                    document.getElementById('button-show-toastr-category-inactivate').click();
                }else{
                    category.classList.remove("glyphicon-plus");
                    category.classList.remove("text-success");

                    category.classList.add("glyphicon-minus");
                    category.classList.add("text-danger");

                    category_status.classList.remove("text-danger");
                    category_status.classList.add("text-success");
                    category_status.innerHTML = 'Active';

                    document.getElementById('button-show-toastr-category-activate').click();
                }
            }
        });
    }
</script>
