<?php

namespace app\modules\controlhutang\controllers;

use Yii;
use app\models\TaSPH;
use app\modules\controlhutang\models\TaSPHSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SphController implements the CRUD actions for TaSPH model.
 */
class SphController extends Controller
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
     * Lists all TaSPH models.
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
        $searchModel = new TaSPHSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['Tahun' => ($Tahun-1)]);       

        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);
        // for modals
        $Kd_Urusan = Yii::$app->user->identity['Kd_Urusan'];
        $Kd_Bidang = Yii::$app->user->identity['Kd_Bidang'];
        $Kd_Unit = Yii::$app->user->identity['Kd_Unit'];
        $Kd_Sub = Yii::$app->user->identity['Kd_Sub'];
        $ttd = \app\models\TaSubUnit::findOne(['Tahun' => $Tahun, 'Kd_Urusan' => $Kd_Urusan, 'Kd_Bidang' => $Kd_Bidang, 'Kd_Unit' => $Kd_Unit, 'Kd_Sub' => $Kd_Sub]);        
        $model = new TaSPH();
        $model->Nm_Kepala_SKPD = $ttd['Nm_Pimpinan'];
        $model->NIP = $ttd['Nip_Pimpinan'];
        $model->Jabatan = $ttd['Jbt_Pimpinan'];
        $model->Alamat = $ttd['Alamat'];

        if ($model->load(Yii::$app->request->post())) {
            $model->Tahun = $Tahun - 1;
            $model->Kd_Urusan =  Yii::$app->user->identity->Kd_Urusan;
            $model->Kd_Bidang =  Yii::$app->user->identity->Kd_Bidang;
            $model->Kd_Unit =  Yii::$app->user->identity->Kd_Unit;
            $model->Kd_Sub =  Yii::$app->user->identity->Kd_Sub;
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->render('index', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,                
            ]);
        }        
    }

    /**
     * Displays a single TaSPH model.
     * @param integer $Kd_Bidang
     * @param integer $Kd_Sub
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param string $No_SPH
     * @param integer $Tahun
     * @return mixed
     */
    public function actionView($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_SPH, $Tahun)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->render('view', [
            'model' => $this->findModel($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_SPH, $Tahun),
        ]);
    }

    public function actionSph($No_SPH)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $model = $this->findSph($No_SPH);

        $Tahun = $model->Tahun;
        $Kd_Urusan = $model->Kd_Urusan;
        $Kd_Bidang = $model->Kd_Bidang;
        $Kd_Unit = $model->Kd_Unit;
        $Kd_Sub = $model->Kd_Sub;
        $ttd = \app\models\TaSubUnit::findOne(['Tahun' => $Tahun, 'Kd_Urusan' => $Kd_Urusan, 'Kd_Bidang' => $Kd_Bidang, 'Kd_Unit' => $Kd_Unit, 'Kd_Sub' => $Kd_Sub]);

        return $this->render('sph', [
            'model' => $model,
            'ttd' => $ttd
        ]);
    }  

    public function actionRekap()
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
        $ttd = \app\models\TaSubUnit::findOne(['Tahun' => $Tahun, 'Kd_Urusan' => $Kd_Urusan, 'Kd_Bidang' => $Kd_Bidang, 'Kd_Unit' => $Kd_Unit, 'Kd_Sub' => $Kd_Sub]);

        return $this->render('rekap', [
            'model' => $this->findRekap(),
            'ttd' => $ttd
        ]);
    }         

    /**
     * Creates a new TaSPH model.
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
        $ttd = \app\models\TaSubUnit::findOne(['Tahun' => $Tahun, 'Kd_Urusan' => $Kd_Urusan, 'Kd_Bidang' => $Kd_Bidang, 'Kd_Unit' => $Kd_Unit, 'Kd_Sub' => $Kd_Sub]);        
        $model = new TaSPH();
        $model->Nm_Kepala_SKPD = $ttd['Nm_Pimpinan'];
        $model->NIP = $ttd['Nip_Pimpinan'];
        $model->Jabatan = $ttd['Jbt_Pimpinan'];
        $model->Alamat = $ttd['Alamat'];

        if ($model->load(Yii::$app->request->post())) {
            $model->Tahun = $Tahun - 1;
            $model->Kd_Urusan =  Yii::$app->user->identity->Kd_Urusan;
            $model->Kd_Bidang =  Yii::$app->user->identity->Kd_Bidang;
            $model->Kd_Unit =  Yii::$app->user->identity->Kd_Unit;
            $model->Kd_Sub =  Yii::$app->user->identity->Kd_Sub;
            $model->Saldo = $model->Nilai;
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
     * Updates an existing TaSPH model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $Kd_Bidang
     * @param integer $Kd_Sub
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param string $No_SPH
     * @param integer $Tahun
     * @return mixed
     */
    public function actionUpdate($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_SPH, $Tahun)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $model = $this->findModel($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_SPH, $Tahun);
        if ($model->load(Yii::$app->request->post())) {
            $model->Saldo = $model->Nilai;
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
     * Deletes an existing TaSPH model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $Kd_Bidang
     * @param integer $Kd_Sub
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param string $No_SPH
     * @param integer $Tahun
     * @return mixed
     */
    public function actionDelete($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_SPH, $Tahun)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $this->findModel($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_SPH, $Tahun)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the TaSPH model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $Kd_Bidang
     * @param integer $Kd_Sub
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param string $No_SPH
     * @param integer $Tahun
     * @return TaSPH the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_SPH, $Tahun)
    {
        if (($model = TaSPH::findOne(['Kd_Bidang' => $Kd_Bidang, 'Kd_Sub' => $Kd_Sub, 'Kd_Unit' => $Kd_Unit, 'Kd_Urusan' => $Kd_Urusan, 'No_SPH' => $No_SPH, 'Tahun' => $Tahun])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findSph($No_SPH)
    {
        if (($model = TaSPH::findOne(['No_SPH' => $No_SPH])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }    

    protected function findRekap()
    {
        if (($model = TaSPH::find()
            ->where([
                                 'tahun'    => DATE('Y'),
                                 'Kd_Urusan'=> Yii::$app->user->identity->Kd_Urusan,
                                 'Kd_Bidang'=> Yii::$app->user->identity->Kd_Bidang,
                                 'Kd_Unit'=> Yii::$app->user->identity->Kd_Unit,
                                 'Kd_Sub'=> Yii::$app->user->identity->Kd_Sub,
                                 ])
            ->all()) !== null) {
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
