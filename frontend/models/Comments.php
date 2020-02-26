<?php

namespace frontend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property int $id_owner
 * @property int $id_articles
 * @property int $id_comment
 * @property string $text
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Comments extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_owner', 'id_articles', 'text'], 'required'],
            [['id_owner', 'id_articles', 'id_comment', 'status', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_owner' => 'Id owner',
            'id_articles' => 'Id articles',
            'id_comment' => 'Parent comment',
            'text' => 'Text',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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

    public function getOwner(){
        return $this->hasOne(User::className(), ['id' => 'id_owner']);
    }

    public function getArticle(){
        return $this->hasOne(Articles::className(), ['id' => 'id_articles']);
    }

    public static function findComments($article){
        return Comments::find()
            ->where(['id_articles' => $article])
            ->orderBy(['id' => SORT_DESC])
            ->all();
    }

    public static function getCount(){
        return Comments::find()
            ->count();
    }

    public static function countCommentsArticle($article){
        return Comments::find()
            ->where(['id_articles' => $article])
            ->count();
    }

    public static function findChild($id){
        return Comments::find()
            ->where(['id_comment' => $id])
            ->all();
    }
}
