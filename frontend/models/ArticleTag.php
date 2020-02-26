<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "article_tag".
 *
 * @property int $id
 * @property int $id_article
 * @property int $id_tag
 * @property int $created_at
 */
class ArticleTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_article', 'id_tag'], 'required'],
            [['id_article', 'id_tag', 'created_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_article' => 'Id Article',
            'id_tag' => 'Id Tag',
            'created_at' => 'Created At',
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
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    public function getTag(){
        return $this->hasOne(Tags::className(), ['id' => 'id_tag']);
    }

    public function getArticle(){
        return $this->hasMany(Articles::className(), ['id' => 'id_article']);
    }

    public static function findAllTagsFotArticle($id_article){
        return ArticleTag::find()->where(['id_article' => $id_article])->all();
    }

    public static function getCountInTag($tag)
    {
        return ArticleTag::find()->where(['id_tag' => $tag])->count();
    }

    public static function findArticlesTagPage($tag, $offset = 1, $limit = 5){
        return ArticleTag::find()
            ->limit($limit)
            ->where(['id_tag' => $tag])
            ->offset($offset)
            ->orderBy(['id' => SORT_DESC])
            ->all();
    }
}
