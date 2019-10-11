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
            [['id_owner', 'title', 'alias', 'created_at'], 'required'],
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
            'id_owner' => 'Id Owner',
            'id_parent' => 'Id Parent',
            'title' => 'Title',
            'description' => 'Description',
            'alias' => 'Alias',
            'status' => 'Status',
            'id_deleted' => 'Id Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
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
            $items_categories[$item->id] = $item->title;
        }

        return $items_categories;
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
}
