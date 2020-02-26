<?php
namespace frontend\controllers;

use frontend\models\ArticleMark;
use frontend\models\Articles;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class ArticlesController extends Controller{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($alias){
        $model = $this->findModel($alias);

        return $this->render('article', [
            'article' => $model,
            'isMark' => ArticleMark::issetMark($model->id, Yii::$app->user->getId()),
        ]);
    }

    /**
     * Finds the Articles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $alias
     *
     * @return Articles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($alias)
    {
        if (($model = Articles::findArticle($alias)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * (Ajax) set mark for article
     *
     * @return integer
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionSetMark(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            Yii::$app->response->format = Response::FORMAT_JSON;

            if($data['mark'] > 10 || $data['mark'] < 1) false;

            if(ArticleMark::issetMark($data['article'], Yii::$app->user->getId())) return 'Mark isset';

            $model_mark = new ArticleMark();
            $model_mark->id_article = $data['article'];
            $model_mark->id_user = Yii::$app->user->getId();
            $model_mark->mark = $data['mark'];

            $model_mark->save();

            $model_article = Articles::findArticleForId($data['article']);

            $old_marks = $model_article->articlemark;
            $mark_sum = 0;
            $mark_count = 0;

            foreach ($old_marks as $item){
                $mark_sum += $item->mark;
                $mark_count++;
            }

            $model_article->mark = $mark_sum / $mark_count;
            $model_article->save();

            return $model_article->mark;
        }

        return false;
    }

}