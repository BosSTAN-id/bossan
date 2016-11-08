<?php

namespace app\modules\controltransfer\controllers;

use Yii;
use app\models\TaValidasiPembayaran;
use app\modules\controltransfer\models\TaValidasiPembayaranSearch;
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

        $searchModel = new \app\modules\controltransfer\models\TaSPMSearch();
        $model = new TaValidasiPembayaran();        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $spm = NULL;
        $validasi = NULL;
        $sumspm = NULL;
        IF(Yii::$app->request->queryParams){
            IF(Yii::$app->request->queryParams['TaSPMSearch']['No_SPM'] <> NULL){
                $spm= $this->findSpm(Yii::$app->request->queryParams['TaSPMSearch']['No_SPM'], $Tahun);
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

            IF($model->transfer){
                list($model->Kd_Trans_1, $model->Kd_Trans_2, $model->Kd_Trans_3, $kd_urusan, $kd_bidang, $kd_unit, $kd_sub) = explode('.', $model->transfer);
                $trf = new \app\models\TaTransSts();
                $trf->Tahun = $model->Tahun;
                $trf->Kd_Trans_1 = $model->Kd_Trans_1;
                $trf->Kd_Trans_2 = $model->Kd_Trans_2;
                $trf->Kd_Trans_3 = $model->Kd_Trans_3;
                $trf->No_STS = $model->No_Validasi;
                $trf->Tgl_STS = $model->Tgl_Validasi;
                $trf->Nilai = $sumspm;
                $trf->Rek_Penerima = '-';
                $trf->Bank_Penerima = '-';
                $trf->D_K = 2;
                $trf->save();
            }
            IF($model->save()){
                IF($model->No_RPH <> NULL) {
                    $rph = \app\models\TaRPH::findOne(['No_RPH' => $model->No_RPH]);
                    $rph->No_SPM = $model->No_SPM;
                    $rph->save();
                    $sph = \app\models\TaSPH::findOne(['No_SPH' => $rph->No_SPH]);
                    $sph->Saldo = ($sph->Saldo - $rph->Nilai_Bayar);
                    $sph->save();
                }                
                return $this->redirect(['index', 'TaSPMSearch[kd_skpd]' => Yii::$app->request->queryParams['TaSPMSearch']['kd_skpd'], 'TaSPMSearch[No_SPM]' => Yii::$app->request->queryParams['TaSPMSearch']['No_SPM']]);
            }
        }        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'spm' => $spm,
            'validasi' => $validasi,
            'sumspm' => $sumspm,
            'Tahun' => $Tahun
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

    public function actionLoad()
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
        //need to surpassed allowed memory size first
        ini_set('memory_limit', '-1');

        $model = \app\models\TaTh::find()->where(['tahun' => $Tahun])->one();
        try {
            $hostname = \app\models\TaTh::dokudoku('bulat', $model->set_2);
            //$port = 10060;
            $dbname = \app\models\TaTh::dokudoku('bulat', $model->set_7);
            $username = \app\models\TaTh::dokudoku('bulat', $model->set_3);
            $pw = \app\models\TaTh::dokudoku('bulat', $model->set_1);
            // $dbh = new PDO ("dblib:host=$hostname;dbname=$dbname","$username","$pw"); //for linux user
            $dbh = new \PDO("sqlsrv:Server=$hostname;Database=$dbname", $username , $pw); //for windows
            // $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            return "Gagal menyambung ke database Keuangan: " . $e->getMessage() . "\n" . "Periksa Kembali Setting Server Keuangan anda";
            // exit;
        }

        //mulai mengambil data
                //SPP---------------------------------------
                //prepare log batch process
                $log = new \app\models\TaBatchProcess();
                $log->Tahun = $model->tahun;
                $log->tabel_id = 13;
                $log->kd_perubahan = 0;
                $log->mulai_pada = date("Y-m-d H:i:s");

                //delete current record  
                \app\models\TaSppKontrak::deleteAll(['Tahun' => $model->tahun]);
                \app\models\TaSpp::deleteAll(['Tahun' => $model->tahun]);

                //prepare data to insert
                $stmt = $dbh->prepare("SELECT * FROM Ta_SPP WHERE Tahun =".$model->tahun);
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $refspp[] = [$row['Tahun'], $row['No_SPP'], $row['Kd_Urusan'], $row['Kd_Bidang'], $row['Kd_Unit'], $row['Kd_Sub'], $row['No_SPD'], $row['Jn_SPP'], $row['Tgl_SPP'], $row['Uraian'], $row['No_SPJ'], $row['Kd_Edit'], $row['Nm_Penerima'], $row['Alamat_Penerima'], $row['Bank_Penerima'], $row['Rek_Penerima'], $row['NPWP'], $row['Nama_PPTK'], $row['NIP_PPTK'], $row['No_Tagihan'], $row['Tgl_Tagihan'], $row['Jns_Tagihan'], $row['Realisasi_Fisik'], $row['Ur_Tagihan']];
                }
                $stmt = $dbh->prepare("SELECT * FROM Ta_SPP_Kontrak WHERE Tahun =".$model->tahun);
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $refsppkontrak[] = [$row['Tahun'], $row['No_SPP'], $row['No_Kontrak'], $row['Nama'], $row['Bentuk'], $row['Alamat'], $row['Nm_Pimpinan'], $row['Nm_Bank'], $row['No_Rekening'], $row['Keperluan'], $row['Tgl_Kontrak'], $row['Waktu'], $row['NPWP'], $row['Nilai'], $row['No_Addendum']];
                }

                //prepare insert operation
                $spp = new \app\models\TaSpp();
                $sppkontrak = new \app\models\TaSppKontrak();
                IF($refspp && $refsppkontrak){
                    try {
                        Yii::$app->db->createCommand()->batchInsert(\app\models\TaSpp::tableName(), $spp->attributes(), $refspp)->execute();
                        Yii::$app->db->createCommand()->batchInsert(\app\models\TaSppKontrak::tableName(), $sppkontrak->attributes(), $refsppkontrak)->execute();
                    } catch (Exception $e) {
                        return $e->getMessage();
                    }
                        $log->row = COUNT($refspp) + COUNT($refsppkontrak);
                        $log->sukses_pada = date("Y-m-d H:i:s");
                        $log->user_id = Yii::$app->user->identity->id;
                        $log->save();
                }
                unset($stmt); 


                //SPM---------------------------------------
                //prepare log batch process
                $log = new \app\models\TaBatchProcess();
                $log->Tahun = $model->tahun;
                $log->tabel_id = 14;
                $log->kd_perubahan = 0;
                $log->mulai_pada = date("Y-m-d H:i:s");

                //delete current record  
                \app\models\TaSPMRinc::deleteAll(['Tahun' => $model->tahun]);
                \app\models\TaSPM::deleteAll(['Tahun' => $model->tahun]);

                //prepare data to insert
                $stmt = $dbh->prepare("SELECT * FROM Ta_SPM WHERE Tahun =".$model->tahun);
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $refspm[] = [$row['Tahun'], $row['No_SPM'], $row['Kd_Urusan'], $row['Kd_Bidang'], $row['Kd_Unit'], $row['Kd_Sub'], $row['No_SPP'], $row['Jn_SPM'], $row['Tgl_SPM'], $row['Uraian'], $row['Nm_Penerima'], $row['Bank_Penerima'], $row['Rek_Penerima'], $row['NPWP'], $row['Bank_Pembayar'], $row['Nm_Verifikator'], $row['Nm_Penandatangan'], $row['Nip_Penandatangan'], $row['Jbt_Penandatangan'], $row['Kd_Edit']];
                }
                $stmt = $dbh->prepare("SELECT * FROM Ta_SPM_Rinc WHERE Tahun =".$model->tahun);
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $refspmrinc[] = [$row['Tahun'], $row['No_SPM'], $row['No_ID'], $row['Kd_Urusan'], $row['Kd_Bidang'], $row['Kd_Unit'], $row['Kd_Sub'], $row['Kd_Prog'], $row['ID_Prog'], $row['Kd_Keg'], $row['Kd_Rek_1'], $row['Kd_Rek_2'], $row['Kd_Rek_3'], $row['Kd_Rek_4'], $row['Kd_Rek_5'], $row['Nilai']];
                }

                //prepare insert operation
                $spm = new \app\models\TaSPM();
                $spmrinc = new \app\models\TaSPMRinc();
                IF($refspm && $refspmrinc){
                    try {
                        Yii::$app->db->createCommand()->batchInsert(\app\models\TaSPM::tableName(), $spm->attributes(), $refspm)->execute();
                        Yii::$app->db->createCommand()->batchInsert(\app\models\TaSPMRinc::tableName(), $spmrinc->attributes(), $refspmrinc)->execute();
                    } catch (Exception $e) {
                        return $e->getMessage();
                    }
                        $log->row = COUNT($refspm) + COUNT($refspmrinc);
                        $log->sukses_pada = date("Y-m-d H:i:s");
                        $log->user_id = Yii::$app->user->identity->id;
                        $log->save();
                }
                unset($stmt);                                

                // SP2D---------------------------------------
                //prepare log batch process
                $log = new \app\models\TaBatchProcess();
                $log->Tahun = $model->tahun;
                $log->tabel_id = 15;
                $log->kd_perubahan = 0;
                $log->mulai_pada = date("Y-m-d H:i:s");

                //delete current record  
                \app\models\TaSp2d::deleteAll(['Tahun' => $model->tahun]);
                //prepare loaded data
                $stmt = $dbh->prepare("SELECT * FROM Ta_SP2D WHERE Tahun = ".$model->tahun);
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $data[] = [$row['Tahun'], $row['No_SP2D'], $row['No_SPM'], $row['Tgl_SP2D'], $row['Kd_Bank'], $row['No_BKU'], $row['Nm_Penandatangan'], $row['Nip_Penandatangan'], $row['Jbt_Penandatangan'], $row['Keterangan']];
                }
                
                $tabel = new \app\models\TaSp2d();
                IF($data){
                    $proses = Yii::$app->db->createCommand()->batchInsert(\app\models\TaSp2d::tableName(), $tabel->attributes(), $data);
                    IF($proses->execute()){
                        $log->row = COUNT($data);
                        $log->sukses_pada = date("Y-m-d H:i:s");
                        $log->user_id = Yii::$app->user->identity->id;
                        IF($log->save())
                            return 'Load Data Berhasil!';
                    }
                }
                unset($stmt);                  
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

    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 208])->one();
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
