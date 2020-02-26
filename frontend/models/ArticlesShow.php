<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "articles_show".
 *
 * @property int $id
 * @property int $id_article
 * @property int $id_user
 * @property string $ip
 * @property int $created_at
 */
class ArticlesShow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articles_show';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_article'], 'required'],
            [['id_article', 'id_user', 'created_at'], 'integer'],
            [['ip'], 'string', 'max' => 255],
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
            'ip' => 'Ip',
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

    /**
     * increment show for article
     * @param object $model
     *
     * @return boolean
     */
    public static function incrementShow($model){
        $model->count_show_all++;

        if(Yii::$app->user->isGuest){
            $model_show = ArticlesShow::find()->where(['id_article' => $model->id])->andWhere(['ip' => Yii::$app->getRequest()->getUserIP()])->one();
        }else{
            $model_show = ArticlesShow::find()->where(['id_article' => $model->id])->andWhere(['id_user' => Yii::$app->user->getId()])->one();
        }

        if(!$model_show){
            $model_articles_show = new ArticlesShow();
            $model_articles_show->id_article = $model->id;
            if(Yii::$app->user->isGuest){
                $model_articles_show->ip = Yii::$app->getRequest()->getUserIP();
            }else{
                $model_articles_show->id_user = Yii::$app->user->getId();
            }
            if($model_articles_show->save()){
                $model->count_show++;
            }
        }

        $model->save();

        return true;
    }
}
