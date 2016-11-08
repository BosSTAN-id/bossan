<?php

namespace app\modules\controlhutang\controllers;

use Yii;
use app\models\TaValidasiPembayaran;
use app\modules\controlhutang\models\TaValidasiPembayaranSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * ValidasiController implements the CRUD actions for TaValidasiPembayaran model.
 */
class ValidasiController extends Controller
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
     * Lists all TaValidasiPembayaran models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new \app\modules\controlhutang\models\TaSPMSearch();
        $model = new TaValidasiPembayaran();        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $spm = NULL;
        $validasi = NULL;
        $sumspm = NULL;
        IF(Yii::$app->request->queryParams){
            IF(Yii::$app->request->queryParams['TaSPMSearch']['No_SPM'] <> NULL){
                $spm= $this->findSpm(Yii::$app->request->queryParams['TaSPMSearch']['No_SPM'], DATE('Y'));
                $sumspm = $this->sumSpm($spm->No_SPM, $spm->Tahun);
            }
            IF(TaValidasiPembayaran::findOne(['No_SPM' => $spm->No_SPM, 'Tahun' => $spm->Tahun]) <> NULL){
                $validasi = $this->findValidasi($spm->No_SPM, $spm->Tahun);
            }        
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->Tahun = $spm->Tahun;
            $model->Kd_Urusan = $spm->Kd_Urusan;
            $model->Kd_Bidang = $spm->Kd_Bidang;
            $model->Kd_Unit = $spm->Kd_Unit;
            $model->Kd_Sub = $spm->Kd_Sub;
            $model->No_SPM = $spm->No_SPM;
            IF($model->save()){
                return $this->redirect(['index', 'TaSPMSearch[kd_skpd]' => Yii::$app->request->queryParams['TaSPMSearch']['kd_skpd'], 'TaSPMSearch[No_SPM]' => Yii::$app->request->queryParams['TaSPMSearch']['No_SPM']]);
            }
        }        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'spm' => $spm,
            'validasi' => $validasi,
            'sumspm' => $sumspm
        ]);
    }

    /**
     * Displays a single TaValidasiPembayaran model.
     * @param integer $Kd_Bidang
     * @param integer $Kd_Sub
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param string $No_Validasi
     * @param integer $Tahun
     * @return mixed
     */
    public function actionView($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_Validasi, $Tahun)
    {
        return $this->render('view', [
            'model' => $this->findModel($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_Validasi, $Tahun),
        ]);
    }

    /**
     * Creates a new TaValidasiPembayaran model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TaValidasiPembayaran();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'No_Validasi' => $model->No_Validasi, 'Tahun' => $model->Tahun]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TaValidasiPembayaran model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $Kd_Bidang
     * @param integer $Kd_Sub
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param string $No_Validasi
     * @param integer $Tahun
     * @return mixed
     */
    public function actionUpdate($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_Validasi, $Tahun)
    {
        $model = $this->findModel($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_Validasi, $Tahun);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'No_Validasi' => $model->No_Validasi, 'Tahun' => $model->Tahun]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TaValidasiPembayaran model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $Kd_Bidang
     * @param integer $Kd_Sub
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param string $No_Validasi
     * @param integer $Tahun
     * @return mixed
     */
    public function actionDelete($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_Validasi, $Tahun)
    {
        $this->findModel($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_Validasi, $Tahun)->delete();

        return $this->redirect(['index']);
    }

    public function actionDepdrop()
    {
        $model = new \backend\models\Departments();
        if ($model->load(Yii::$app->request->post())) {
            $model->department_created_date = date('Y-m-d h:m:s');
            $model->save();
            return $this->redirect(['view', 'id' => $model->department_id]);
        } else {
            return $this->render('depdrop', [
                'model' => $model,
            ]);
        }
    }    

    public function actionSpm() {
        $out = [];
        
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
                if ($parents != null){
                    $cat_id = $parents[0];
                list($Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub,) = explode('.', $cat_id);
                //$hutang =
                    IF(Yii::$app->session->get('tahun')){
                        $tahun = Yii::$app->session->get('tahun');
                    }ELSE{
                        $tahun = DATE('Y');
                    }                 
                    $out = \app\models\TaSPM::find()
                            ->where([
                                     'tahun'    => $tahun,
                                     'Kd_Urusan'=> $Kd_Urusan,
                                     'Kd_Bidang'=> $Kd_Bidang,
                                     'Kd_Unit'=> $Kd_Unit,
                                     'Kd_Sub'=> $Kd_Sub,
                                     ])
                           ->select(['No_SPM AS id','No_SPM AS name'])->asArray()->all();
                           echo Json::encode(['output'=>$out, 'selected'=>'']);
                           return;
                }
        }
    }    

    /**
     * Finds the TaValidasiPembayaran model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $Kd_Bidang
     * @param integer $Kd_Sub
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param string $No_Validasi
     * @param integer $Tahun
     * @return TaValidasiPembayaran the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_Validasi, $Tahun)
    {
        if (($model = TaValidasiPembayaran::findOne(['Kd_Bidang' => $Kd_Bidang, 'Kd_Sub' => $Kd_Sub, 'Kd_Unit' => $Kd_Unit, 'Kd_Urusan' => $Kd_Urusan, 'No_Validasi' => $No_Validasi, 'Tahun' => $Tahun])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findSpm($No_SPM, $Tahun)
    {
        if (($model = \app\models\TaSPM::findOne(['No_SPM' => $No_SPM, 'Tahun' => $Tahun])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }    

    protected function sumSpm($No_SPM, $Tahun)
    {
        $model = \app\models\TaSPMRinc::find()
                    ->where([
                     'Tahun'    => $Tahun,
                     'No_SPM'=> $No_SPM,
                     ])
                    ->sum('Nilai');
        return $model;
    }        

    protected function findValidasi($No_SPM, $Tahun)
    {
        if (($model = TaValidasiPembayaran::findOne(['No_SPM' => $No_SPM, 'Tahun' => $Tahun])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }     
}
