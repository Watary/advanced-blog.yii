<?php
use yii\grid\GridView;
use yii\helpers\Html;
use backend\models\Tags;

/* @var $dataProvider yii\data\ActiveDataProvider */

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
            'value' => function($data){
                return $data->owner->username;
            },
        ],
        'alias',
        'description',
        'created_at:datetime',
        'updated_at:datetime',
        [
            'label'=>'Count articles',
            'value' => function($data){
                return count($data->articletag);
            },
        ],

        [
            'label'=>'Actions',
            'format' => 'raw',
            'value' => function($data){
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['tags/view/'.$data->id], ['title' => 'View'])
                    .' '.Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['tags/update/'.$data->id], ['title' => 'Update'])
                    .' '.Html::a('<span class="glyphicon glyphicon-trash"></span>', ['tags/delete/'.$data->id], [
                        'title' => 'Delete',
                        'aria-label' => 'Delete',
                        'data-pjax' => '0',
                        'data-confirm' => 'Are you sure you want to delete this item?',
                        'data-method' => 'post']);
            }
        ],
    ],
]); ?>