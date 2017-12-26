<?php

namespace app\modules\anggaran\controllers;
use Yii;
use yii\base\Model;
use yii\helpers\Json;
use app\models\TaRkasKegiatan;
use app\modules\anggaran\models\TaRkasKegiatanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class PostingController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'repost' => ['POST'],
                ],
            ],
        ];
    }

    public function actionRepost($no_peraturan, $sekolah_id = null)
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
        if(!$sekolah_id || $sekolah_id == null) $sekolah_id = Yii::$app->user->identity->sekolah_id;
        $model = \app\models\TaRkasPeraturan::findOne(['no_peraturan' => $no_peraturan, 'sekolah_id' => $sekolah_id]);
        if($model->delete()){
            Yii::$app->getSession()->setFlash('success',  'Posting telah dihapus! Silahkan posting kondisi terbaru!');
            return $this->redirect(Yii::$app->request->referrer);   
        }
    }

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

        $laporan = new \app\models\Laporan();
        $sekolah_id = Yii::$app->user->identity->sekolah_id ? Yii::$app->user->identity->sekolah_id : NULL;
        $kd_rencana = 3;
        $kd_induk = 4;
        $kd_perubahan = 6;

        $pdt = \app\models\TaRkasPendapatanRinc::find()->where(['tahun' => $Tahun, 'sekolah_id' => $sekolah_id])->sum('total');
        $belanja = \app\models\TaRkasBelanjaRinc::find()->where(['tahun' => $Tahun, 'sekolah_id' => $sekolah_id, 'Kd_Rek_1' => 5, 'Kd_Rek_2' => 2])->sum('total');
        $btl = \app\models\TaRkasBelanjaRinc::find()->where(['tahun' => $Tahun, 'sekolah_id' => $sekolah_id, 'Kd_Rek_1' => 5, 'Kd_Rek_2' => 1])->sum('total');

        $rencana = \app\models\TaRkasPeraturan::findOne(['tahun' => $Tahun, 'sekolah_id' => $sekolah_id, 'perubahan_id' => 3]);
        $induk = \app\models\TaRkasPeraturan::findOne(['tahun' => $Tahun, 'sekolah_id' => $sekolah_id, 'perubahan_id' => 4]);
        $perubahan1 = \app\models\TaRkasPeraturan::findOne(['tahun' => $Tahun, 'sekolah_id' => $sekolah_id, 'perubahan_id' => 6]);

        IF(!$rencana){
        	$rencana = new \app\models\TaRkasPeraturan();
        	$rencana->tahun = $Tahun;
        	$rencana->sekolah_id = $sekolah_id;
        	// $rencana->perubahan_id = 3;
        	$rencana->verifikasi = 0;
        }

        IF(!$induk){
        	$induk = new \app\models\TaRkasPeraturan();
        	$induk->tahun = $Tahun;
        	$induk->sekolah_id = $sekolah_id;
        	// $induk->perubahan_id = 4;
        	$induk->verifikasi = 0;
        }

        IF(!$perubahan1){
        	$perubahan1 = new \app\models\TaRkasPeraturan();
        	$perubahan1->tahun = $Tahun;
        	$perubahan1->sekolah_id = $sekolah_id;
        	// $perubahan1->perubahan_id = 6;
        	$perubahan1->verifikasi = 0;
        }

        if(isset($_POST['TaRkasPeraturan'])) {
          $perubahan_id = $_POST['TaRkasPeraturan']['perubahan_id'];
          switch ($perubahan_id) {
            case 3:
              $rencana = new \app\models\TaRkasPeraturan();
              $rencana->tahun = $Tahun;
              $rencana->sekolah_id = $sekolah_id;
              $rencana->verifikasi = 0;              
              $rencana->load(Yii::$app->request->post());
              // var_dump($rencana);
              break;
            case 4:
              $rencana = new \app\models\TaRkasPeraturan();
              $rencana->tahun = $Tahun;
              $rencana->sekolah_id = $sekolah_id;
              $rencana->verifikasi = 0;              
              $rencana->load(Yii::$app->request->post());
              // var_dump($rencana);
              break;
            case 6:
              $rencana = new \app\models\TaRkasPeraturan();
              $rencana->tahun = $Tahun;
              $rencana->sekolah_id = $sekolah_id;
              $rencana->verifikasi = 0;              
              $rencana->load(Yii::$app->request->post());
              // var_dump($rencana);
              break;                          
            default:
              # code...
              break;
          }
          // $rencana->load(Yii::$app->request->post())
          // var_dump($rencana);
            //cek rencana terlebih dahulu
            $connection = \Yii::$app->db;      
            $sql = $connection->createCommand("
                SELECT
                b.tahun,
                b.sekolah_id,
                b.kd_program,
                b.kd_sub_program,
                b.kd_kegiatan,
                b.Kd_Rek_1,
                b.Kd_Rek_2,
                b.Kd_Rek_3,
                b.Kd_Rek_4,
                b.Kd_Rek_5,
                a.no_rinc,
                a.keterangan,
                a.sat_1,
                a.nilai_1,
                a.sat_2,
                a.nilai_2,
                a.sat_3,
                a.nilai_3,
                a.satuan123,
                a.jml_satuan,
                a.nilai_rp,
                a.total,
                b.kd_penerimaan_1,
                b.kd_penerimaan_2,
                b.komponen_id,
                b.Kd_Rek_5
                FROM
                ta_rkas_belanja_rinc AS a
                RIGHT JOIN ta_rkas_belanja AS b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                WHERE
                b.tahun = $Tahun AND b.sekolah_id = $sekolah_id AND a.no_rinc IS NULL
                ");
            $cekbelanja = $sql->queryAll();
            $sql = $connection->createCommand("
                SELECT
                b.tahun,
                b.sekolah_id,
                b.kd_program,
                b.kd_sub_program,
                b.kd_kegiatan,
                b.Kd_Rek_1,
                b.Kd_Rek_2,
                b.Kd_Rek_3,
                b.Kd_Rek_4,
                b.Kd_Rek_5,
                a.juli,
                a.agustus,
                a.september,
                a.oktober,
                a.november,
                a.desember,
                a.januari1,
                a.februari1,
                a.maret1,
                a.april1,
                a.mei1,
                a.juni1
                FROM
                ta_rkas_belanja_rencana AS a
                RIGHT JOIN ta_rkas_belanja AS b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                WHERE
                b.tahun = $Tahun AND b.sekolah_id = $sekolah_id AND a.tahun IS NULL
                ");
            $cekrencanabelanja = $sql->queryAll();
            $sql = $connection->createCommand("
                SELECT
                b.tahun,
                b.sekolah_id,
                b.Kd_Rek_1,
                b.Kd_Rek_2,
                b.Kd_Rek_3,
                b.Kd_Rek_4,
                b.Kd_Rek_5,
                b.kd_penerimaan_1,
                b.kd_penerimaan_2,
                a.juli,
                a.agustus,
                a.september,
                a.oktober,
                a.november,
                a.desember,
                a.januari1,
                a.februari1,
                a.maret1,
                a.april1,
                a.mei1,
                a.juni1
                FROM
                ta_rkas_pendapatan AS b
                LEFT JOIN ta_rkas_pendapatan_rencana AS a ON b.tahun = a.tahun AND b.sekolah_id = a.sekolah_id AND b.Kd_Rek_1 = a.Kd_Rek_1 AND b.Kd_Rek_2 = a.Kd_Rek_2 AND b.Kd_Rek_3 = a.Kd_Rek_3 AND b.Kd_Rek_4 = a.Kd_Rek_4 AND b.Kd_Rek_5 = a.Kd_Rek_5 AND b.kd_penerimaan_1 = a.kd_penerimaan_1 AND b.kd_penerimaan_2 = a.kd_penerimaan_2
                WHERE
                b.tahun = $Tahun AND b.sekolah_id = $sekolah_id AND a.tahun IS NULL
                ");
            $cekrencanapendapatan = $sql->queryAll();                        

            IF(!$cekbelanja && !$cekrencanabelanja && !$cekrencanapendapatan){
                $date = new \DateTime();
                $date = $date->getTimestamp();
                //insert via sql for better php handling
                $connection = \Yii::$app->db;           
                $rkashistorybelanja = $connection->createCommand("
                    INSERT INTO ta_rkas_history
                    (tahun,
                    sekolah_id,
                    perubahan_id,
                    kd_program,
                    kd_sub_program,
                    kd_kegiatan,
                    Kd_Rek_1,
                    Kd_Rek_2,
                    Kd_Rek_3,
                    Kd_Rek_4,
                    Kd_Rek_5,
                    no_rinc,
                    keterangan,
                    sat_1,
                    nilai_1,
                    sat_2,
                    nilai_2,
                    sat_3,
                    nilai_3,
                    satuan123,
                    jml_satuan,
                    nilai_rp,
                    total,
                    kd_penerimaan_1,
                    kd_penerimaan_2,
                    komponen_id,
                    created_at,
                    updated_at)
                    SELECT
                    b.tahun,
                    b.sekolah_id,
                    $perubahan_id AS perubahan_id,
                    b.kd_program,
                    b.kd_sub_program,
                    b.kd_kegiatan,
                    b.Kd_Rek_1,
                    b.Kd_Rek_2,
                    b.Kd_Rek_3,
                    b.Kd_Rek_4,
                    b.Kd_Rek_5,
                    a.no_rinc,
                    a.keterangan,
                    a.sat_1,
                    a.nilai_1,
                    a.sat_2,
                    a.nilai_2,
                    a.sat_3,
                    a.nilai_3,
                    a.satuan123,
                    a.jml_satuan,
                    a.nilai_rp,
                    a.total,
                    b.kd_penerimaan_1,
                    b.kd_penerimaan_2,
                    b.komponen_id,
                    $date AS created_at,
                    $date AS updated_at
                    FROM
                    ta_rkas_belanja_rinc AS a
                    INNER JOIN ta_rkas_belanja AS b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                    WHERE
                    b.tahun = $Tahun AND b.sekolah_id = $sekolah_id
                    ");
                $rkashistorybelanjarencana = $connection->createCommand("
                    insert into ta_rkas_belanja_rencana_history
                                (tahun,
                                 sekolah_id,
                                 perubahan_id,
                                 kd_program,
                                 kd_sub_program,
                                 kd_kegiatan,
                                 Kd_Rek_1,
                                 Kd_Rek_2,
                                 Kd_Rek_3,
                                 Kd_Rek_4,
                                 Kd_Rek_5,
                                 juli,
                                 agustus,
                                 september,
                                 oktober,
                                 november,
                                 desember,
                                 januari1,
                                 februari1,
                                 maret1,
                                 april1,
                                 mei1,
                                 juni1,
                                 created_at,
                                 updated_at)
                    SELECT
                      tahun,
                      sekolah_id,
                      $perubahan_id AS perubahan_id,
                      kd_program,
                      kd_sub_program,
                      kd_kegiatan,
                      Kd_Rek_1,
                      Kd_Rek_2,
                      Kd_Rek_3,
                      Kd_Rek_4,
                      Kd_Rek_5,
                      juli,
                      agustus,
                      september,
                      oktober,
                      november,
                      desember,
                      januari1,
                      februari1,
                      maret1,
                      april1,
                      mei1,
                      juni1,
                      $date AS created_at,
                      $date AS updated_at
                    FROM ta_rkas_belanja_rencana
                    WHERE
                    tahun = $Tahun AND sekolah_id = $sekolah_id
                    ");                
                $rkashistorypendapatan = $connection->createCommand("
                    INSERT INTO ta_rkas_history
                    (tahun,
                    sekolah_id,
                    perubahan_id,
                    kd_program,
                    kd_sub_program,
                    kd_kegiatan,
                    Kd_Rek_1,
                    Kd_Rek_2,
                    Kd_Rek_3,
                    Kd_Rek_4,
                    Kd_Rek_5,
                    no_rinc,
                    keterangan,
                    sat_1,
                    nilai_1,
                    sat_2,
                    nilai_2,
                    sat_3,
                    nilai_3,
                    satuan123,
                    jml_satuan,
                    nilai_rp,
                    total,
                    kd_penerimaan_1,
                    kd_penerimaan_2,
                    komponen_id,
                    created_at,
                    updated_at)
                    SELECT
                    a.tahun,
                    a.sekolah_id,
                    $perubahan_id AS perubahan_id,
                    0 AS kd_program,
                    0 AS kd_sub_program,
                    0 AS kd_kegiatan,
                    a.Kd_Rek_1,
                    a.Kd_Rek_2,
                    a.Kd_Rek_3,
                    a.Kd_Rek_4,
                    a.Kd_Rek_5,
                    a.no_rinc,
                    a.keterangan,
                    a.sat_1,
                    a.nilai_1,
                    a.sat_2,
                    a.nilai_2,
                    a.sat_3,
                    a.nilai_3,
                    a.satuan123,
                    a.jml_satuan,
                    a.nilai_rp,
                    a.total,
                    a.kd_penerimaan_1,
                    a.kd_penerimaan_2,
                    NULL,
                    $date AS created_at,
                    $date AS updated_at
                    FROM
                    ta_rkas_pendapatan_rinc AS a
                    WHERE
                    a.tahun = $Tahun AND a.sekolah_id = $sekolah_id
                    ");
                $rkashistorypendapatanrencana = $connection->createCommand("
                    insert into ta_rkas_pendapatan_rencana_history
                                (tahun,
                                 sekolah_id,
                                 perubahan_id,
                                 Kd_Rek_1,
                                 Kd_Rek_2,
                                 Kd_Rek_3,
                                 Kd_Rek_4,
                                 Kd_Rek_5,
                                 kd_penerimaan_1,
                                 kd_penerimaan_2,
                                 juli,
                                 agustus,
                                 september,
                                 oktober,
                                 november,
                                 desember,
                                 januari1,
                                 februari1,
                                 maret1,
                                 april1,
                                 mei1,
                                 juni1,
                                 created_at,
                                 updated_at)
                    SELECT
                      tahun,
                      sekolah_id,
                      $perubahan_id AS perubahan_id,
                      Kd_Rek_1,
                      Kd_Rek_2,
                      Kd_Rek_3,
                      Kd_Rek_4,
                      Kd_Rek_5,
                      kd_penerimaan_1,
                      kd_penerimaan_2,
                      juli,
                      agustus,
                      september,
                      oktober,
                      november,
                      desember,
                      januari1,
                      februari1,
                      maret1,
                      april1,
                      mei1,
                      juni1,
                      $date AS created_at,
                      $date AS updated_at
                    FROM ta_rkas_pendapatan_rencana
                    WHERE
                    tahun = $Tahun AND sekolah_id = $sekolah_id
                    ");                                           
                IF($rencana->save()){
                    $rkashistorybelanja->execute();
                    $rkashistorybelanjarencana->execute();
                    $rkashistorypendapatan->execute();
                    $rkashistorypendapatanrencana->execute();
                    return $this->redirect(Yii::$app->request->referrer);   
                    // echo 1;
                }ELSE{
                    // echo 0;
                    Yii::$app->getSession()->setFlash('danger',  'Posting gagal!');
                    return $this->redirect(Yii::$app->request->referrer);                                
                }
            }ELSE{
                $returnBelanja = "";
                if($cekbelanja){
                    $returnBelanja .= "Belanja Tanpa Rincian: ";
                    foreach($cekbelanja as $cekbelanjadata){
                        $returnBelanja.= "(".$cekbelanjadata['kd_program'].".".$cekbelanjadata['kd_sub_program'].".".$cekbelanjadata['kd_kegiatan']
                        .".".$cekbelanjadata['Kd_Rek_1']
                        .".".$cekbelanjadata['Kd_Rek_2']
                        .".".$cekbelanjadata['Kd_Rek_3']
                        .".".$cekbelanjadata['Kd_Rek_3']
                        .".".$cekbelanjadata['Kd_Rek_4']
                        .")</br>";
                    }
                }
                if($cekrencanabelanja){
                    $returnBelanja .= "Rencana Belanja Belum Terisi: ";
                    foreach($cekrencanabelanja as $cekrencanabelanjadata){
                        $returnBelanja.= "(".$cekrencanabelanjadata['kd_program'].".".$cekrencanabelanjadata['kd_sub_program'].".".$cekrencanabelanjadata['kd_kegiatan']
                        .".".$cekrencanabelanjadata['Kd_Rek_1']
                        .".".$cekrencanabelanjadata['Kd_Rek_2']
                        .".".$cekrencanabelanjadata['Kd_Rek_3']
                        .".".$cekrencanabelanjadata['Kd_Rek_3']
                        .".".$cekrencanabelanjadata['Kd_Rek_4']
                        .")</br>";
                    }
                }
                if($cekrencanapendapatan){
                    $returnBelanja .= "Rencana Belanja Belum Terisi: ";
                    foreach($cekrencanapendapatan as $cekrencanapendapatandata){
                        $returnBelanja.= "("
                        .".".$cekrencanapendapatandata['Kd_Rek_1']
                        .".".$cekrencanapendapatandata['Kd_Rek_2']
                        .".".$cekrencanapendapatandata['Kd_Rek_3']
                        .".".$cekrencanapendapatandata['Kd_Rek_3']
                        .".".$cekrencanapendapatandata['Kd_Rek_4']
                        .")</br>";
                    }
                }
                Yii::$app->getSession()->setFlash('danger',  "Posting gagal! Rincian belanja atau rencana pendapatan/belanja belum semua terisi.</br> $returnBelanja");
                return $this->redirect(Yii::$app->request->referrer);              
            }
        }

        return $this->render('index', [
            'Tahun' => $Tahun,
            'rencana' => $rencana,
            'induk' => $induk,
            'perubahan1' => $perubahan1,
            'pdt' => $pdt,
            'belanja' => $belanja,
            'btl' => $btl,
            'laporan' => $laporan
        ]);
    }

    public function actionCetak(){
        // K1 = 1
        // K2 = 2
        // 03 = 8
        // DPA = 10
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

        $get = new \app\models\Laporan();
        $Kd_Laporan = NULL;
        $data = NULL;
        $data1 = NULL;
        $data2 = NULL;
        $data3 = NULL;
        $data4 = NULL;
        $data5 = NULL;
        $data6 = NULL;
        $render = NULL;
        $getparam = NULL;
        IF(Yii::$app->request->queryParams){
            $getparam = Yii::$app->request->queryParams;
            $getparam['Laporan']['Kd_Sumber'] = "0.0";
            IF($getparam['Laporan']['Kd_Sumber'] <> NULL){
                list($kd_penerimaan_1, $kd_penerimaan_2) = explode('.', $getparam['Laporan']['Kd_Sumber']);
                IF($kd_penerimaan_1 == 0) $kd_penerimaan_1 = '%';
                IF($kd_penerimaan_2 == 0) $kd_penerimaan_2 = '%';
                $footerSumberDana = \app\models\RefPenerimaanSekolah2::find()->where(['kd_penerimaan_1' => $kd_penerimaan_1, 'kd_penerimaan_2' => $kd_penerimaan_2])->one();
            }
            IF($getparam['Laporan']['Kd_Laporan']){
                $Kd_Laporan = Yii::$app->request->queryParams['Laporan']['Kd_Laporan'];
                switch ($Kd_Laporan) {
                    case 1:
                        $data1 = \app\models\TaSaldoAwal::find()->where([
                            'tahun' => $Tahun,
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            ])->andWhere("IFNULL(kd_penerimaan_1,'') LIKE '$kd_penerimaan_1' AND IFNULL(kd_penerimaan_2,'') LIKE '$kd_penerimaan_2'");
                        $data2 = \app\models\TaRkasBelanjaRinc::find()->where([
                            'tahun' => $Tahun,
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            'Kd_Rek_1' => 4,
                            ]);
                        $data3 = \app\models\TaRkasBelanjaRinc::find()->where([
                            'tahun' => $Tahun,
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            'Kd_Rek_1' => 4,
                            ]);
                        $data5 = \app\models\TaRkasBelanjaRinc::find()->where([
                            'tahun' => $Tahun,
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            'Kd_Rek_1' => 4,
                            ]);
                        $data4 = \app\models\TaRkasBelanjaRinc::find()->where([
                            'tahun' => $Tahun,
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            'Kd_Rek_1' => 4,
                            ]);
                        $data = \app\models\TaRkasBelanjaRinc::find()
                            ->select(["kd_program", "SUM(total) AS total"])
                            ->where([
                            'tahun' => $Tahun,
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            'Kd_Rek_1' => 5,
                            ])->groupBy('kd_program')->orderBy('kd_program')->all();
                        $render = 'cetaklaporan1';
                        break;
                    case 2:
                        $data =  Yii::$app->db->createCommand("
                            SELECT a.tahun, a.sekolah_id, a.kd_program, c.uraian_program, a.kd_sub_program, d.uraian_sub_program, a.kd_kegiatan, e.uraian_kegiatan, a.Kd_Rek_1, a.anggaran, b.TW1, b.TW2, b.TW3, b.TW4 FROM
                            (
                                SELECT
                                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, SUM(a.total) AS anggaran
                                FROM
                                ta_rkas_history a
                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                                AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2,'') LIKE :kd_penerimaan_2
                                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                            ) a 
                            LEFT JOIN
                            (
                                SELECT
                                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1,
                                SUM(IFNULL(a.januari1,0) + IFNULL(a.februari1,0) + IFNULL(a.maret1,0)) AS TW1,
                                SUM(IFNULL(a.april1,0) + IFNULL(a.mei1,0) + IFNULL(a.juni1,0)) AS TW2,
                                SUM(IFNULL(a.juli,0) + IFNULL(a.agustus,0) + IFNULL(a.september,0)) AS TW3,
                                SUM(IFNULL(a.oktober,0) + IFNULL(a.november,0) + IFNULL(a.desember,0)) AS TW4
                                FROM
                                ta_rkas_belanja_rencana_history a
                                INNER JOIN 
                                (
                                    SELECT a.tahun, a.sekolah_id, a.perubahan_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2 , a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        FROM ta_rkas_history a
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                                        AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2,'') LIKE :kd_penerimaan_2
                                        GROUP BY a.tahun, a.sekolah_id, a.perubahan_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2 , a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                )b 
                                ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.perubahan_id = b.perubahan_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.kd_rek_5 = b.Kd_Rek_5
                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                                AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2,'') LIKE :kd_penerimaan_2
                                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                                UNION ALL
                                SELECT
                                a.tahun, a.sekolah_id, 0 AS kd_program, 0 AS kd_sub_program, 0 AS kd_kegiatan, a.Kd_Rek_1,
                                SUM(IFNULL(a.januari1,0) + IFNULL(a.februari1,0) + IFNULL(a.maret1,0)) AS TW1,
                                SUM(IFNULL(a.april1,0) + IFNULL(a.mei1,0) + IFNULL(a.juni1,0)) AS TW2,
                                SUM(IFNULL(a.juli,0) + IFNULL(a.agustus,0) + IFNULL(a.september,0)) AS TW3,
                                SUM(IFNULL(a.oktober,0) + IFNULL(a.november,0) + IFNULL(a.desember,0)) AS TW4
                                FROM
                                ta_rkas_pendapatan_rencana_history a
                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                                AND a.kd_penerimaan_1 LIKE :kd_penerimaan_1 AND a.kd_penerimaan_2 LIKE :kd_penerimaan_2
                                GROUP BY a.tahun, a.sekolah_id, a.Kd_Rek_1
                            ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan AND a.Kd_Rek_1 = b.Kd_Rek_1
                            INNER JOIN ref_program_sekolah c ON a.kd_program = c.kd_program
                            INNER JOIN ref_sub_program_sekolah d ON a.kd_program = d.kd_program AND a.kd_sub_program = d.kd_sub_program
                            INNER JOIN ref_kegiatan_sekolah e ON a.kd_program = e.kd_program AND a.kd_sub_program = e.kd_sub_program AND a.kd_kegiatan = e.kd_kegiatan
                            ORDER BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1 ASC                        
                        ")->bindValues([
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                        ])->queryAll();                    

                        $render = 'cetaklaporan2';
                        break;                                        
                    case 8:
                        $data =  Yii::$app->db->createCommand("  
                            SELECT
                            a.tahun, a.sekolah_id, IFNULL(a.komponen_id, 0) AS komponen_id, IFNULL(b.komponen, 'Non-Komponen BOS') AS komponen, a.Kd_Rek_1, SUM(a.total) AS anggaran
                            FROM
                            (
                                SELECT
                                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2, a.komponen_id,
                                SUM(b.total) AS total
                                FROM
                                ta_rkas_belanja AS a
                                INNER JOIN ta_rkas_belanja_rinc AS b ON b.tahun = a.tahun AND b.sekolah_id = a.sekolah_id AND b.kd_program = a.kd_program AND b.kd_sub_program = a.kd_sub_program AND b.kd_kegiatan = a.kd_kegiatan AND b.Kd_Rek_1 = a.Kd_Rek_1 AND b.Kd_Rek_2 = a.Kd_Rek_2 AND b.Kd_Rek_3 = a.Kd_Rek_3 AND b.Kd_Rek_4 = a.Kd_Rek_4 AND b.Kd_Rek_5 = a.Kd_Rek_5
                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id
                                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2, a.komponen_id
                            ) a
                            LEFT JOIN ref_komponen_bos b ON a.komponen_id = b.id
                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id
                            AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5
                            GROUP BY a.tahun, a.sekolah_id, a.komponen_id, a.Kd_Rek_1                                      
                        ")->bindValues([
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                        ])->queryAll();
                        $render = 'cetaklaporan8';
                        break; 
                    case 10:
                        $data =  Yii::$app->db->createCommand("
                        SELECT
                        a.kd_program, b.uraian_program,
                        a.kd_sub_program, c.uraian_sub_program,
                        a.kd_kegiatan, d.uraian_kegiatan,
                        a.Kd_Rek_1, j.Nm_Rek_1, a.Kd_Rek_2, e.Nm_Rek_2,
                        a.Kd_Rek_3, f.Nm_Rek_3,
                        a.Kd_Rek_4, g.Nm_Rek_4,
                        a.Kd_Rek_5, h.Nm_Rek_5,
                        a.sekolah_id, i.nama_sekolah,
                        a.keterangan, 
                        a.jml_satuan,
                        a.satuan123,
                        a.nilai_rp,
                        SUM(a.total) AS total
                        FROM (
                                SELECT
                                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan,
                                a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5,
                                b.no_rinc, b.keterangan, b.satuan123,b.jml_satuan,
                                b.nilai_rp, b.total
                                FROM
                                ta_rkas_belanja AS a
                                INNER JOIN ta_rkas_belanja_rinc AS b ON b.tahun = a.tahun AND b.sekolah_id = a.sekolah_id AND b.kd_program = a.kd_program AND b.kd_sub_program = a.kd_sub_program AND b.kd_kegiatan = a.kd_kegiatan AND b.Kd_Rek_1 = a.Kd_Rek_1 AND b.Kd_Rek_2 = a.Kd_Rek_2 AND b.Kd_Rek_3 = a.Kd_Rek_3 AND b.Kd_Rek_4 = a.Kd_Rek_4 AND b.Kd_Rek_5 = a.Kd_Rek_5
                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND
                                IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                        ) a
                        INNER JOIN ref_program_sekolah b ON a.kd_program = b.kd_program
                        INNER JOIN ref_sub_program_sekolah c ON a.kd_program = c.kd_program AND a.kd_sub_program = c.kd_sub_program
                        INNER JOIN ref_kegiatan_sekolah d ON a.kd_program = d.kd_program AND a.kd_sub_program = d.kd_sub_program AND a.kd_kegiatan = d.kd_kegiatan
                        INNER JOIN ref_rek_1 j ON a.Kd_Rek_1 = j.Kd_Rek_1
                        INNER JOIN ref_rek_2 e ON a.Kd_Rek_1 = e.Kd_Rek_1 AND a.Kd_Rek_2 =  e.Kd_Rek_2
                        INNER JOIN ref_rek_3 f ON a.Kd_Rek_1 = f.Kd_Rek_1 AND a.Kd_Rek_2 =  f.Kd_Rek_2 AND a.Kd_Rek_3 = f.Kd_Rek_3
                        INNER JOIN ref_rek_4 g ON a.Kd_Rek_1 = g.Kd_Rek_1 AND a.Kd_Rek_2 =  g.Kd_Rek_2 AND a.Kd_Rek_3 = g.Kd_Rek_3 AND a.Kd_Rek_4 = g.Kd_Rek_4
                        INNER JOIN ref_rek_5 h ON a.Kd_Rek_1 = h.Kd_Rek_1 AND a.Kd_Rek_2 =  h.Kd_Rek_2 AND a.Kd_Rek_3 = h.Kd_Rek_3 AND a.Kd_Rek_4 = h.Kd_Rek_4 AND a.Kd_Rek_5 = h.Kd_Rek_5
                        INNER JOIN ref_sekolah i ON a.sekolah_id = i.id
                        GROUP BY a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.jml_satuan, a.satuan123, a.nilai_rp, a.keterangan
                        ORDER BY a.Kd_Rek_1, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5 ASC                                       
                        ")->bindValues([
                            ':tahun' => $Tahun,
                            ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            ':kd_penerimaan_1' => $kd_penerimaan_1,
                            ':kd_penerimaan_2' => $kd_penerimaan_2
                        ])->queryAll();

                        $render = 'cetaklaporan10';                    
                        break;                                                
                    default:
                        # code...
                        break;
                }
            }

        }
        $sekolah = \app\models\RefSekolah::findOne(['id' => Yii::$app->user->identity->sekolah_id]);
        // $peraturan = \app\models\TaRkasPeraturan::findOne([
        //                     'tahun' => $Tahun,
        //                     'perubahan_id' => $getparam['Laporan']['perubahan_id'],
        //                     'sekolah_id' => Yii::$app->user->identity->sekolah_id,
        //                     ]);
        $references = \app\models\TaTh::findOne(['tahun' => $Tahun]);

        return $this->render($render, [
            'get' => $get,
            'Kd_Laporan' => $Kd_Laporan,
            'data' => $data,
            'data1' => $data1,
            'data2' => $data2,
            'data3' => $data3,
            'data4' => $data4,
            'data5' => $data5,
            'data6' => $data6,
            'render' => $render,
            'getparam' => $getparam,
            'Tahun' => $Tahun,
            'sekolah' => $sekolah,
            'ref' => $references,
            'footerSumberDana' => isset($footerSumberDana) ? $footerSumberDana : null,
        ]);
    }

    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 403])->one();
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
