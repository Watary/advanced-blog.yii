<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property int $id_owner
 * @property int $id_parent
 * @property string $title
 * @property string $description
 * @property string $alias
 * @property int $status
 * @property int $id_deleted
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 */
class Categories extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_owner', 'title', 'alias', 'status', 'created_at'], 'required'],
            [['id_owner', 'id_parent', 'status', 'id_deleted', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['description'], 'string'],
            [['title', 'alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_owner' => 'Owner',
            'id_parent' => 'Parent',
            'title' => 'Title',
            'description' => 'Description',
            'alias' => 'Alias',
            'status' => 'Status',
            'id_deleted' => 'Id Deleted',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
            'deleted_at' => 'Deleted at',
        ];
    }

    public function getArticles(){
        return $this->hasMany(Articles::className(), ['id_category' => 'id']);
    }

    public function getOwner(){
        return $this->hasOne(User::className(), ['id' => 'id_owner']);
    }

    public function getParent(){
        return $this->hasOne(Categories::className(), ['id' => 'id_parent']);
    }

    public static function findListCategories(){
        $categories = Categories::find()->all();

        $items_categories = [];

        foreach ($categories as $item){
            $items_categories[$item->id]['value'] = $item->title;
            $items_categories[$item->id]['parent'] = $item->id_parent;
        }

        return Categories::constructListCategories($items_categories, NULL);
    }

    public static function issetAlias($alias, $category){
        return Categories::find()
            ->where(['<>','id', $category])
            ->andWhere(['alias' => $alias])
            ->andWhere(['deleted_at' => NULL])
            ->count();
    }

    public static function count()
    {
        return Categories::find()->count();
    }

    private static function constructListCategories($items_categories, $parent){
        $return = [];

        if($parent) {
            $separator = ' - ';
        }

        foreach ($items_categories as $key => $item){
            if($item['parent'] == $parent){
                $return[$key] = $separator.$item['value'];
                $array = Categories::constructListCategories($items_categories, $key);
                foreach ($array as $key_in => $value){
                    $return[$key_in] = $separator.$value;
                }
            }
        }

        return $return;
    }
}
