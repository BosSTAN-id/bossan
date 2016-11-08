<?php

namespace app\modules\controlhutang\controllers;

use Yii;
use app\models\TaRPH;
use app\modules\controlhutang\models\TaRPHSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RphController implements the CRUD actions for TaRPH model.
 */
class RphController extends Controller
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
     * Lists all TaRPH models.
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

        $searchModel = new TaRPHSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TaRPH model.
     * @param integer $Kd_Bidang
     * @param integer $Kd_Sub
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param string $No_RPH
     * @param string $No_SPH
     * @param string $No_SPM
     * @param integer $Tahun
     * @return mixed
     */
    public function actionView($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_RPH, $No_SPH, $Tahun)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }       
        return $this->render('view', [
            'model' => $this->findModel($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_RPH, $No_SPH, $Tahun),
        ]);
    }

    public function actionRph($No_RPH)
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
        return $this->render('rph', [
            'model' => $this->findRph($No_RPH),
        ]);
    }  

    public function actionRekap()
    {
        return $this->render('rekap', [
            'model' => $this->findRekap(),
        ]);
    }  


    /**
     * Creates a new TaRPH model.
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
        $Kd_Urusan = Yii::$app->user->identity['Kd_Urusan'];
        $Kd_Bidang = Yii::$app->user->identity['Kd_Bidang'];
        $Kd_Unit = Yii::$app->user->identity['Kd_Unit'];
        $Kd_Sub = Yii::$app->user->identity['Kd_Sub'];

        $model = new TaRPH();
        $ttd = \app\models\TaSubUnit::findOne(['Tahun' => $Tahun, 'Kd_Urusan' => $Kd_Urusan, 'Kd_Bidang' => $Kd_Bidang, 'Kd_Unit' => $Kd_Unit, 'Kd_Sub' => $Kd_Sub]);
        $model->Tahun = $Tahun;    
        $model->Nm_Kepala_SKPD = $ttd['Nm_Pimpinan'];
        $model->NIP = $ttd['Nip_Pimpinan'];
        $model->Jabatan = $ttd['Jbt_Pimpinan'];       

        if ($model->load(Yii::$app->request->post())) {
            $model->Kd_Urusan =  Yii::$app->user->identity->Kd_Urusan;
            $model->Kd_Bidang =  Yii::$app->user->identity->Kd_Bidang;
            $model->Kd_Unit =  Yii::$app->user->identity->Kd_Unit;
            $model->Kd_Sub =  Yii::$app->user->identity->Kd_Sub;
            // var_dump($model);
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
                'Tahun' => $Tahun
            ]);
        }
    }

    /**
     * Updates an existing TaRPH model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $Kd_Bidang
     * @param integer $Kd_Sub
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param string $No_RPH
     * @param string $No_SPH
     * @param string $No_SPM
     * @param integer $Tahun
     * @return mixed
     */
    public function actionUpdate($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_RPH, $No_SPH, $Tahun)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $model = $this->findModel($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_RPH, $No_SPH, $Tahun);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'No_RPH' => $model->No_RPH, 'No_SPH' => $model->No_SPH, 'Tahun' => $model->Tahun]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TaRPH model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $Kd_Bidang
     * @param integer $Kd_Sub
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param string $No_RPH
     * @param string $No_SPH
     * @param string $No_SPM
     * @param integer $Tahun
     * @return mixed
     */
    public function actionDelete($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_RPH, $No_SPH, $Tahun)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $this->findModel($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_RPH, $No_SPH, $Tahun)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TaRPH model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $Kd_Bidang
     * @param integer $Kd_Sub
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param string $No_RPH
     * @param string $No_SPH
     * @param string $No_SPM
     * @param integer $Tahun
     * @return TaRPH the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_RPH, $No_SPH, $Tahun)
    {
        if (($model = TaRPH::findOne(['Kd_Bidang' => $Kd_Bidang, 'Kd_Sub' => $Kd_Sub, 'Kd_Unit' => $Kd_Unit, 'Kd_Urusan' => $Kd_Urusan, 'No_RPH' => $No_RPH, 'No_SPH' => $No_SPH, 'Tahun' => $Tahun])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findRph($No_RPH)
    {
        if (($model = TaRPH::findOne(['No_RPH' => $No_RPH])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }    

    protected function findRekap()
    {
        if (($model = TaRPH::find(['Kd_Urusan' => Yii::$app->user->identity->Kd_Urusan, 'Kd_Bidang' => Yii::$app->user->identity->Kd_Bidang, 'Kd_Unit' => Yii::$app->user->identity->Kd_Unit, 'Kd_Sub' => Yii::$app->user->identity->Kd_Sub])->all()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }      
    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 104])->one();
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
