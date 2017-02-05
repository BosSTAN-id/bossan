<?php

namespace app\modules\management\controllers;

use Yii;
use app\models\TaPengumuman;
use app\modules\management\models\TaPengumumanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PengumumanController implements the CRUD actions for TaPengumuman model.
 */
class PengumumanController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all TaPengumuman models.
     * @return mixed
     */
    public function actionIndex()
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }    
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }

        $searchModel = new TaPengumumanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy('id DESC');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpload(){
        var_dump($_POST);
    }

    /**
     * Displays a single TaPengumuman model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }    
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TaPengumuman model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }    
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }

        $model = new TaPengumuman();
        $model->user_id = Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post())) {
            // var_dump($model->validate());
            IF($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
                'model' => $model,
            ]);        
    }

    /**
     * Updates an existing TaPengumuman model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }    
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }

        $model = $this->findModel($id);
        $model->user_id = Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TaPengumuman model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }    
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }
        
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TaPengumuman model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaPengumuman the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaPengumuman::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 106])->one();
            IF($akses){
                return true;
            }else{
                return false;
            }
        }ELSE{
            return false;
        }
    }     
}
