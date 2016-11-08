<?php

namespace app\modules\controlhutang\controllers;

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
                            'query' => \app\models\TaSPH::find()->where("Tahun <= $Tahun")->andWhere('Saldo > 0')
                                        ->andWhere([
                                             'Kd_Urusan'=> Yii::$app->user->identity->Kd_Urusan,
                                             'Kd_Bidang'=> Yii::$app->user->identity->Kd_Bidang,
                                             'Kd_Unit'=> Yii::$app->user->identity->Kd_Unit,
                                             'Kd_Sub'=> Yii::$app->user->identity->Kd_Sub,
                                             ])
                                        ->orderBy('Tahun DESC'),
                        ]);
                        $render = 'laporan1';
                        break;
                    case 2:
                        $searchModel = new \app\modules\controlhutang\models\BelanjakontrolSearch();
                        // $searchModel->search->andWhere(['Tahun' => $Tahun]);
                        $data = $searchModel->search(Yii::$app->request->queryParams);
                        $render = 'laporan2';
                        break;                    
                    case 3:
                        $data = new ActiveDataProvider([
                            'query' => \app\models\TaRPH::find()->where(['Tahun' => $Tahun])->orderBy('Tahun DESC'),
                        ]);
                        $render = 'laporan3';
                        break;
                    case 4:

                        $totalCount = Yii::$app->db->createCommand("
                            SELECT
                                COUNT(a.Tahun) AS Tahun
                            FROM
                                ta_sph AS a
                            INNER JOIN ta_rph AS b ON b.Tahun = a.Tahun
                            AND b.Kd_Urusan = a.Kd_Urusan
                            AND b.Kd_Bidang = a.Kd_Bidang
                            AND b.Kd_Unit = a.Kd_Unit
                            AND b.Kd_Sub = a.Kd_Sub
                            AND b.No_SPH = a.No_SPH
                            INNER JOIN ta_sp2d AS c ON c.No_SPM = b.No_SPM
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
                                    INNER JOIN ta_rph AS b ON b.Tahun = a.Tahun
                                    AND b.Kd_Urusan = a.Kd_Urusan
                                    AND b.Kd_Bidang = a.Kd_Bidang
                                    AND b.Kd_Unit = a.Kd_Unit
                                    AND b.Kd_Sub = a.Kd_Sub
                                    AND b.No_SPH = a.No_SPH
                                    INNER JOIN ta_sp2d AS c ON c.No_SPM = b.No_SPM
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
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 112])->one();
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
