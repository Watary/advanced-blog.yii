<?php

namespace backend\controllers;

/*use app\modules\blog\models\BlogArticleMark;
use app\modules\blog\models\BlogArticlesShow;
use app\modules\blog\models\BlogTags;*/
use backend\models\Articles;
use backend\models\Categories;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ArticlesController implements the CRUD actions for BlogArticles model.
 */
class ArticlesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST', 'GET'],
                ],
            ],
        ];
    }
    /**
     * Lists all Articles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Articles::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Articles model.
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if($model){
            //$this->incrementShow($model);
        }

        return $this->render('view', [
            'model' => $model,
            //'isMark' => ArticleMark::issetMark($model->id, Yii::$app->user->getId()),
        ]);
    }

    /**
     * Creates a new Articles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Articles();

        if ($model->load(Yii::$app->request->post())) {
            $date_post = Yii::$app->request->post();

            $model->id_author = Yii::$app->user->getId();
            $model->alias = $this->generateAlias($model->alias, $model->id);

            if($model->save()){
                //Tags::saveTags($date_post['Articles']['tags'], $model->id);
                return $this->redirect('update/' . $model->id);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'items_categories' => Categories::findListCategories(),
            //'items_tags' => Tags::findListTags(),
        ]);
    }

    /**
     * Updates an existing Articles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $isSave = false;

        if ($model->load(Yii::$app->request->post())) {
            $date_post = Yii::$app->request->post();

            if(!$model->alias){
                $model->alias = $model->title;
            }

            //Tags::saveTags($date_post['Articles']['tags'], $model->id);
            $model->alias = $this->generateAlias($model->alias, $model->id);

            if($model->save()) {
                $isSave = true;
            }
        }

        //$model->tags = $this->setTags($model);

        return $this->render('update', [
            'model' => $model,
            'items_categories' => Categories::findListCategories(),
            //'items_tags' => Tags::findListTags(),
        ]);
    }

    /**
     * Delete an existing BlogArticles model.
     * If delete is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @throws NotFoundHttpException if the model cannot be found

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/blog']);
    }*/

    /**
     * Finds the Articles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     *
     * @return Articles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Articles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * (Ajax) Generate url for article
     *
     * @return string
     */
    public function actionGenerateAlias(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            Yii::$app->response->format = Response::FORMAT_JSON;

            $url = $this->generateAlias($data['url'], $data['article']);

            return $url;
        }

        return false;
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

            $model_article = $this->findModel($data['article']);

            $old_marks = $model_article->articlemark;
            $mark_sum = 0;
            $mark_count = 0;

            foreach ($old_marks as $item){
                $mark_sum += $item->mark;
                $mark_count++;
            }

            $model_article->mark = $mark_sum / $mark_count;
            $model_article->save();

            return $mark_sum / $mark_count;
        }

        return false;
    }

    /**
     * Set tags for article
     * @param object $model
     *
     * @return array
     */
    private function setTags($model){
        $tags_list = [];

        foreach ($model->articletag as $item){
            $tags_list[] = $item->id_tag;
        }

        return $tags_list;
    }

    /**
     * increment show for article
     * @param object $model
     *
     * @return boolean
     */
    private function incrementShow($model){
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

    private function issetAlias($alias, $articles){

        for(;;) {
            if (Articles::issetAlias($alias, $articles)) {
                $alias .= '-new';
            }else{
                break;
            }
        }

        return $alias;
    }

    private function generateAlias($alias, $articles){
        $rus=array('А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',' ','і','ї',',');
        $lat=array('a','b','v','g','d','e','e','gh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sch','y','y','y','e','yu','ya','a','b','v','g','d','e','e','gh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sch','y','y','y','e','yu','ya',' ','i','i','');

        $alias= preg_replace("/  +/"," ",$alias);

        $alias = str_replace($rus, $lat, $alias);

        $alias = str_replace(' ', '-', trim(strtolower($alias)));

        $alias = str_replace([':',';','.',',','<','>','?','#','%'], "", $alias);

        return $this->issetAlias($alias, $articles);
    }
}
