<?php

namespace backend\controllers;

use backend\models\Articles;
use backend\models\Comments;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * CommentsController implements the CRUD actions for Comments model.
 */
class CommentsController extends Controller
{
    private $list_comments = [];

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
     * Lists all Comments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Comments::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Comments model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Comments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Comments();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Comments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BlogComments model.
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

    public function actionSave()
    {
        $request = \Yii::$app->getRequest();
        $data = Yii::$app->request->post();
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new Comments();

        if ($request->isPost && $model->load($request->post())) {
            $model->id_owner = Yii::$app->user->getId();
            $model->id_articles = $data['article'];
            $model->id_comment = $data['id_comment'];
            if($model->save()){
                $article = Articles::findOne($data['article']);
                $article->count_comments = Comments::countCommentsArticle($article->id);
                $article->save();
                return ['success' => $model];
            }
        }
    }

    public function actionFindComments(){
        if (Yii::$app->request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            $data = Yii::$app->request->post();

            $list_comments = Comments::findComments($data['article']);

            $comments = $this->constructCommentList($list_comments, NULL, 0);

            return [
                'list_comments' => $comments,
            ];
            if ($comments) {
                return [
                    'list_comments' => $comments,
                ];
            }else {
                return [
                    'list_comments' => false,
                ];
            }
        }

        return false;
    }

    public function actionShowForm(){
        if (Yii::$app->request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->post();

            /*$list_comments = BlogComments::findComments($data['article']);
            $list_comments = BlogComments::findComments($data['id_comment']);*/



            if (1) {
                return $this->renderAjax('_form_comments', [
                    'id_articles' => $data['article'],
                ]);
            }else {
                return [
                    'message' => 'false',
                ];
            }
        }

        return false;
    }

    private function constructCommentList($list_comments, $id_parent, $level){
        $result = '';
        foreach ($list_comments as $key => $comment) {
            if($comment->id_comment == $id_parent) {
                $result .= '
                    <div class="widget-content media-comments" id="comment-' . $comment->id . '" style="padding-left: '. ($level*30) .'px">
                        <span class="comment-doter" style="width: '. ($level*20) .'px"></span>
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="widget-content-left">
                                    <img class="rounded-circle" src="#" alt="" width="40">
                                </div>
                            </div>
                            <div class="widget-content-left flex2">
                                <div class="widget-heading">
                                    <a href="'.Url::to('profile/'.$comment->owner->id, true).'">' . $comment->owner->username . '</a>
                                    <span class="mb-2 mr-2 badge badge-pill badge-secondary"> ' . date("d.m.Y H:i:s", (integer)$comment->created_at) . '</span>
                                    <button type="button" onclick="showFormComment(' . $comment->id . ')" class="mb-2 mr-2 badge badge-pill badge-secondary">Відповісти</button>
                                </div>
                                <div class="widget-subheading opacity-7">' . $comment->text . '</div>
                            </div>
                        </div>
                        <div id="answer-' . $comment->id . '" style="display: block;width: 100%"></div>
                    </div><div></div>';
                $result .= $this->constructCommentList($list_comments, $comment->id, $level+1);
            }
        }
        return $result;
    }

    /**
     * Finds the Comments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
