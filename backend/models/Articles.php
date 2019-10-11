<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "articles".
 *
 * @property int $id
 * @property int $id_category
 * @property int $id_author
 * @property string $title
 * @property string $text
 * @property string $excerpt
 * @property string $image
 * @property string $alias
 * @property int $status
 * @property int $count_show_all
 * @property int $count_show
 * @property int $count_comments
 * @property double $mark
 * @property int $id_deleted
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 */
class Articles extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_category', 'id_author', 'status', 'count_show_all', 'count_show', 'count_comments', 'id_deleted', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['title', 'text', 'alias'], 'required'],
            [['text', 'excerpt', 'image'], 'string'],
            [['mark'], 'number'],
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
            'id_category' => 'Id Category',
            'id_author' => 'Id Author',
            'title' => 'Title',
            'text' => 'Text',
            'excerpt' => 'Excerpt',
            'image' => 'Image',
            'alias' => 'Alias',
            'status' => 'Status',
            'count_show_all' => 'Count Show All',
            'count_show' => 'Count Show',
            'count_comments' => 'Count Comments',
            'mark' => 'Mark',
            'id_deleted' => 'Id Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    public function getAuthor(){
        return $this->hasOne(User::className(), ['id' => 'id_author']);
    }

    public function getCategory(){
        return $this->hasOne(Categories::className(), ['id' => 'id_category']);
    }

    /*
    public function getArticletag(){
        return $this->hasMany(ArticleTag::className(), ['id_article' => 'id']);
    }

    public function getArticleshow(){
        return $this->hasMany(ArticlesShow::className(), ['id_article' => 'id']);
    }

    public function getArticlemark(){
        return $this->hasMany(ArticleMark::className(), ['id_article' => 'id']);
    }

    public function getComments(){
        return $this->hasMany(Comments::className(), ['id_articles' => 'id']);
    }*/

    public static function count()
    {
        return Articles::find()
            ->where(['deleted_at' => NULL])
            ->count();
    }

    public static function getCountInCategory($category)
    {
        return Articles::find()
            ->where(['id_category' => $category])
            ->andWhere(['deleted_at' => NULL])
            ->count();
    }

    public static function issetAlias($alias, $articles){
        return Articles::find()
            ->where(['<>','id', $articles])
            ->andWhere(['alias' => $alias])
            ->andWhere(['deleted_at' => NULL])
            ->count();
    }

    public static function findArticle($alias){
        return Articles::find()
            ->where(['alias' => $alias])
            ->andWhere(['deleted_at' => NULL])
            ->one();
    }

    public static function findAllArticles(){
        return Articles::find()->all();
    }

    public static function findArticlesPage($offset = 1, $limit = 5){
        return Articles::find()
            ->limit($limit)
            ->offset($offset)
            ->orderBy(['id' => SORT_DESC])
            ->andWhere(['deleted_at' => NULL])
            ->all();
    }

    public static function findArticlesCategoryPage($category, $offset = 1, $limit = 5){
        return Articles::find()
            ->limit($limit)
            ->where(['id_category' => $category])
            ->offset($offset)
            ->orderBy(['id' => SORT_DESC])
            ->andWhere(['deleted_at' => NULL])
            ->all();
    }

    public static function countArticlesUncategorized(){
        return Articles::find()
            ->where(['id_category' => NULL])
            ->andWhere(['deleted_at' => NULL])
            ->count();
    }
}
