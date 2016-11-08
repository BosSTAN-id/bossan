<?php
/*----------------------------------------------------------------------------------------------------------------------------//
Transfer menggunakan tabel Ta_Trans_SKPD, Ta_RASK_Arsip_Transfer sebagai baseline
Digunakan Ta_Trans_Kontrak Untuk SKPD Mengassign kontrak secara manual terutama untuk Kebutuhan bangub yang diberi kode 99 pada Kd_Trans_1
Dibuat oleh: Heru Arief Wijaya
//---------------------------------------------------------------------------------------------------------------------------*/
namespace app\modules\controltransfer\controllers;

use Yii;
use yii\base\Model;
use yii\helpers\Json;
use app\models\TaRASKArsip;
use app\modules\controltransfer\models\TaRASKArsipSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * BelanjaController implements the CRUD actions for TaRASKArsip model.
 */
class BelanjaController extends Controller
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
     * Lists all TaRASKArsip models.
     * @return mixed
     */
    public function actionIndex()
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $searchModel = new TaRASKArsipSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=50;


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
        $connection = \Yii::$app->db;
        $query = $connection->createCommand("
            SELECT
                a.Tahun,
                e.Kd_Trans_1,
                e.Jns_Transfer,
                d.Kd_Trans_2,
                d.Nm_Bidang,
                a.Kd_Trans_1,
                a.Kd_Trans_2,
                a.Kd_Trans_3,
                c.Nm_Sub_Bidang,
                a.Pagu,
                IFNULL(b.Total, 0) AS Total
            FROM
                (
                    SELECT
                        Tahun,
                        Kd_Trans_1,
                        Kd_Trans_2,
                        Kd_Trans_3,
                        Pagu
                    FROM
                        ta_trans_skpd
                    WHERE
                        Tahun = $Tahun
                    AND Kd_Urusan = $Kd_Urusan
                    AND Kd_Bidang = $Kd_Bidang
                    AND Kd_Unit = $Kd_Unit
                    AND Kd_Sub = $Kd_Sub
                ) a
            LEFT JOIN (
                SELECT
                    Tahun,
                    Kd_Trans_1,
                    Kd_Trans_2,
                    Kd_Trans_3,
                    SUM(Total) AS Total
                FROM
                    ta_rask_arsip_transfer
                WHERE
                    Tahun = $Tahun
                AND Kd_Urusan = $Kd_Urusan
                AND Kd_Bidang = $Kd_Bidang
                AND Kd_Unit = $Kd_Unit
                AND Kd_Sub = $Kd_Sub
                GROUP BY
                    Tahun,
                    Kd_Trans_1,
                    Kd_Trans_2,
                    Kd_Trans_3
            ) b ON a.Tahun = b.Tahun
            AND a.Kd_Trans_1 = b.Kd_Trans_1
            AND a.Kd_Trans_2 = b.Kd_Trans_2
            AND a.Kd_Trans_3 = b.Kd_Trans_3
            LEFT JOIN ta_trans_3 c ON a.Tahun = c.Tahun
            AND a.Kd_Trans_1 = c.Kd_Trans_1
            AND a.Kd_Trans_2 = c.Kd_Trans_2
            AND a.Kd_Trans_3 = c.Kd_Trans_3
            LEFT JOIN ta_trans_2 d ON a.Tahun = d.Tahun
            AND a.Kd_Trans_1 = d.Kd_Trans_1
            AND a.Kd_Trans_2 = d.Kd_Trans_2
            LEFT JOIN ta_trans_1 e ON a.Tahun = e.Tahun
            AND a.Kd_Trans_1 = e.Kd_Trans_1            
            ");
        $realisasi = $query->queryAll();               

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'realisasi' => $realisasi,
        ]);
    }

    /**
     * Displays a single TaRASKArsip model.
     * @param integer $Tahun
     * @param integer $Kd_Perubahan
     * @param integer $Kd_Urusan
     * @param integer $Kd_Bidang
     * @param integer $Kd_Unit
     * @param integer $Kd_Sub
     * @param integer $Kd_Prog
     * @param integer $ID_Prog
     * @param integer $Kd_Keg
     * @param integer $Kd_Rek_1
     * @param integer $Kd_Rek_2
     * @param integer $Kd_Rek_3
     * @param integer $Kd_Rek_4
     * @param integer $Kd_Rek_5
     * @param integer $No_Rinc
     * @param integer $No_ID
     * @return mixed
     */
    public function actionView($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->render('view', [
            'model' => $this->findModel($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID),
        ]);
    }

    /**
     * Creates a new TaRASKArsip model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $model = new TaRASKArsip();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Tahun' => $model->Tahun, 'Kd_Perubahan' => $model->Kd_Perubahan, 'Kd_Urusan' => $model->Kd_Urusan, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Prog' => $model->Kd_Prog, 'ID_Prog' => $model->ID_Prog, 'Kd_Keg' => $model->Kd_Keg, 'Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2, 'Kd_Rek_3' => $model->Kd_Rek_3, 'Kd_Rek_4' => $model->Kd_Rek_4, 'Kd_Rek_5' => $model->Kd_Rek_5, 'No_Rinc' => $model->No_Rinc, 'No_ID' => $model->No_ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TaRASKArsip model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $Tahun
     * @param integer $Kd_Perubahan
     * @param integer $Kd_Urusan
     * @param integer $Kd_Bidang
     * @param integer $Kd_Unit
     * @param integer $Kd_Sub
     * @param integer $Kd_Prog
     * @param integer $ID_Prog
     * @param integer $Kd_Keg
     * @param integer $Kd_Rek_1
     * @param integer $Kd_Rek_2
     * @param integer $Kd_Rek_3
     * @param integer $Kd_Rek_4
     * @param integer $Kd_Rek_5
     * @param integer $No_Rinc
     * @param integer $No_ID
     * @return mixed
     */
    public function actionUpdate($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $model = $this->findModel($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Tahun' => $model->Tahun, 'Kd_Perubahan' => $model->Kd_Perubahan, 'Kd_Urusan' => $model->Kd_Urusan, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Prog' => $model->Kd_Prog, 'ID_Prog' => $model->ID_Prog, 'Kd_Keg' => $model->Kd_Keg, 'Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2, 'Kd_Rek_3' => $model->Kd_Rek_3, 'Kd_Rek_4' => $model->Kd_Rek_4, 'Kd_Rek_5' => $model->Kd_Rek_5, 'No_Rinc' => $model->No_Rinc, 'No_ID' => $model->No_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDaftar($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3)
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

        $model = \app\models\TaRASKArsipTransfer::find()->where(['Tahun' => $Tahun, 'Kd_Trans_1' => $Kd_Trans_1, 'Kd_Trans_2' => $Kd_Trans_2, 'Kd_Trans_3' => $Kd_Trans_3])->all();
        /* Get all the articles for one author by using the author relation define in Articles */
        $dataProvider = new ActiveDataProvider([
            'query' => \app\models\TaRASKArsipTransfer::find()->where(['Tahun' => $Tahun, 'Kd_Trans_1' => $Kd_Trans_1, 'Kd_Trans_2' => $Kd_Trans_2, 'Kd_Trans_3' => $Kd_Trans_3]),
        ]);

        return $this->renderAjax('daftar', [
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]);
    }    

    public function actionSph($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID){
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }

        $connection = \Yii::$app->db;           
        $skpd = $connection->createCommand('SELECT CONCAT(a.Kd_Trans_1,".",a.Kd_Trans_2,".",a.Kd_Trans_3,".",a.Kd_Urusan,".",a.kd_bidang,".",a.Kd_Unit,".",a.Kd_Sub) AS kd, CONCAT(d.Jns_Transfer," - ",c.Nm_Bidang," - ",b.Nm_Sub_Bidang) AS Sub_Bidang
            FROM Ta_Trans_SKPD a
            INNER JOIN Ta_Trans_3 b ON a.Kd_Trans_1 = b.Kd_Trans_1 AND a.Kd_Trans_2 = b.Kd_Trans_2 AND a.Kd_Trans_3 = b.Kd_Trans_3
            INNER JOIN Ta_Trans_2 c ON a.Kd_Trans_1 = c.Kd_Trans_1 AND a.Kd_Trans_2 = c.Kd_Trans_2
            INNER JOIN Ta_Trans_1 d ON a.Kd_Trans_1 = d.Kd_Trans_1
            WHERE a.Tahun = '.$Tahun.' AND a.Kd_Urusan = '.$Kd_Urusan.' AND Kd_Bidang = '.$Kd_Bidang.' AND Kd_Unit = '.$Kd_Unit.' AND Kd_Sub = '.$Kd_Sub);
        $query = $skpd->queryAll();

        $arsip = $this->findModel($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID);
        $model = new \app\models\TaRASKArsipTransfer();

        if ($model->load(Yii::$app->request->post())) {
            $model->Tahun = $Tahun;
            list($model->Kd_Trans_1, $model->Kd_Trans_2, $model->Kd_Trans_3, $model->Kd_Urusan, $model->Kd_Bidang, $model->Kd_Unit, $model->Kd_Sub) = explode('.', $model->skpdtrans);
            /*     
            $model->Kd_Urusan =  Yii::$app->user->identity->Kd_Urusan;
            $model->Kd_Bidang =  Yii::$app->user->identity->Kd_Bidang;
            $model->Kd_Unit =  Yii::$app->user->identity->Kd_Unit;
            $model->Kd_Sub =  Yii::$app->user->identity->Kd_Sub;
            */
            $model->Kd_Prog = $Kd_Prog;
            $model->ID_Prog = $ID_Prog;
            $model->Kd_Keg = $Kd_Keg;
            $model->Kd_Rek_1 = $Kd_Rek_1;
            $model->Kd_Rek_2 = $Kd_Rek_2;
            $model->Kd_Rek_3 = $Kd_Rek_3;
            $model->Kd_Rek_4 = $Kd_Rek_4;
            $model->Kd_Rek_5 = $Kd_Rek_5;
            $model->No_Rinc = $No_Rinc;
            $model->No_ID = $No_ID;
            $model->Keterangan_Rinc = $arsip['Keterangan_Rinc'];
            $model->Sat_1 = $arsip['Sat_1'];
            $model->Nilai_1 = $arsip['Nilai_1'];
            $model->Sat_2 = $arsip['Sat_2'];
            $model->Nilai_2 = $arsip['Nilai_2'];
            $model->Sat_3 = $arsip['Sat_3'];
            $model->Nilai_3 = $arsip['Nilai_3'];
            $model->Satuan123 = $arsip['Satuan123'];
            $model->Jml_Satuan = $arsip['Jml_Satuan'];
            $model->Nilai_Rp = $arsip['Nilai_Rp'];
            $model->Total = $arsip['Total'];
            $model->Keterangan = $arsip['Keterangan'];
            $model->Kd_Ap_Pub = $arsip['Kd_Ap_Pub'];
            $model->Kd_Sumber = $arsip['Kd_Sumber'];
            $model->Kd_Status_Belanja = 3;
            IF($model->save()){
                echo 1;
                // return $this->redirect(Yii::$app->request->referrer);
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('utang', [
                'model' => $model,
                'query' => $query,
            ]);
        }
    }    

    public function actionDeletesph($Tahun, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $this->findArsiphutang($Tahun, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID)->delete();

        //return $this->redirect(['index']);
                return $this->redirect(Yii::$app->request->referrer);
    }    

    public function actionLanjutan($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID){
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }

        $sph = $this->findRekap();
        $arsip = $this->findModel($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID);
        $model = new \app\models\TaRASKArsipHutang();

        $model->Tahun = $Tahun;
        $model->Kd_Urusan =  Yii::$app->user->identity->Kd_Urusan;
        $model->Kd_Bidang =  Yii::$app->user->identity->Kd_Bidang;
        $model->Kd_Unit =  Yii::$app->user->identity->Kd_Unit;
        $model->Kd_Sub =  Yii::$app->user->identity->Kd_Sub;
        $model->Kd_Prog = $Kd_Prog;
        $model->ID_Prog = $ID_Prog;
        $model->Kd_Keg = $Kd_Keg;
        $model->Kd_Rek_1 = $Kd_Rek_1;
        $model->Kd_Rek_2 = $Kd_Rek_2;
        $model->Kd_Rek_3 = $Kd_Rek_3;
        $model->Kd_Rek_4 = $Kd_Rek_4;
        $model->Kd_Rek_5 = $Kd_Rek_5;
        $model->No_Rinc = $No_Rinc;
        $model->No_ID = $No_ID;
        $model->Keterangan_Rinc = $arsip['Keterangan_Rinc'];
        $model->Sat_1 = $arsip['Sat_1'];
        $model->Nilai_1 = $arsip['Nilai_1'];
        $model->Sat_2 = $arsip['Sat_2'];
        $model->Nilai_2 = $arsip['Nilai_2'];
        $model->Sat_3 = $arsip['Sat_3'];
        $model->Nilai_3 = $arsip['Nilai_3'];
        $model->Satuan123 = $arsip['Satuan123'];
        $model->Jml_Satuan = $arsip['Jml_Satuan'];
        $model->Nilai_Rp = $arsip['Nilai_Rp'];
        $model->Total = $arsip['Total'];
        $model->Keterangan = $arsip['Keterangan'];
        $model->Kd_Ap_Pub = $arsip['Kd_Ap_Pub'];
        $model->Kd_Sumber = $arsip['Kd_Sumber'];
        $model->Kd_Status_Belanja = 2;
        var_dump($model);
        IF($model->save())
        return $this->redirect(['index']);
    }      

    /**
     * Deletes an existing TaRASKArsip model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $Tahun
     * @param integer $Kd_Perubahan
     * @param integer $Kd_Urusan
     * @param integer $Kd_Bidang
     * @param integer $Kd_Unit
     * @param integer $Kd_Sub
     * @param integer $Kd_Prog
     * @param integer $ID_Prog
     * @param integer $Kd_Keg
     * @param integer $Kd_Rek_1
     * @param integer $Kd_Rek_2
     * @param integer $Kd_Rek_3
     * @param integer $Kd_Rek_4
     * @param integer $Kd_Rek_5
     * @param integer $No_Rinc
     * @param integer $No_ID
     * @return mixed
     */
    public function actionDelete($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $this->findModel($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID)->delete();

        return $this->redirect(['index']);
    }

    public function actionKegiatan() {
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }  

        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $Program = $parents[0];
                list($Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog) = explode('.', $Program);
                $out = \app\models\TaKegiatan::find()
                           ->where([
                            'Tahun' => $Tahun,
                            'Kd_Urusan'=>$Kd_Urusan,
                            'Kd_Bidang'=>$Kd_Bidang,
                            'Kd_Unit'=>$Kd_Unit,
                            'Kd_Sub'=>$Kd_Sub,
                            'Kd_Prog' => $Kd_Prog,
                            'ID_Prog' => $ID_Prog
                            ])
                           ->select(['Kd_Keg AS id','Ket_Kegiatan AS name'])->asArray()->all();
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }    

    /**
     * Finds the TaRASKArsip model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $Tahun
     * @param integer $Kd_Perubahan
     * @param integer $Kd_Urusan
     * @param integer $Kd_Bidang
     * @param integer $Kd_Unit
     * @param integer $Kd_Sub
     * @param integer $Kd_Prog
     * @param integer $ID_Prog
     * @param integer $Kd_Keg
     * @param integer $Kd_Rek_1
     * @param integer $Kd_Rek_2
     * @param integer $Kd_Rek_3
     * @param integer $Kd_Rek_4
     * @param integer $Kd_Rek_5
     * @param integer $No_Rinc
     * @param integer $No_ID
     * @return TaRASKArsip the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID)
    {
        if (($model = TaRASKArsip::findOne(['Tahun' => $Tahun, 'Kd_Perubahan' => $Kd_Perubahan, 'Kd_Urusan' => $Kd_Urusan, 'Kd_Bidang' => $Kd_Bidang, 'Kd_Unit' => $Kd_Unit, 'Kd_Sub' => $Kd_Sub, 'Kd_Prog' => $Kd_Prog, 'ID_Prog' => $ID_Prog, 'Kd_Keg' => $Kd_Keg, 'Kd_Rek_1' => $Kd_Rek_1, 'Kd_Rek_2' => $Kd_Rek_2, 'Kd_Rek_3' => $Kd_Rek_3, 'Kd_Rek_4' => $Kd_Rek_4, 'Kd_Rek_5' => $Kd_Rek_5, 'No_Rinc' => $No_Rinc, 'No_ID' => $No_ID])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findRekap($Tahun)
    {
        if (($model = \app\models\TaTransSKPD::find(['Tahun' => $Tahun,'Kd_Urusan' => Yii::$app->user->identity->Kd_Urusan, 'Kd_Bidang' => Yii::$app->user->identity->Kd_Bidang, 'Kd_Unit' => Yii::$app->user->identity->Kd_Unit, 'Kd_Sub' => Yii::$app->user->identity->Kd_Sub])->all()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }    

    protected function findArsiphutang($Tahun, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID)
    {
        if (($model = \app\models\TaRASKArsipTransfer::findOne(['Tahun' => $Tahun, 'Kd_Urusan' => $Kd_Urusan, 'Kd_Bidang' => $Kd_Bidang, 'Kd_Unit' => $Kd_Unit, 'Kd_Sub' => $Kd_Sub, 'Kd_Prog' => $Kd_Prog, 'ID_Prog' => $ID_Prog, 'Kd_Keg' => $Kd_Keg, 'Kd_Rek_1' => $Kd_Rek_1, 'Kd_Rek_2' => $Kd_Rek_2, 'Kd_Rek_3' => $Kd_Rek_3, 'Kd_Rek_4' => $Kd_Rek_4, 'Kd_Rek_5' => $Kd_Rek_5, 'No_Rinc' => $No_Rinc, 'No_ID' => $No_ID])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }      

    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 201])->one();
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
