<?php

namespace app\modules\management\controllers;

use Yii;
use app\models\TaTh;
use app\modules\management\models\TaThSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SettingController implements the CRUD actions for TaTh model.
 */
class SettingController extends Controller
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
     * Lists all TaTh models.
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
        $searchModel = new TaThSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }

    /**
     * Displays a single TaTh model.
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

        $model = $this->findModel($id);
                try {
                    $hostname = \app\models\TaTh::dokudoku('bulat', $model->set_2);
                    //$port = 10060;
                    $dbname = \app\models\TaTh::dokudoku('bulat', $model->set_7);
                    $username = \app\models\TaTh::dokudoku('bulat', $model->set_3);
                    $pw = \app\models\TaTh::dokudoku('bulat', $model->set_1);
                    // $dbh = new PDO ("dblib:host=$hostname;dbname=$dbname","$username","$pw"); //for linux user
                    $dbh = new \PDO("sqlsrv:Server=$hostname;Database=$dbname", $username , $pw); //for windows
                } catch (PDOException $e) {
                    echo "Gagal menyambung ke database Keuangan: " . $e->getMessage() . "\n";
                    echo "Periksa Kembali Setting Server Keuangan anda";
                    exit;
                }

                try {
                    $hostname = \app\models\TaTh::dokudoku('bulat', $model->set_4);
                    //$port = 10060;
                    $dbname = \app\models\TaTh::dokudoku('bulat', $model->set_8);
                    $username = \app\models\TaTh::dokudoku('bulat', $model->set_6);
                    $pw = \app\models\TaTh::dokudoku('bulat', $model->set_5);
                    // $dbh = new PDO ("dblib:host=$hostname;dbname=$dbname","$username","$pw"); //for linux user
                    $dbh = new \PDO("sqlsrv:Server=$hostname;Database=$dbname", $username , $pw); //for windows
                } catch (PDOException $e) {
                    echo "Gagal menyambung ke database BMD: " . $e->getMessage() . "\n";
                    echo "Periksa Kembali Setting Server BMD anda";                    
                    exit;
                } 
           
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TaTh model.
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

        $model = new TaTh();

        if ($model->load(Yii::$app->request->post())) {
            $model->set_1 = \app\models\TaTh::dokudoku('donat', $model->set_1);
            $model->set_2 = \app\models\TaTh::dokudoku('donat', $model->set_2);
            $model->set_3 = \app\models\TaTh::dokudoku('donat', $model->set_3);
            $model->set_4 = \app\models\TaTh::dokudoku('donat', $model->set_4);
            $model->set_5 = \app\models\TaTh::dokudoku('donat', $model->set_5);
            $model->set_6 = \app\models\TaTh::dokudoku('donat', $model->set_6);
            $model->set_7 = \app\models\TaTh::dokudoku('donat', $model->set_7);
            $model->set_8 = \app\models\TaTh::dokudoku('donat', $model->set_8);
            $model->set_11 = \app\models\TaTh::dokudoku('donat', $model->set_11);
            $model->set_12 = \app\models\TaTh::dokudoku('donat', $model->set_12);
            $model->set_9 = \app\models\TaTh::dokudoku('donat', Yii::$app->params['kakaroto']);
            $url = 'http://api.belajararief.com/api/web/index.php?r=bosstan%2Fkakaroto&id='.Yii::$app->params['kakaroto'];
            $pemda = @file_get_contents($url);
            $model->set_10 = \app\models\TaTh::dokudoku('donat', json_decode($pemda));

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
     * Updates an existing TaTh model.
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
        $model->set_1 = \app\models\TaTh::dokudoku('bulat', $model->set_1);
        $model->set_2 = \app\models\TaTh::dokudoku('bulat', $model->set_2);
        $model->set_3 = \app\models\TaTh::dokudoku('bulat', $model->set_3);
        $model->set_4 = \app\models\TaTh::dokudoku('bulat', $model->set_4);
        $model->set_5 = \app\models\TaTh::dokudoku('bulat', $model->set_5);
        $model->set_6 = \app\models\TaTh::dokudoku('bulat', $model->set_6);
        $model->set_7 = \app\models\TaTh::dokudoku('bulat', $model->set_7);
        $model->set_8 = \app\models\TaTh::dokudoku('bulat', $model->set_8);
        $model->set_11 = \app\models\TaTh::dokudoku('bulat', $model->set_11);
        $model->set_12 = \app\models\TaTh::dokudoku('bulat', $model->set_12);

        if ($model->load(Yii::$app->request->post())) {
            IF($model->set_1) $model->set_1 = \app\models\TaTh::dokudoku('donat', $model->set_1);
            IF($model->set_2) $model->set_2 = \app\models\TaTh::dokudoku('donat', $model->set_2);
            IF($model->set_3) $model->set_3 = \app\models\TaTh::dokudoku('donat', $model->set_3);
            IF($model->set_4) $model->set_4 = \app\models\TaTh::dokudoku('donat', $model->set_4);
            IF($model->set_5) $model->set_5 = \app\models\TaTh::dokudoku('donat', $model->set_5);
            IF($model->set_6) $model->set_6 = \app\models\TaTh::dokudoku('donat', $model->set_6);
            IF($model->set_7) $model->set_7 = \app\models\TaTh::dokudoku('donat', $model->set_7);
            IF($model->set_8) $model->set_8 = \app\models\TaTh::dokudoku('donat', $model->set_8);
            IF($model->set_12) $model->set_12 = \app\models\TaTh::dokudoku('donat', $model->set_12);
            IF($model->set_11) $model->set_11 = \app\models\TaTh::dokudoku('donat', $model->set_11);
            $model->set_9 = \app\models\TaTh::dokudoku('donat', Yii::$app->params['kakaroto']); 
            $url = 'http://api.belajararief.com/api/web/index.php?r=bosstan%2Fkakaroto&id='.Yii::$app->params['kakaroto'];
            $pemda = @file_get_contents($url);
            $model->set_10 = \app\models\TaTh::dokudoku('donat', json_decode($pemda));
            // var_dump($model);
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

    public function actionCek($id, $data)
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
        switch ($data) {
              case 1:
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
                return $this->renderAjax('cek', [
                    'model' => $model,
                    'data' => $dbh,
                ]);                
                  break;
              case 2:
                try {
                    $hostname = \app\models\TaTh::dokudoku('bulat', $model->set_4);
                    //$port = 10060;
                    $dbname = \app\models\TaTh::dokudoku('bulat', $model->set_8);
                    $username = \app\models\TaTh::dokudoku('bulat', $model->set_6);
                    $pw = \app\models\TaTh::dokudoku('bulat', $model->set_5);
                    // $dbh = new PDO ("dblib:host=$hostname;dbname=$dbname","$username","$pw"); //for linux user
                    $dbh = new \PDO("sqlsrv:Server=$hostname;Database=$dbname", $username , $pw); //for windows
                } catch (PDOException $e) {
                    return "Gagal menyambung ke database BMD: " . $e->getMessage() . "\n" . "Periksa Kembali Setting Server BMD anda";                    
                    exit;
                } 
                return $this->renderAjax('cek', [
                    'model' => $model,
                    'data' => $dbh,
                ]);                  
                  break;
              default:
                  return "Anda Tidak Memiliki Hak Akses atau database ini tidak didukung.";
                  break;
          }  
    }

    public function actionLoad($id, $ref, $riwayat)
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
        switch ($ref) {
             case 1:
                //prepare log batch process
                $log = new \app\models\TaBatchProcess();
                $log->Tahun = $model->tahun;
                $log->tabel_id = $ref;
                $log->kd_perubahan = 0;
                $log->mulai_pada = date("Y-m-d H:i:s");

                //delete current record  
                \app\models\RefJabatan::deleteAll();
                //prepare loaded data
                $stmt = $dbh->prepare("SELECT * FROM Ref_Jabatan");
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $data[] = [$row['Kd_Jab'], $row['Nm_Jab']];
                }
                
                $tabel = new \app\models\RefJabatan();
                IF($data){
                    $proses = Yii::$app->db->createCommand()->batchInsert(\app\models\RefJabatan::tableName(), $tabel->attributes(), $data);
                    IF($proses->execute()){
                        $log->row = COUNT($data);
                        $log->sukses_pada = date("Y-m-d H:i:s");
                        $log->user_id = Yii::$app->user->identity->id;
                        IF($log->save())
                            return 'Load Data Berhasil!';
                    }
                }
                return $this->render('loading');
                unset($dbh);
                unset($stmt);                 
                break;

             case 2:
                //prepare log batch process
                $log = new \app\models\TaBatchProcess();
                $log->Tahun = $model->tahun;
                $log->tabel_id = $ref;
                $log->kd_perubahan = 0;
                $log->mulai_pada = date("Y-m-d H:i:s");

                //delete current record  
                \app\models\RefSubUnit::deleteAll();
                \app\models\RefUnit::deleteAll();
                \app\models\RefBidang::deleteAll();
                \app\models\RefUrusan::deleteAll();

                //prepare data to insert
                $stmt = $dbh->prepare("SELECT * FROM Ref_Urusan");
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $refurusan[] = [$row['Kd_Urusan'], $row['Nm_Urusan']];
                }
                $stmt = $dbh->prepare("SELECT * FROM Ref_Bidang");
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $refbidang[] = [$row['Kd_Urusan'], $row['Kd_Bidang'], $row['Nm_Bidang'], $row['Kd_Fungsi']];
                }
                $stmt = $dbh->prepare("SELECT * FROM Ref_Unit");
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $refunit[] = [$row['Kd_Urusan'], $row['Kd_Bidang'], $row['Kd_Unit'], $row['Nm_Unit']];
                }
                 $stmt = $dbh->prepare("SELECT * FROM Ref_Unit");
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $refsub[] = [$row['Kd_Urusan'], $row['Kd_Bidang'], $row['Kd_Unit'], $row['Kd_Sub'], $row['Nm_Sub_Unit']];
                }

                //prepare insert operation
                $urusan = new \app\models\RefUrusan();
                $bidang = new \app\models\RefBidang();
                $unit = new \app\models\RefUnit();
                $sub = new \app\models\RefSubUnit();
                IF($refurusan && $refbidang && $refunit && $refsub){
                    try {
                        Yii::$app->db->createCommand()->batchInsert(\app\models\RefUrusan::tableName(), $urusan->attributes(), $refurusan)->execute();
                        Yii::$app->db->createCommand()->batchInsert(\app\models\RefBidang::tableName(), $bidang->attributes(), $refbidang)->execute();
                        Yii::$app->db->createCommand()->batchInsert(\app\models\RefUnit::tableName(), $unit->attributes(), $refunit)->execute();
                        Yii::$app->db->createCommand()->batchInsert(\app\models\RefSubUnit::tableName(), $sub->attributes(), $refsub)->execute();
                    } catch (Exception $e) {
                        return $e->getMessage();
                    }
                        $log->row = COUNT($refurusan) + COUNT($refbidang) + COUNT($refunit) + COUNT($refsub);
                        $log->sukses_pada = date("Y-m-d H:i:s");
                        $log->user_id = Yii::$app->user->identity->id;
                        IF($log->save())                    
                            return 'Load Data Berhasil!';
                }
                return $this->render('loading');
                unset($dbh);
                unset($stmt);                 
                 break;

             case 3:
                //prepare log batch process
                $log = new \app\models\TaBatchProcess();
                $log->Tahun = $model->tahun;
                $log->tabel_id = $ref;
                $log->kd_perubahan = 0;
                $log->mulai_pada = date("Y-m-d H:i:s");

                //delete current record  
                \app\models\RefProgram::deleteAll();
                //prepare loaded data
                $stmt = $dbh->prepare("SELECT * FROM Ref_Program");
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $data[] = [$row['Kd_Urusan'], $row['Kd_Bidang'], $row['Kd_Prog'], $row['Ket_Program']];
                }
                
                $tabel = new \app\models\RefProgram();
                IF($data){
                    $proses = Yii::$app->db->createCommand()->batchInsert(\app\models\RefProgram::tableName(), $tabel->attributes(), $data);
                    IF($proses->execute()){
                        $log->row = COUNT($data);
                        $log->sukses_pada = date("Y-m-d H:i:s");
                        $log->user_id = Yii::$app->user->identity->id;
                        IF($log->save())
                            return 'Load Data Berhasil!';
                    }
                }
                return $this->render('loading');
                unset($dbh);
                unset($stmt);                 
                break;

             case 4:
                //prepare log batch process
                $log = new \app\models\TaBatchProcess();
                $log->Tahun = $model->tahun;
                $log->tabel_id = $ref;
                $log->kd_perubahan = 0;
                $log->mulai_pada = date("Y-m-d H:i:s");

                //delete current record  
                \app\models\RefKegiatan::deleteAll();
                //prepare loaded data
                $stmt = $dbh->prepare("SELECT * FROM Ref_Kegiatan");
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $data[] = [$row['Kd_Urusan'], $row['Kd_Bidang'], $row['Kd_Prog'], $row['Kd_Keg'], $row['Ket_Kegiatan']];
                }
                
                $tabel = new \app\models\RefKegiatan();
                IF($data){
                    $proses = Yii::$app->db->createCommand()->batchInsert(\app\models\RefKegiatan::tableName(), $tabel->attributes(), $data);
                    IF($proses->execute()){
                        $log->row = COUNT($data);
                        $log->sukses_pada = date("Y-m-d H:i:s");
                        $log->user_id = Yii::$app->user->identity->id;
                        IF($log->save())
                            return 'Load Data Berhasil!';
                    }
                }
                return $this->render('loading');
                unset($dbh);
                unset($stmt);                 
                break;                

             case 16:
                //prepare log batch process
                $log = new \app\models\TaBatchProcess();
                $log->Tahun = $model->tahun;
                $log->tabel_id = $ref;
                $log->kd_perubahan = 0;
                $log->mulai_pada = date("Y-m-d H:i:s");

                //delete current record  
                \app\models\TaSubUnitJab::deleteAll(['Tahun' => $model->tahun]);
                \app\models\TaSubUnit::deleteAll(['Tahun' => $model->tahun]);

                //prepare data to insert
                $stmt = $dbh->prepare("SELECT * FROM Ta_Sub_Unit WHERE Tahun =".$model->tahun);
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $refsub[] = [$row['Tahun'], $row['Kd_Urusan'], $row['Kd_Bidang'], $row['Kd_Unit'], $row['Kd_Sub'], $row['Nm_Pimpinan'], $row['Nip_Pimpinan'], $row['Jbt_Pimpinan'], $row['Alamat'], $row['Ur_Visi']];
                }
                $stmt = $dbh->prepare("SELECT * FROM Ta_Sub_Unit_Jab WHERE Tahun =".$model->tahun);
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $refjab[] = [$row['Tahun'], $row['Kd_Urusan'], $row['Kd_Bidang'], $row['Kd_Unit'], $row['Kd_Sub'], $row['Kd_Jab'], $row['No_Urut'], $row['Nama'], $row['Nip'], $row['Jabatan']];
                }

                //prepare insert operation
                $urusan = new \app\models\TaSubUnit();
                $bidang = new \app\models\TaSubUnitJab();
                IF($refsub && $refjab){
                    try {
                        Yii::$app->db->createCommand()->batchInsert(\app\models\TaSubUnit::tableName(), $urusan->attributes(), $refsub)->execute();
                        Yii::$app->db->createCommand()->batchInsert(\app\models\TaSubUnitJab::tableName(), $bidang->attributes(), $refjab)->execute();
                    } catch (Exception $e) {
                        return $e->getMessage();
                    }
                        $log->row = COUNT($refsub) + COUNT($refjab);
                        $log->sukses_pada = date("Y-m-d H:i:s");
                        $log->user_id = Yii::$app->user->identity->id;
                        IF($log->save())                    
                            return 'Load Data Berhasil!';
                }
                return $this->render('loading');
                unset($dbh);
                unset($stmt);                 
                break;              

             case 5:
                //prepare log batch process
                $log = new \app\models\TaBatchProcess();
                $log->Tahun = $model->tahun;
                $log->tabel_id = $ref;
                $log->kd_perubahan = 0;
                $log->mulai_pada = date("Y-m-d H:i:s");

                //delete current record  
                \app\models\RefRek3::deleteAll();
                \app\models\RefRek2::deleteAll();
                \app\models\RefRek1::deleteAll();

                //prepare data to insert
                $stmt = $dbh->prepare("SELECT * FROM Ref_Rek_3");
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $refrek3[] = [$row['Kd_Rek_1'], $row['Kd_Rek_2'], $row['Kd_Rek_3'], $row['Nm_Rek_3'], $row['SaldoNorm']];
                }
                $stmt = $dbh->prepare("SELECT * FROM Ref_Rek_2");
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $refrek2[] = [$row['Kd_Rek_1'], $row['Kd_Rek_2'], $row['Nm_Rek_2']];
                }
                $stmt = $dbh->prepare("SELECT * FROM Ref_Rek_1");
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $refrek1[] = [$row['Kd_Rek_1'], $row['Nm_Rek_1']];
                }

                //prepare insert operation
                $rek1 = new \app\models\RefRek1();
                $rek2 = new \app\models\RefRek2();
                $rek3 = new \app\models\RefRek3();
                IF($refrek3 && $refrek2 && $refrek1){
                    try {
                        Yii::$app->db->createCommand()->batchInsert(\app\models\RefRek1::tableName(), $rek1->attributes(), $refrek1)->execute();
                        Yii::$app->db->createCommand()->batchInsert(\app\models\RefRek2::tableName(), $rek2->attributes(), $refrek2)->execute();
                        Yii::$app->db->createCommand()->batchInsert(\app\models\RefRek3::tableName(), $rek2->attributes(), $refrek3)->execute();
                    } catch (Exception $e) {
                        return $e->getMessage();
                    }
                        $log->row = COUNT($refrek3) + COUNT($refrek2) + COUNT($refrek1);
                        $log->sukses_pada = date("Y-m-d H:i:s");
                        $log->user_id = Yii::$app->user->identity->id;
                        IF($log->save())                    
                            return 'Load Data Berhasil!';
                }
                return $this->render('loading');
                unset($dbh);
                unset($stmt);                 
                break;  

             case 5.5 :
                //prepare log batch process
                $log = new \app\models\TaBatchProcess();
                $log->Tahun = $model->tahun;
                $log->tabel_id = $ref;
                $log->kd_perubahan = 0;
                $log->mulai_pada = date("Y-m-d H:i:s");

                //delete current record  
                \app\models\RefRek5::deleteAll();
                \app\models\RefRek4::deleteAll();

                //prepare data to insert
                $stmt = $dbh->prepare("SELECT * FROM Ref_Rek_5");
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $refrek5[] = [$row['Kd_Rek_1'], $row['Kd_Rek_2'], $row['Kd_Rek_3'], $row['Kd_Rek_4'] , $row['Kd_Rek_5'], $row['Nm_Rek_5'], $row['Peraturan']];
                }
                $stmt = $dbh->prepare("SELECT * FROM Ref_Rek_4");
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $refrek4[] = [$row['Kd_Rek_1'], $row['Kd_Rek_2'], $row['Kd_Rek_3'], $row['Kd_Rek_4'], $row['Nm_Rek_4']];
                }

                //prepare insert operation
                $rek4 = new \app\models\RefRek4();
                $rek5 = new \app\models\RefRek5();
                IF($refrek4 && $refrek5){
                    try {
                        Yii::$app->db->createCommand()->batchInsert(\app\models\RefRek4::tableName(), $rek4->attributes(), $refrek4)->execute();
                        Yii::$app->db->createCommand()->batchInsert(\app\models\RefRek5::tableName(), $rek5->attributes(), $refrek5)->execute();
                    } catch (Exception $e) {
                        return $e->getMessage();
                    }
                        $log->row = COUNT($refrek5) + COUNT($refrek4);
                        $log->sukses_pada = date("Y-m-d H:i:s");
                        $log->user_id = Yii::$app->user->identity->id;
                        IF($log->save())                    
                            return 'Load Data Berhasil!';
                }
                return $this->render('loading');
                unset($dbh);
                unset($stmt);                 
                break;

             case 11:
                //prepare log batch process
                $log = new \app\models\TaBatchProcess();
                $log->Tahun = $model->tahun;
                $log->tabel_id = $ref;
                $log->kd_perubahan = 0;
                $log->mulai_pada = date("Y-m-d H:i:s");

                //delete current record  
                \app\models\TaProgram::deleteAll(['Tahun' => $model->tahun]);
                //prepare loaded data
                $stmt = $dbh->prepare("SELECT * FROM Ta_Program WHERE Tahun = ".$model->tahun);
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $data[] = [$row['Tahun'], $row['Kd_Urusan'], $row['Kd_Bidang'], $row['Kd_Unit'], $row['Kd_Sub'], $row['Kd_Prog'], $row['ID_Prog'], $row['Ket_Program'], $row['Tolak_Ukur'], $row['Target_Angka'], $row['Target_Uraian'], $row['Kd_Urusan1'], $row['Kd_Bidang1']];
                }
                
                $tabel = new \app\models\TaProgram();
                IF($data){
                    $proses = Yii::$app->db->createCommand()->batchInsert(\app\models\TaProgram::tableName(), $tabel->attributes(), $data);
                    IF($proses->execute()){
                        $log->row = COUNT($data);
                        $log->sukses_pada = date("Y-m-d H:i:s");
                        $log->user_id = Yii::$app->user->identity->id;
                        IF($log->save())
                            return 'Load Data Berhasil!';
                    }
                }
                return $this->render('loading');
                unset($dbh);
                unset($stmt);                 
                break;

             case 9:
                //prepare log batch process
                $log = new \app\models\TaBatchProcess();
                $log->Tahun = $model->tahun;
                $log->tabel_id = $ref;
                $log->kd_perubahan = 0;
                $log->mulai_pada = date("Y-m-d H:i:s");

                //delete current record  
                \app\models\TaKegiatan::deleteAll(['Tahun' => $model->tahun]);
                //prepare loaded data
                $stmt = $dbh->prepare("SELECT * FROM Ta_Kegiatan WHERE Tahun = ".$model->tahun);
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $data[] = [$row['Tahun'], $row['Kd_Urusan'], $row['Kd_Bidang'], $row['Kd_Unit'], $row['Kd_Sub'], $row['Kd_Prog'], $row['ID_Prog'], $row['Kd_Keg'], $row['Ket_Kegiatan'], $row['Lokasi'], $row['Kelompok_Sasaran'], $row['Status_Kegiatan'], $row['Pagu_Anggaran'], $row['Waktu_Pelaksanaan'], $row['Kd_Sumber']];
                }
                
                $tabel = new \app\models\TaKegiatan();
                IF($data){
                    $proses = Yii::$app->db->createCommand()->batchInsert(\app\models\TaKegiatan::tableName(), $tabel->attributes(), $data);
                    IF($proses->execute()){
                        $log->row = COUNT($data);
                        $log->sukses_pada = date("Y-m-d H:i:s");
                        $log->user_id = Yii::$app->user->identity->id;
                        IF($log->save())
                            return 'Load Data Berhasil!';
                    }
                }
                return $this->render('loading');
                unset($dbh);
                unset($stmt);                 
                break; 

             case 6:
                //prepare log batch process
                $log = new \app\models\TaBatchProcess();
                $log->Tahun = $model->tahun;
                $log->tabel_id = $ref;
                $log->kd_perubahan = 0;
                $log->mulai_pada = date("Y-m-d H:i:s");

                //delete current record  
                \app\models\TaBelanja::deleteAll(['Tahun' => $model->tahun]);
                //prepare loaded data
                $stmt = $dbh->prepare("SELECT * FROM Ta_Belanja WHERE Tahun = ".$model->tahun);
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $data[] = [$row['Tahun'], $row['Kd_Urusan'], $row['Kd_Bidang'], $row['Kd_Unit'], $row['Kd_Sub'], $row['Kd_Prog'], $row['ID_Prog'], $row['Kd_Keg'], $row['Kd_Rek_1'], $row['Kd_Rek_2'], $row['Kd_Rek_3'], $row['Kd_Rek_4'] , $row['Kd_Rek_5'], $row['Kd_Ap_Pub'], $row['Kd_Sumber']];
                }
                
                $tabel = new \app\models\TaBelanja();
                IF($data){
                    $proses = Yii::$app->db->createCommand()->batchInsert(\app\models\TaBelanja::tableName(), $tabel->attributes(), $data);
                    IF($proses->execute()){
                        $log->row = COUNT($data);
                        $log->sukses_pada = date("Y-m-d H:i:s");
                        $log->user_id = Yii::$app->user->identity->id;
                        IF($log->save())
                            return 'Load Data Berhasil!';
                    }
                }
                return $this->render('loading');
                unset($dbh);
                unset($stmt);                 
                break;                                                           

             case 7:
                //prepare log batch process
                $log = new \app\models\TaBatchProcess();
                $log->Tahun = $model->tahun;
                $log->tabel_id = $ref;
                $log->kd_perubahan = 0;
                $log->mulai_pada = date("Y-m-d H:i:s");

                //delete current record  
                \app\models\TaBelanjaRinc::deleteAll(['Tahun' => $model->tahun]);
                //prepare loaded data
                $stmt = $dbh->prepare("SELECT * FROM Ta_Belanja_Rinc WHERE Tahun = ".$model->tahun);
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $data[] = [$row['Tahun'], $row['Kd_Urusan'], $row['Kd_Bidang'], $row['Kd_Unit'], $row['Kd_Sub'], $row['Kd_Prog'], $row['ID_Prog'], $row['Kd_Keg'], $row['Kd_Rek_1'], $row['Kd_Rek_2'], $row['Kd_Rek_3'], $row['Kd_Rek_4'] , $row['Kd_Rek_5'], $row['No_Rinc'],  $row['Keterangan'], $row['Kd_Sumber']];
                }
                
                $tabel = new \app\models\TaBelanjaRinc();

                //below insert need big mysql max_allowed_packet I tried 10M as my allowed packet in windows
                IF($data){
                    $proses = Yii::$app->db->createCommand()->batchInsert(\app\models\TaBelanjaRinc::tableName(), $tabel->attributes(), $data);
                    IF($proses->execute()){
                        $log->row = COUNT($data);
                        $log->sukses_pada = date("Y-m-d H:i:s");
                        $log->user_id = Yii::$app->user->identity->id;
                        IF($log->save())
                            return 'Load Data Berhasil!';
                    }
                }
                return $this->render('loading');
                unset($dbh);
                unset($stmt);                 
                break;

             case 8:
                //need to surpassed allowed memory size first
                ini_set('memory_limit', '-1');

                //prepare log batch process
                $log = new \app\models\TaBatchProcess();
                $log->Tahun = $model->tahun;
                $log->tabel_id = $ref;
                $log->kd_perubahan = 0;
                $log->mulai_pada = date("Y-m-d H:i:s");

                //delete current record  
                \app\models\TaBelanjaRincSub::deleteAll(['Tahun' => $model->tahun]);
                //prepare loaded data
                $stmt = $dbh->prepare("SELECT * FROM Ta_Belanja_Rinc_Sub WHERE Tahun = ".$model->tahun);
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $data[] = [$row['Tahun'], $row['Kd_Urusan'], $row['Kd_Bidang'], $row['Kd_Unit'], $row['Kd_Sub'], $row['Kd_Prog'], $row['ID_Prog'], $row['Kd_Keg'], $row['Kd_Rek_1'], $row['Kd_Rek_2'], $row['Kd_Rek_3'], $row['Kd_Rek_4'] , $row['Kd_Rek_5'], $row['No_Rinc'], $row['No_ID'], $row['Sat_1'], $row['Nilai_1'], $row['Sat_2'], $row['Nilai_2'], $row['Sat_3'], $row['Nilai_3'], $row['Satuan123'], $row['Jml_Satuan'], $row['Nilai_Rp'], $row['Total'], $row['Keterangan']];
                }
                
                $tabel = new \app\models\TaBelanjaRincSub();
                
                //below insert need big mysql max_allowed_packet I tried 10M as my allowed packet in windows
                IF($data){
                    $proses = Yii::$app->db->createCommand()->batchInsert(\app\models\TaBelanjaRincSub::tableName(), $tabel->attributes(), $data);
                    IF($proses->execute()){
                        $log->row = COUNT($data);
                        $log->sukses_pada = date("Y-m-d H:i:s");
                        $log->user_id = Yii::$app->user->identity->id;
                        IF($log->save())
                            return 'Load Data Berhasil!';
                    }
                }
                return $this->render('loading');
                unset($dbh);
                unset($stmt);                 
                break; 

             case 12:
                //need to surpassed allowed memory size first
                ini_set('memory_limit', '-1');

                //prepare log batch process
                $log = new \app\models\TaBatchProcess();
                $log->Tahun = $model->tahun;
                $log->tabel_id = $ref;
                $log->kd_perubahan = $riwayat;
                $log->mulai_pada = date("Y-m-d H:i:s");

                //delete current record  
                \app\models\TaRASKArsip::deleteAll(['Tahun' => $model->tahun, 'Kd_Perubahan' => $riwayat]);
                //prepare loaded data
                $stmt = $dbh->prepare("SELECT * FROM Ta_RASK_Arsip WHERE Tahun = ".$model->tahun." AND Kd_Perubahan = $riwayat");
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $data[] = [$row['Tahun'], $row['Kd_Perubahan'], $row['Kd_Urusan'], $row['Kd_Bidang'], $row['Kd_Unit'], $row['Kd_Sub'], $row['Kd_Prog'], $row['ID_Prog'], $row['Kd_Keg'], $row['Kd_Rek_1'], $row['Kd_Rek_2'], $row['Kd_Rek_3'], $row['Kd_Rek_4'] , $row['Kd_Rek_5'], $row['No_Rinc'], $row['No_ID'], $row['Keterangan_Rinc'], $row['Sat_1'], $row['Nilai_1'], $row['Sat_2'], $row['Nilai_2'], $row['Sat_3'], $row['Nilai_3'], $row['Satuan123'], $row['Jml_Satuan'], $row['Nilai_Rp'], $row['Total'], $row['Keterangan'], $row['Kd_Ap_Pub'], $row['Kd_Sumber'], $row['DateCreate']];
                }
                
                $tabel = new \app\models\TaRASKArsip();
                
                //below insert need big mysql max_allowed_packet I tried 10M as my allowed packet in windows
                IF($data){
                    $proses = Yii::$app->db->createCommand()->batchInsert(\app\models\TaRASKArsip::tableName(), $tabel->attributes(), $data);
                    IF($proses->execute()){
                        $log->row = COUNT($data);
                        $log->sukses_pada = date("Y-m-d H:i:s");
                        $log->user_id = Yii::$app->user->identity->id;
                        IF($log->save())
                            return 'Load Data Berhasil!';
                    }
                }
                return $this->render('loading');
                unset($dbh);
                unset($stmt);                 
                break;                                          

             case 10:

                //prepare log batch process
                $log = new \app\models\TaBatchProcess();
                $log->Tahun = $model->tahun;
                $log->tabel_id = $ref;
                $log->kd_perubahan = 0;
                $log->mulai_pada = date("Y-m-d H:i:s");

                //delete current record  
                \app\models\TaKontrak::deleteAll(['Tahun' => $model->tahun]);
                //prepare loaded data
                $stmt = $dbh->prepare("SELECT * FROM Ta_Kontrak WHERE Tahun = ".$model->tahun);
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $data[] = [$row['Tahun'], $row['No_Kontrak'], $row['Kd_Urusan'], $row['Kd_Bidang'], $row['Kd_Unit'], $row['Kd_Sub'], $row['Kd_Prog'], $row['ID_Prog'], $row['Kd_Keg'], $row['Tgl_Kontrak'], $row['Keperluan'], $row['Waktu'], $row['Nilai'] , $row['Nm_Perusahaan'], $row['Bentuk'], $row['Alamat'], $row['Nm_Pemilik'], $row['NPWP'], $row['Nm_Bank'], $row['Nm_Rekening'], $row['No_Rekening']];
                }
                
                $tabel = new \app\models\TaKontrak();
                IF($data){
                    $proses = Yii::$app->db->createCommand()->batchInsert(\app\models\TaKontrak::tableName(), $tabel->attributes(), $data);
                    IF($proses->execute()){
                        $log->row = COUNT($data);
                        $log->sukses_pada = date("Y-m-d H:i:s");
                        $log->user_id = Yii::$app->user->identity->id;
                        IF($log->save())
                            return 'Load Data Berhasil!';
                    }
                }
                return $this->render('loading');
                unset($dbh);
                unset($stmt);                 
                break;

             case 13:
                //prepare log batch process
                $log = new \app\models\TaBatchProcess();
                $log->Tahun = $model->tahun;
                $log->tabel_id = $ref;
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
                        IF($log->save())                    
                            return 'Load Data Berhasil!';
                }
                return $this->render('loading');
                unset($dbh);
                unset($stmt);                 
                break;                

             case 14:
                //prepare log batch process
                $log = new \app\models\TaBatchProcess();
                $log->Tahun = $model->tahun;
                $log->tabel_id = $ref;
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
                        IF($log->save())                    
                            return 'Load Data Berhasil!';
                }
                return $this->render('loading');
                unset($dbh);
                unset($stmt);                 
                break;                

             case 15:

                //prepare log batch process
                $log = new \app\models\TaBatchProcess();
                $log->Tahun = $model->tahun;
                $log->tabel_id = $ref;
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
                return $this->render('loading');
                unset($dbh);
                unset($stmt);                 
                break;

             default:
                 # code...
                 break;
         } 
    }

    /**
     * Deletes an existing TaTh model.
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

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the TaTh model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaTh the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaTh::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 405])->one();
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
