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

    public function actionRepost($no_peraturan)
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
        $model = \app\models\TaRkasPeraturan::findOne(['no_peraturan' => $no_peraturan]);
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
                        $returnBelanja.= "(".$cekrencanapendapatandata['kd_program'].".".$cekrencanapendapatandata['kd_sub_program'].".".$cekrencanapendapatandata['kd_kegiatan']
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
