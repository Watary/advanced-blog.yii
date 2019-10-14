<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_mark".
 *
 * @property int $id
 * @property int $id_article
 * @property int $id_user
 * @property int $mark
 * @property int $created_at
 */
class ArticleMark extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_mark';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_article', 'id_user', 'mark'], 'required'],
            [['id_article', 'id_user', 'mark', 'created_at'], 'integer'],
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
            'id_user' => 'Id User',
            'mark' => 'Mark',
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

    public static function issetMark($article, $user){
        return ArticleMark::find()->where(['id_article' => $article, 'id_user' => $user])->count();
    }
}
