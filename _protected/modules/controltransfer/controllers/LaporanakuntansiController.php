<?php

namespace app\modules\controltransfer\controllers;

use Yii;
use app\models\TaValidasiPembayaran;
use app\modules\controltransfer\models\TaValidasiPembayaranSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

/**
 * ValidasiController implements the CRUD actions for TaValidasiPembayaran model.
 */
class LaporanakuntansiController extends Controller
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
        IF(Yii::$app->user->identity->Kd_Urusan){
            $Kd_Urusan = Yii::$app->user->identity->Kd_Urusan;
            $Kd_Bidang = Yii::$app->user->identity->Kd_Bidang;
            $Kd_Unit = Yii::$app->user->identity->Kd_Unit;
            $Kd_Sub = Yii::$app->user->identity->Kd_Sub;        
        }

        $get = new \app\models\Laporan();
        $Kd_Laporan = NULL;
        $data = NULL;
        $render = NULL;
        $getparam = NULL;
        IF(Yii::$app->request->queryParams){
            $getparam = Yii::$app->request->queryParams;
            IF($getparam['Laporan']['Kd_Laporan']){
                $Kd_Laporan = Yii::$app->request->queryParams['Laporan']['Kd_Laporan'];
                switch ($Kd_Laporan) {
                    case 1:
                        $data = new ActiveDataProvider([
                            'query' => \app\models\TaTransSKPD::find()
                            ->where([
                                'tahun' => $Tahun,
                                 'Kd_Urusan'=> $Kd_Urusan,
                                 'Kd_Bidang'=> $Kd_Bidang,
                                 'Kd_Unit'=> $Kd_Unit,
                                 'Kd_Sub'=> $Kd_Sub,
                                 ])
                            // ->orderBy('Tahun DESC'),
                        ]);
                        $render = 'laporan1';
                        break;
                    case 2:
                        $data = new ActiveDataProvider([
                            'query' => \app\models\TaRASKArsipTransfer::find()
                            ->where([
                                'tahun' => $Tahun,
                                'Kd_Urusan'=> $Kd_Urusan,
                                'Kd_Bidang'=> $Kd_Bidang,
                                'Kd_Unit'=> $Kd_Unit,
                                'Kd_Sub'=> $Kd_Sub,
                                ])
                            // ->orderBy('Tahun DESC'),
                        ]);
                        $render = 'laporan2';
                        break;
                        // case 3: //IKI DURUNG
                        // $data = new ActiveDataProvider([
                        //     'query' => \app\models\TaTransSts::find()
                        //     ->select('ta_trans_sts.Tahun, ta_trans_sts.Kd_Trans_1, ta_trans_sts.Kd_Trans_2, ta_trans_sts.Kd_Trans_3, SUM(
                        //                 CASE WHEN D_K = 1 THEN ta_trans_sts.Nilai
                        //                         WHEN D_K = 2 THEN -(ta_trans_sts.Nilai)
                        //                 END
                        //         ) AS Nilai')
                        //     ->innerJoin('ta_trans_skpd')                        
                        //     ->where([
                        //         'ta_trans_sts.tahun' => $Tahun,
                        //         'ta_trans_skpd.Kd_Urusan'=> $Kd_Urusan,
                        //         'ta_trans_skpd.Kd_Bidang'=> $Kd_Bidang,
                        //         'ta_trans_skpd.Kd_Unit'=> $Kd_Unit,
                        //         'ta_trans_skpd.Kd_Sub'=> $Kd_Sub,
                        //         ])
                        //     ->groupBy('ta_trans_sts.Tahun, ta_trans_sts.Kd_Trans_1, ta_trans_sts.Kd_Trans_2, ta_trans_sts.Kd_Trans_3')
                        //     // ->orderBy('Tahun DESC'),
                        // ]);
                        // $render = 'laporan3';
                        // break;
                        case 4:
                        $data = new ActiveDataProvider([
                            'query' => \app\models\TaTransKontrak::find()
                            ->where([
                                'tahun' => $Tahun,
                                'Kd_Urusan'=> $Kd_Urusan,
                                'Kd_Bidang'=> $Kd_Bidang,
                                'Kd_Unit'=> $Kd_Unit,
                                'Kd_Sub'=> $Kd_Sub,
                                ])
                            // ->orderBy('Tahun DESC'),
                        ]);
                        $render = 'laporan4';
                        break;
                        case 5:

                        $totalCount = Yii::$app->db->createCommand("
                            SELECT
                                COUNT(a.Tahun) AS Tahun
                            FROM
                                ta_trans_kontrak AS a
                            INNER JOIN ta_kontrak AS b ON a.No_Kontrak = b.No_Kontrak
                            INNER JOIN ta_spp_kontrak AS c ON b.No_Kontrak = c.No_Kontrak
                            INNER JOIN ta_spm AS d ON d.No_SPP = c.No_SPP
                            INNER JOIN ta_sp2d AS e ON e.No_SPM = d.No_SPM
                            INNER JOIN ta_trans_3 AS f ON a.Tahun = f.Tahun
                            AND a.Kd_Trans_1 = f.Kd_Trans_1
                            AND a.Kd_Trans_2 = f.Kd_Trans_2
                            AND a.Kd_Trans_3 = f.Kd_Trans_3
                            INNER JOIN ta_trans_2 AS g ON f.Tahun = g.Tahun
                            AND f.Kd_Trans_1 = g.Kd_Trans_1
                            AND f.Kd_Trans_2 = g.Kd_Trans_2
                            WHERE
                                a.Tahun = :tahun
                            AND a.Kd_Urusan LIKE :Kd_Urusan
                            AND a.Kd_Bidang LIKE :Kd_Bidang
                            AND a.Kd_Unit LIKE :Kd_Unit
                            AND a.Kd_Sub LIKE :Kd_Sub      
                            ", [
                                ':tahun' => $Tahun,
                                ':Kd_Urusan' => Yii::$app->user->identity->Kd_Urusan <> NULL ?  Yii::$app->user->identity->Kd_Urusan : '%',
                                ':Kd_Bidang' => Yii::$app->user->identity->Kd_Urusan <> NULL ?  Yii::$app->user->identity->Kd_Bidang : '%',
                                ':Kd_Unit' => Yii::$app->user->identity->Kd_Urusan <> NULL ?  Yii::$app->user->identity->Kd_Unit : '%',
                                ':Kd_Sub' => Yii::$app->user->identity->Kd_Urusan <> NULL ?  Yii::$app->user->identity->Kd_Sub : '%',
                            ])->queryScalar();

                        $data = new SqlDataProvider([
                            'sql' => "
                                    SELECT
                                        a.Tahun,
                                        a.Kd_Trans_1,
                                        a.Kd_Trans_2,
                                        g.Nm_Bidang,
                                        a.Kd_Trans_3,
                                        f.Nm_Sub_Bidang,
                                        f.Pagu AS Pagu_Transfer,
                                        a.No_Kontrak,
                                        a.Pagu AS Pagu_TransferKontrak,
                                        b.Nilai AS Nilai_Kontrak,
                                        c.Nilai AS Nilai_SPP_Kontrak,
                                        e.No_SP2D,
                                        e.Tgl_SP2D
                                    FROM
                                        ta_trans_kontrak AS a
                                    INNER JOIN ta_kontrak AS b ON a.No_Kontrak = b.No_Kontrak
                                    INNER JOIN ta_spp_kontrak AS c ON b.No_Kontrak = c.No_Kontrak
                                    INNER JOIN ta_spm AS d ON d.No_SPP = c.No_SPP
                                    INNER JOIN ta_sp2d AS e ON e.No_SPM = d.No_SPM
                                    INNER JOIN ta_trans_3 AS f ON a.Tahun = f.Tahun
                                    AND a.Kd_Trans_1 = f.Kd_Trans_1
                                    AND a.Kd_Trans_2 = f.Kd_Trans_2
                                    AND a.Kd_Trans_3 = f.Kd_Trans_3
                                    INNER JOIN ta_trans_2 AS g ON f.Tahun = g.Tahun
                                    AND f.Kd_Trans_1 = g.Kd_Trans_1
                                    AND f.Kd_Trans_2 = g.Kd_Trans_2
                                    WHERE
                                        a.Tahun = :tahun
                                    AND a.Kd_Urusan LIKE :Kd_Urusan
                                    AND a.Kd_Bidang LIKE :Kd_Bidang
                                    AND a.Kd_Unit LIKE :Kd_Unit
                                    AND a.Kd_Sub LIKE :Kd_Sub      
                                    ",
                            'params' => [
                                ':tahun' => $Tahun,
                                ':Kd_Urusan' => Yii::$app->user->identity->Kd_Urusan <> NULL ?  Yii::$app->user->identity->Kd_Urusan : '%',
                                ':Kd_Bidang' => Yii::$app->user->identity->Kd_Urusan <> NULL ?  Yii::$app->user->identity->Kd_Bidang : '%',
                                ':Kd_Unit' => Yii::$app->user->identity->Kd_Urusan <> NULL ?  Yii::$app->user->identity->Kd_Unit : '%',
                                ':Kd_Sub' => Yii::$app->user->identity->Kd_Urusan <> NULL ?  Yii::$app->user->identity->Kd_Sub : '%',
                            ],
                            'totalCount' => $totalCount,
                            //'sort' =>false, to remove the table header sorting
                            'pagination' => [
                                'pageSize' => 10,
                            ],
                        ]);  
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
            'render' => $render,
            'getparam' => $getparam,
            'Tahun' => $Tahun
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
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 212])->one();
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
