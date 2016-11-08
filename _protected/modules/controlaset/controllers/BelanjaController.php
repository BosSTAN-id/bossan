<?php

namespace app\modules\controlaset\controllers;

use Yii;
use app\models\TaRASKArsip;
use yii\data\SqlDataProvider;
use app\modules\controlaset\models\TaRASKArsipSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        
        $searchModel = new TaRASKArsipSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=50;   
         
        /*
        $searchModel = new TaRASKArsipSearch();
        $tahun = (DATE('Y'));
        $connection = \Yii::$app->db;
        $perubahan = $connection->createCommand('SELECT MAX(Kd_Perubahan) AS Kd_Perubahan FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '.DATE('Y'));
        $Kd_Perubahan = $perubahan->queryOne();  
          
        $totalCount = Yii::$app->db->createCommand('
            SELECT COUNT(a.Tahun) AS jumlah FROM
                    (SELECT * FROM Ta_RASK_Arsip WHERE Tahun = :Tahun AND Kd_Perubahan = :Kd_Perubahan AND Kd_Urusan = :Kd_Urusan AND Kd_Bidang = :Kd_Bidang AND Kd_Unit = :Kd_Unit AND Kd_Sub = :Kd_Sub ) a
                    INNER JOIN
                    (
                    SELECT DISTINCT Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Prog, Id_Prog, Kd_Keg  FROM Ta_RASK_Arsip WHERE  Tahun = :Tahun AND Kd_Perubahan = :Kd_Perubahan AND Kd_Rek_1 = 5 AND Kd_Rek_2 = 2 AND Kd_Rek_3 = 3
                    AND Kd_Urusan = :Kd_Urusan AND Kd_Bidang = :Kd_Bidang AND Kd_Unit = :Kd_Unit AND Kd_Sub = :Kd_Sub
                    ) b ON a.Kd_Urusan = b.Kd_Urusan AND a.Kd_Bidang = b.Kd_Bidang AND a.Kd_Unit = b.Kd_Unit AND a.Kd_Sub = b.Kd_Sub AND a.Kd_Prog = b.Kd_Prog AND a.ID_Prog = b.ID_Prog AND a.Kd_Keg = b.Kd_Keg   
                    GROUP BY a.Tahun     
            ')
                    ->bindValue(':Tahun', $tahun)
                    ->bindValue(':Kd_Perubahan', $Kd_Perubahan['Kd_Perubahan'] )
                    ->bindValue(':Kd_Urusan', Yii::$app->user->identity->Kd_Urusan)
                    ->bindValue(':Kd_Bidang', Yii::$app->user->identity->Kd_Bidang)
                    ->bindValue(':Kd_Unit', Yii::$app->user->identity->Kd_Unit)
                    ->bindValue(':Kd_Sub', Yii::$app->user->identity->Kd_Sub)
                    ->queryScalar();
        var_dump($totalCount);
        
        $dataProvider = new SqlDataProvider([
            'sql' => '
                    SELECT a.* FROM
                    (SELECT * FROM Ta_RASK_Arsip WHERE Tahun = :Tahun AND Kd_Perubahan = :Kd_Perubahan AND Kd_Urusan = :Kd_Urusan AND Kd_Bidang = :Kd_Bidang AND Kd_Unit = :Kd_Unit AND Kd_Sub = :Kd_Sub ) a
                    INNER JOIN
                    (
                    SELECT DISTINCT Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Prog, Id_Prog, Kd_Keg  FROM Ta_RASK_Arsip WHERE  Tahun = :Tahun1 AND Kd_Perubahan = :Kd_Perubahan1 AND Kd_Rek_1 = 5 AND Kd_Rek_2 = 2 AND Kd_Rek_3 = 3
                    AND Kd_Urusan = :Kd_Urusan1 AND Kd_Bidang = :Kd_Bidang1 AND Kd_Unit = :Kd_Unit1 AND Kd_Sub = :Kd_Sub1
                    ) b ON a.Kd_Urusan = b.Kd_Urusan AND a.Kd_Bidang = b.Kd_Bidang AND a.Kd_Unit = b.Kd_Unit AND a.Kd_Sub = b.Kd_Sub AND a.Kd_Prog = b.Kd_Prog AND a.ID_Prog = b.ID_Prog AND a.Kd_Keg = b.Kd_Keg                  

                        ',
            'params' => [
                    ':Tahun' => $tahun,
                    ':Kd_Perubahan' => $Kd_Perubahan['Kd_Perubahan'],
                    ':Kd_Urusan' => Yii::$app->user->identity->Kd_Urusan,
                    ':Kd_Bidang' => Yii::$app->user->identity->Kd_Bidang,
                    ':Kd_Unit' => Yii::$app->user->identity->Kd_Unit,
                    ':Kd_Sub' => Yii::$app->user->identity->Kd_Sub,
                    ':Tahun1' => $tahun,
                    ':Kd_Perubahan1' => $Kd_Perubahan['Kd_Perubahan'],
                    ':Kd_Urusan1' => Yii::$app->user->identity->Kd_Urusan,
                    ':Kd_Bidang1' => Yii::$app->user->identity->Kd_Bidang,
                    ':Kd_Unit1' => Yii::$app->user->identity->Kd_Unit,
                    ':Kd_Sub1' => Yii::$app->user->identity->Kd_Sub,
            ],
            'totalCount' => 1234,
            'sort' =>false, // to remove the table header sorting
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
        //var_dump($dataProvider);*/
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    //This is for renderpartial render ajax of tab belanja-aset-kapitalisasi
    public function actionRealisasi() {
        $connection = \Yii::$app->db;
        $perubahan = $connection->createCommand('SELECT MAX(Kd_Perubahan) AS Kd_Perubahan FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '.DATE('Y'));
        $Kd_Perubahan = $perubahan->queryOne();      
        $totalCount = Yii::$app->db->createCommand('
                        SELECT
                        COUNT(c.No_SP2D) AS total
                        FROM Ta_RASK_Arsip_Aset a
                        INNER JOIN Ta_SPM_Rinc b ON a.Kd_Urusan = b.Kd_Urusan AND a.Kd_Bidang = b.Kd_Bidang AND a.Kd_Unit = b.Kd_Unit AND a.Kd_Sub = b.Kd_Sub AND a.Kd_Prog = b.Kd_Prog AND a.ID_Prog = b.ID_Prog AND a.Kd_Keg = b.Kd_Keg AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                        INNER JOIN Ta_SP2D c ON b.No_SPM = c.No_SPM
                        INNER JOIN Ta_Kegiatan d ON a.Kd_Prog = d.Kd_Prog AND a.ID_Prog = d.ID_Prog AND a.Kd_Keg = d.Kd_Keg
                        INNER JOIN Ref_Rek_5 e ON 
                        a.Kd_Rek_1_Aset = e.Kd_Rek_1 AND
                        a.Kd_Rek_2_Aset = e.Kd_Rek_2 AND
                        a.Kd_Rek_3_Aset = e.Kd_Rek_3 AND
                        a.Kd_Rek_4_Aset = e.Kd_Rek_4 AND
                        a.Kd_Rek_5_Aset = e.Kd_Rek_5
            ')
                    ->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => '
                        SELECT
                        c.No_SP2D, c.Tgl_SP2D,
                        a.Tahun, a.Kd_Perubahan, a.Kd_Urusan, a.Kd_Bidang, a.Kd_Unit, a.Kd_Sub, a.Kd_Prog, a.ID_Prog, a.Kd_Keg, d.Ket_Kegiatan,
                        a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.No_Rinc, a.No_ID, a.Kd_Rek_1_Aset, a.Kd_Rek_2_Aset, a.Kd_Rek_3_Aset, a.Kd_Rek_4_Aset, a.Kd_Rek_5_Aset, e. Nm_Rek_5,
                        a.Keterangan_Rinc,  b.Nilai, a.Total 
                        FROM Ta_RASK_Arsip_Aset a
                        INNER JOIN Ta_SPM_Rinc b ON a.Kd_Urusan = b.Kd_Urusan AND a.Kd_Bidang = b.Kd_Bidang AND a.Kd_Unit = b.Kd_Unit AND a.Kd_Sub = b.Kd_Sub AND a.Kd_Prog = b.Kd_Prog AND a.ID_Prog = b.ID_Prog AND a.Kd_Keg = b.Kd_Keg AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                        INNER JOIN Ta_SP2D c ON b.No_SPM = c.No_SPM
                        INNER JOIN Ta_Kegiatan d ON a.Kd_Prog = d.Kd_Prog AND a.ID_Prog = d.ID_Prog AND a.Kd_Keg = d.Kd_Keg
                        INNER JOIN Ref_Rek_5 e ON 
                        a.Kd_Rek_1_Aset = e.Kd_Rek_1 AND
                        a.Kd_Rek_2_Aset = e.Kd_Rek_2 AND
                        a.Kd_Rek_3_Aset = e.Kd_Rek_3 AND
                        a.Kd_Rek_4_Aset = e.Kd_Rek_4 AND
                        a.Kd_Rek_5_Aset = e.Kd_Rek_5
                        ',
            'totalCount' => $totalCount,
            'sort' =>false, // to remove the table header sorting
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
        $html = $this->renderPartial('tabrealisasi', ['dataProvider' => $dataProvider]);
        return \yii\helpers\Json::encode($html);
    }


    //This is for renderpartial render ajax of tab belanja-aset-kapitalisasi
    public function actionMemo() {
        $html = $this->renderPartial('tabmemo');
        return \yii\helpers\Json::encode($html);
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
        $model = $this->findModel($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Tahun' => $model->Tahun, 'Kd_Perubahan' => $model->Kd_Perubahan, 'Kd_Urusan' => $model->Kd_Urusan, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Prog' => $model->Kd_Prog, 'ID_Prog' => $model->ID_Prog, 'Kd_Keg' => $model->Kd_Keg, 'Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2, 'Kd_Rek_3' => $model->Kd_Rek_3, 'Kd_Rek_4' => $model->Kd_Rek_4, 'Kd_Rek_5' => $model->Kd_Rek_5, 'No_Rinc' => $model->No_Rinc, 'No_ID' => $model->No_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionSph($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID){

        $connection = \Yii::$app->db;           
        $skpd = $connection->createCommand('
            SELECT 
            CONVERT(VARCHAR(3), Kd_Rek_1, 0) + \'.\' + 
            CONVERT(VARCHAR(3), Kd_Rek_2, 0) + \'.\' + 
            CONVERT(VARCHAR(3), Kd_Rek_3, 0) + \'.\' + 
            CONVERT(VARCHAR(3), Kd_Rek_4, 0) + \'.\' + 
            CONVERT(VARCHAR(3), Kd_Rek_5, 0) AS Kd_Rek_5,
                CASE Kd_Rek_3
                    WHEN 1 THEN \'KIB-A\'
                    WHEN 2 THEN \'KIB-B\'
                    WHEN 3 THEN \'KIB-C\'
                    WHEN 4 THEN \'KIB-D\'
                    WHEN 5 THEN \'KIB-E\'
                    ELSE \'KIB-F\'
                END
                + \' - \' + Nm_Rek_5 AS Nm_Rek_5       
            FROM Ref_Rek_5 WHERE Kd_Rek_1 = 1 AND Kd_Rek_2 = 3
            ');
        $query = $skpd->queryAll();

        $arsip = $this->findModel($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID);
        $model = new \app\models\TaRASKArsipAset();

        if ($model->load(Yii::$app->request->post())) {
            list($model->Kd_Rek_1_Aset, $model->Kd_Rek_2_Aset, $model->Kd_Rek_3_Aset, $model->Kd_Rek_4_Aset, $model->Kd_Rek_5_Aset) = explode('.', $model->rekaset5);
            $model->Tahun = $Tahun;
            $model->Kd_Perubahan =  $arsip['Kd_Perubahan'];
            $model->Kd_Urusan =  $arsip['Kd_Urusan'];
            $model->Kd_Bidang =  $arsip['Kd_Bidang'];
            $model->Kd_Unit =  $arsip['Kd_Unit'];
            $model->Kd_Sub =  $arsip['Kd_Sub'];
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
            $model->DateCreate = $arsip['DateCreate'];
            IF($model->save())
            //return $this->redirect(['index']);
                return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->renderAjax('utang', [
                'model' => $model,
                'query' => $query,
            ]);
        }
    }    

    public function actionDeletesph($Tahun, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID)
    {
        $this->findArsiphutang($Tahun, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID)->delete();

        //return $this->redirect(['index']);
        return $this->redirect(Yii::$app->request->referrer);
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
        $this->findModel($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID)->delete();

        return $this->redirect(['index']);
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
}
