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
            'query' => Comments::find()
                ->where(['<>', 'status', Comments::STATUS_DELETE]),
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
     * @throws NotFoundHttpException permissionCreateComments
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->can('permissionCreateComments')){
            throw new NotFoundHttpException('Access denied');
        }

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
     * @throws NotFoundHttpException permissionUpdateComments
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->user->can('permissionUpdateComments')){
            throw new NotFoundHttpException('Access denied');
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Comments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws NotFoundHttpException permissionRemoveComments
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->user->can('permissionRemoveComments')){
            throw new NotFoundHttpException('Access denied');
        }

        /* Full delete comments
         * $model = $this->findModel($id);

        if($this->deleteChild($model->id)){
            $model->delete();
        }*/

        $this->changeStatus($id);

        return $this->redirect(['/comments']);
    }

    /**
     * @throws NotFoundHttpException permissionCreateComments
     * @return mixed
     */
    public function actionSave()
    {
        if(!Yii::$app->user->can('permissionCreateComments')){
            throw new NotFoundHttpException('Access denied');
        }

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

        return false;
    }

    public function actionFindComments(){
        if (Yii::$app->request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            $data = Yii::$app->request->post();

            $list_comments = Comments::findComments($data['article']);

            $comments = $this->constructCommentList($list_comments, NULL, 0);

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

    /**
     * @return mixed
     * @throws NotFoundHttpException permissionDeleteComments
     */
    public function actionChangeStatus(){

        if(!Yii::$app->user->can('permissionChangeStatusComments')){
            throw new NotFoundHttpException('Access denied');
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $data = Yii::$app->request->post();

            $comment = Comments::findOne($data['id_comment']);

            if($comment->status == Comments::STATUS_ACTIVE){
                $comment->status = Comments::STATUS_INACTIVE;
            }else{
                $comment->status = Comments::STATUS_ACTIVE;
            }

            if($comment->save()){
                if($comment->status == Comments::STATUS_ACTIVE) {
                    return [
                        'status' => 'active',
                        'updated_at' => date('d-m-Y H:i:s', $comment->updated_at),
                    ];
                }else{
                    return [
                        'status' => 'inactive',
                        'updated_at' => date('d-m-Y H:i:s', $comment->updated_at),
                    ];
                }
            }else{
                return false;
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

    private function deleteChild($id){
        if(!Yii::$app->user->can('permissionRemoveComments')){
            return false;
        }

        $list = Comments::findChild($id);

        foreach ($list as $item){
            $this->deleteChild($item->id);
            $this->findModel($item->id)->delete();
        }

        return true;
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
/**********************************************************************************************************************/
    /**
     * @param $id integer
     * @param $status integer
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    private function changeStatus($id, $status = Comments::STATUS_DELETE){
        if($model = Comments::findCommentForId($id)){

            $model->status = $status;

            if($model->save()){
                $list = Comments::findChild($id);

                foreach ($list as $item){
                    $this->changeStatus($item->id, $status);
                }
            }
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return true;
    }

    /**
     * @param $id integer
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    private static function deleteComment($id){
        if($model = Comments::findCommentForId($id)){
            $model->status = Comments::STATUS_DELETE;
            if($model->save()){
                return true;
            }
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return false;
    }

    public static function deleteInArticle($category){
        $list = Comments::findAllCommentsInArticle($category);
        foreach ($list as $item){
            CommentsController::deleteComment($item->id);
        }
    }
}
