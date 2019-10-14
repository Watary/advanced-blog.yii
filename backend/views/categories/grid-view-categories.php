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
                    return '<span class="text-success">Active</span>';
                }else{
                    return '<span class="text-danger">Inactive</span>';
                }
            }
        ],
        'created_at:datetime',

        [
            'label'=>'Actions',
            'format' => 'raw',
            'value' => function($data){
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['categories/view/'.$data->id], ['title' => 'View'])
                    .' '.Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['categories/update/'.$data->id], ['title' => 'Update'])
                    .' '.Html::a('<span class="glyphicon glyphicon-trash"></span>', ['categories/delete/'.$data->id], [
                        'title' => 'Delete',
                        'aria-label' => 'Delete',
                        'data-pjax' => '0',
                        'data-confirm' => 'Are you sure you want to delete this item?',
                        'data-method' => 'post']);
            }

        ],
    ],
]); ?>
