<?php

namespace backend\controllers;

use backend\models\Articles;
use backend\models\ArticleTag;
use backend\models\Tags;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * TagsController implements the CRUD actions for Tags model.
 */
class TagsController extends Controller
{
    public $count_show_for_page = 5;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Tags models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tags::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Categories model.
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $model = Tags::findOne($id);

        $dataProvider = new ActiveDataProvider([
            'query' => $model->getArticles(),
            'sort' => ['attributes' => ['countArticle']],
        ]);

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Tags model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tags();

        if ($model->load(Yii::$app->request->post())){

            $model->id_owner = Yii::$app->user->getId();
            if($model->description == ''){
                $model->description = NULL;
            }

            if($model->save()) {
                return $this->redirect(['/tags/update/'.$model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tags model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $isSave = false;

        if ($model->load(Yii::$app->request->post())) {
            if($model->description == ''){
                $model->description = NULL;
            }

            if($model->save()) {
                $isSave = true;
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tags model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tags model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tags the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tags::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * (Ajax) Generate url for tag
     *
     * @return string
     */
    public function actionGenerateAlias(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            Yii::$app->response->format = Response::FORMAT_JSON;

            return Tags::generateAlias($data['title'], $data['tag']);
        }
    }
}
