<?php

namespace app\modules\pelaporan\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

/**
 * ValidasiController implements the CRUD actions for TaValidasiPembayaran model.
 */
class PelaporansekolahController extends Controller
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
            IF($getparam['Laporan']['Kd_Sumber'] <> NULL){
                list($kd_penerimaan_1, $kd_penerimaan_2) = explode('.', $getparam['Laporan']['Kd_Sumber']);
                IF($kd_penerimaan_1 == 0) $kd_penerimaan_1 = '%';
                IF($kd_penerimaan_2 == 0) $kd_penerimaan_2 = '%';
            }
            IF($getparam['Laporan']['Kd_Laporan']){
                $Kd_Laporan = Yii::$app->request->queryParams['Laporan']['Kd_Laporan'];
                switch ($Kd_Laporan) {
                    case 1:
                        $data1 = \app\models\TaSaldoAwal::find()->where([
                            'tahun' => $Tahun,
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            ])->andWhere("kd_penerimaan_1 LIKE '$kd_penerimaan_1' AND kd_penerimaan_2 LIKE '$kd_penerimaan_2'");
                        $data2 = \app\models\TaRkasHistory::find()->where([
                            'tahun' => $Tahun,
                            'perubahan_id' => $getparam['Laporan']['perubahan_id'],
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            'Kd_Rek_1' => 4,
                            ])->andWhere("kd_penerimaan_1 LIKE '$kd_penerimaan_1' AND kd_penerimaan_2 LIKE '$kd_penerimaan_2'");
                        $data3 = \app\models\TaRkasHistory::find()->where([
                            'tahun' => $Tahun,
                            'perubahan_id' => $getparam['Laporan']['perubahan_id'],
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            'Kd_Rek_1' => 4,
                            ])->andWhere("kd_penerimaan_1 LIKE '$kd_penerimaan_1' AND kd_penerimaan_2 LIKE '$kd_penerimaan_2'");
                        $data5 = \app\models\TaRkasHistory::find()->where([
                            'tahun' => $Tahun,
                            'perubahan_id' => $getparam['Laporan']['perubahan_id'],
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            'Kd_Rek_1' => 4,
                            ])->andWhere("kd_penerimaan_1 LIKE '$kd_penerimaan_1' AND kd_penerimaan_2 LIKE '$kd_penerimaan_2'");
                        $data4 = \app\models\TaRkasHistory::find()->where([
                            'tahun' => $Tahun,
                            'perubahan_id' => $getparam['Laporan']['perubahan_id'],
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            'Kd_Rek_1' => 4,
                            ])->andWhere("kd_penerimaan_1 LIKE '$kd_penerimaan_1' AND kd_penerimaan_2 LIKE '$kd_penerimaan_2'");
                        $data = \app\models\TaRkasHistory::find()
                            ->select(["kd_program", "SUM(total) AS total"])
                            ->where([
                            'tahun' => $Tahun,
                            'perubahan_id' => $getparam['Laporan']['perubahan_id'],
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            'Kd_Rek_1' => 5,
                            ])->andWhere("kd_penerimaan_1 LIKE '$kd_penerimaan_1' AND kd_penerimaan_2 LIKE '$kd_penerimaan_2'")->groupBy('kd_program')->orderBy('kd_program')->all();
                        // $data = new ActiveDataProvider([
                        //     'query' => \app\models\TaSPH::find()->where("Tahun <= $Tahun")->andWhere('Saldo > 0')
                        // ]);
                        // IF(Yii::$app->user->identity->Kd_Urusan){
                        //     $data->query->andWhere([
                        //                      'ta_sph.Kd_Urusan'=> Yii::$app->user->identity->Kd_Urusan,
                        //                      'ta_sph.Kd_Bidang'=> Yii::$app->user->identity->Kd_Bidang,
                        //                      'ta_sph.Kd_Unit'=> Yii::$app->user->identity->Kd_Unit,
                        //                      'ta_sph.Kd_Sub'=> Yii::$app->user->identity->Kd_Sub,
                        //                      ]);
                        // }

                        // IF(isset($getparam['RefSubUnit']['skpd'])){
                        //     list($Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub) = explode('.', $getparam['RefSubUnit']['skpd']);
                        //     $data->query->andWhere([
                        //                      'ta_sph.Kd_Urusan'=> $Kd_Urusan,
                        //                      'ta_sph.Kd_Bidang'=> $Kd_Bidang,
                        //                      'ta_sph.Kd_Unit'=> $Kd_Unit,
                        //                      'ta_sph.Kd_Sub'=> $Kd_Sub,
                        //                      ]);
                        // }                        
                        // $data->query->orderBy('Tahun DESC');  
                        $render = 'laporan1';
                        break;
                    case 2:
                        $searchModel = new \app\modules\controlhutang\models\BelanjakontrolSearch();
                        // $searchModel->search->andWhere(['Tahun' => $Tahun]);
                        $data = $searchModel->search(Yii::$app->request->queryParams);


                        IF(isset($getparam['RefSubUnit']['skpd'])){
                            list($Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub) = explode('.', $getparam['RefSubUnit']['skpd']);
                            $data->query->andWhere([
                                             'Kd_Urusan'=> $Kd_Urusan,
                                             'Kd_Bidang'=> $Kd_Bidang,
                                             'Kd_Unit'=> $Kd_Unit,
                                             'Kd_Sub'=> $Kd_Sub,
                                             ]);
                        }

                        $render = 'laporan2';
                        break;                   
                    case 3:
                        $data = new ActiveDataProvider([
                            'query' => \app\models\TaRPH::find()->where(['Tahun' => $Tahun])->orderBy('Tahun DESC'),
                        ]);
                        IF(Yii::$app->user->identity->Kd_Urusan){
                            $data->query->andWhere([
                                             'Kd_Urusan'=> Yii::$app->user->identity->Kd_Urusan,
                                             'Kd_Bidang'=> Yii::$app->user->identity->Kd_Bidang,
                                             'Kd_Unit'=> Yii::$app->user->identity->Kd_Unit,
                                             'Kd_Sub'=> Yii::$app->user->identity->Kd_Sub,
                                             ]);
                        }

                        IF(isset($getparam['RefSubUnit']['skpd'])){
                            list($Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub) = explode('.', $getparam['RefSubUnit']['skpd']);
                            $data->query->andWhere([
                                             'Kd_Urusan'=> $Kd_Urusan,
                                             'Kd_Bidang'=> $Kd_Bidang,
                                             'Kd_Unit'=> $Kd_Unit,
                                             'Kd_Sub'=> $Kd_Sub,
                                             ]);
                        }                        
                        $data->query->orderBy('Tahun DESC');                        
                        $render = 'laporan3';
                        break;
                    case 4:

                        IF(Yii::$app->user->identity->Kd_Urusan){
                            $Kd_Urusan = Yii::$app->user->identity->Kd_Urusan;
                            $Kd_Bidang = Yii::$app->user->identity->Kd_Bidang;
                            $Kd_Unit = Yii::$app->user->identity->Kd_Unit;
                            $Kd_Sub = Yii::$app->user->identity->Kd_Sub;
                        }

                        IF(isset($getparam['RefSubUnit']['skpd']) && $getparam['RefSubUnit']['skpd'] <> NULL){
                            list($Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub) = explode('.', $getparam['RefSubUnit']['skpd']);
                        } 
                        $totalCount = Yii::$app->db->createCommand("
                            SELECT
                                COUNT(a.Tahun) AS Tahun
                            FROM
                                        ta_sph AS a
                                        INNER JOIN ta_rph AS b ON b.No_SPH = a.No_SPH
                                        INNER JOIN ta_sp2d AS c ON c.No_SPM = b.No_SPM
                            WHERE
                                c.Tahun = :tahun
                            AND c.Tgl_SP2D <= :Tgl_2 
                            AND c.Tgl_SP2D >= :Tgl_1                                
                            AND a.Kd_Urusan LIKE :Kd_Urusan
                            AND a.Kd_Bidang LIKE :Kd_Bidang
                            AND a.Kd_Unit LIKE :Kd_Unit
                            AND a.Kd_Sub LIKE :Kd_Sub      
                            ", [
                                ':tahun' => $Tahun,
                                ':Tgl_1' => $getparam['Laporan']['Tgl_1'],
                                ':Tgl_2' => $getparam['Laporan']['Tgl_2'],
                                ':Kd_Urusan' => isset($Kd_Urusan) <> NULL ?  $Kd_Urusan : '%',
                                ':Kd_Bidang' => isset($Kd_Urusan) <> NULL ?  $Kd_Bidang : '%',
                                ':Kd_Unit' => isset($Kd_Urusan) <> NULL ?  $Kd_Unit : '%',
                                ':Kd_Sub' => isset($Kd_Urusan) <> NULL ?  $Kd_Sub : '%',
                            ])->queryScalar();

                        $data = new SqlDataProvider([
                            'sql' => "
                                     SELECT
                                        a.Tahun,
                                        a.No_SPH,
                                        a.Nilai,
                                        a.Saldo,
                                        b.No_RPH,
                                        b.Tgl_RPH,
                                        a.Tgl_SPH,
                                        b.Nilai_Bayar,
                                        c.No_SP2D
                                        FROM
                                        ta_sph AS a
                                        INNER JOIN ta_rph AS b ON b.No_SPH = a.No_SPH
                                        INNER JOIN ta_sp2d AS c ON c.No_SPM = b.No_SPM
                                    WHERE
                                        c.Tahun = :tahun
                                    AND c.Tgl_SP2D <= :Tgl_2 
                                    AND c.Tgl_SP2D >= :Tgl_1
                                    AND a.Kd_Urusan LIKE :Kd_Urusan
                                    AND a.Kd_Bidang LIKE :Kd_Bidang
                                    AND a.Kd_Unit LIKE :Kd_Unit
                                    AND a.Kd_Sub LIKE :Kd_Sub
                                    ORDER BY a.Tahun, a.No_SPH ASC
                                    ",
                            'params' => [
                                ':tahun' => $Tahun,
                                ':Tgl_1' => $getparam['Laporan']['Tgl_1'],
                                ':Tgl_2' => $getparam['Laporan']['Tgl_2'],
                                ':Kd_Urusan' => isset($Kd_Urusan) <> NULL ?  $Kd_Urusan : '%',
                                ':Kd_Bidang' => isset($Kd_Urusan) <> NULL ?  $Kd_Bidang : '%',
                                ':Kd_Unit' => isset($Kd_Urusan) <> NULL ?  $Kd_Unit : '%',
                                ':Kd_Sub' => isset($Kd_Urusan) <> NULL ?  $Kd_Sub : '%',
                            ],
                            'totalCount' => $totalCount,
                            //'sort' =>false, to remove the table header sorting
                            'pagination' => [
                                'pageSize' => 10,
                            ],
                        ]);                                  
                        $render = 'laporan4';
                        break;
                    case 5:
                        $searchModel = new \app\modules\controlhutang\models\BelanjakontrolSearch();
                        // $searchModel->search->andWhere(['Tahun' => $Tahun]);
                        $data = $searchModel->search(Yii::$app->request->queryParams);
                        $render = 'laporan5';
                        break;
                    default:
                        # code...
                        break;
                }
            }

        }

        return $this->render('index', [
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
        ]);
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
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 601])->one();
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
