<?php

namespace app\modules\penatausahaan\controllers;

use Yii;
use app\models\TaSaldoAwalPotongan;
use app\modules\penatausahaan\models\TaSaldoAwalPotonganSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SaldoawalpotonganController implements the CRUD actions for TaSaldoAwalPotongan model.
 */
class SaldoawalpotonganController extends Controller
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
     * Lists all TaSaldoAwalPotongan models.
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
        $searchModel = new TaSaldoAwalPotonganSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tahun' => $Tahun, 'sekolah_id' => Yii::$app->user->identity->sekolah_id]);        

        return $this->renderAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }

    /**
     * Displays a single TaSaldoAwalPotongan model.
     * @param string $tahun
     * @param integer $sekolah_id
     * @param integer $kd_potongan
     * @return mixed
     */
    public function actionView($tahun, $sekolah_id, $kd_potongan)
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
        return $this->renderAjax('view', [
            'model' => $this->findModel($tahun, $sekolah_id, $kd_potongan),
        ]);
    }

    /**
     * Creates a new TaSaldoAwalPotongan model.
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

        $model = new TaSaldoAwalPotongan();
        $model->tahun = $Tahun;
        $model->sekolah_id = Yii::$app->user->identity->sekolah_id;        

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TaSaldoAwalPotongan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $tahun
     * @param integer $sekolah_id
     * @param integer $kd_potongan
     * @return mixed
     */
    public function actionUpdate($tahun, $sekolah_id, $kd_potongan)
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

        $model = $this->findModel($tahun, $sekolah_id, $kd_potongan);

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TaSaldoAwalPotongan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $tahun
     * @param integer $sekolah_id
     * @param integer $kd_potongan
     * @return mixed
     */
    public function actionDelete($tahun, $sekolah_id, $kd_potongan)
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

        $this->findModel($tahun, $sekolah_id, $kd_potongan)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the TaSaldoAwalPotongan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $tahun
     * @param integer $sekolah_id
     * @param integer $kd_potongan
     * @return TaSaldoAwalPotongan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($tahun, $sekolah_id, $kd_potongan)
    {
        if (($model = TaSaldoAwalPotongan::findOne(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'kd_potongan' => $kd_potongan])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 507])->one();
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
