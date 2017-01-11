<?php

namespace app\modules\penatausahaan\controllers;

use Yii;
use app\models\TaSPJ;
use app\modules\penatausahaan\models\TaSPJSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SpjController implements the CRUD actions for TaSPJ model.
 */
class VerspjController extends Controller
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
     * Lists all TaSPJ models.
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
        $searchModel = new TaSPJSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tahun' => $Tahun]);
        $dataProvider->query->orderBy('kd_sah ASC');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }

    /**
     * Displays a single TaSPJ model.
     * @param string $tahun
     * @param string $no_spj
     * @return mixed
     */
    public function actionView($tahun, $no_spj)
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
        return $this->renderAjax('view', [
            'model' => $this->findModel($tahun, $no_spj),
        ]);
    }

    public function actionPrint($tahun, $no_spj)
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

        $model = $this->findModel($tahun, $no_spj);
        //query untuk halaman SPJ
        $sekolah = $model->sekolah_id;
        $tgl_spj = $model->tgl_spj;
        $spjdata = \Yii::$app->db->createCommand("
            SELECT a.tahun, a.sekolah_id, a.kd_program, c.uraian_program, a.kd_sub_program, d.uraian_sub_program, a.kd_kegiatan, e.uraian_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, h.Nm_Rek_5, a.anggaran,
            IFNULL(f.nilai,0) AS spjlalu, IFNULL(g.nilai,0) AS spjini, (IFNULL(f.nilai,0) + IFNULL(g.nilai,0)) AS sdspjini, (a.anggaran - (IFNULL(f.nilai,0) + IFNULL(g.nilai,0))) AS sisa_anggaran
            FROM
            (
                SELECT 
                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.anggaran, b.nilai
                FROM
                (
                    SELECT
                    a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, SUM(a.total) AS anggaran
                    FROM
                    ta_rkas_history a
                    WHERE a.tahun = $tahun AND a.sekolah_id = $sekolah AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = $tahun AND sekolah_id = 1 AND tgl_peraturan <= '$tgl_spj')
                    GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5
                )a INNER JOIN
                (
                    SELECT a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, SUM(a.nilai) AS nilai
                    FROM ta_spj_rinc a WHERE a.tahun = $tahun AND a.sekolah_id = $sekolah AND a.tgl_bukti <= '$tgl_spj' AND a.no_spj IS NOT NULL
                    GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5
                )b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan
                    AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
            ) a 
            -- Untuk saldo s/d spj lalu
            LEFT JOIN
            (
                SELECT
                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5,
                SUM(a.nilai) AS nilai
                FROM
                ta_spj_rinc AS a
                LEFT JOIN
                (
                    SELECT 
                    a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                    FROM ta_rkas_history a 
                    WHERE a.tahun = $tahun AND a.sekolah_id = $sekolah AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = $tahun AND sekolah_id = 1 AND tgl_peraturan <= '$tgl_spj')
                    GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                WHERE a.tahun = $tahun AND a.sekolah_id = $sekolah AND a.tgl_bukti <= '$tgl_spj' AND a.no_spj IS NOT NULL AND a.no_spj <> '$no_spj'
                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5
            ) f ON a.tahun = f.tahun AND a.sekolah_id = f.sekolah_id AND a.kd_program = f.kd_program AND a.kd_sub_program = f.kd_sub_program AND a.kd_kegiatan = f.kd_kegiatan AND a.Kd_Rek_1 = f.Kd_Rek_1 AND a.Kd_rek_2 = f.Kd_Rek_2 AND a.Kd_Rek_3 = f.Kd_Rek_3 AND a.Kd_Rek_4 = f.Kd_Rek_4 AND a.Kd_Rek_5 = f.Kd_Rek_5
            -- Untuk saldo s/d spj saat ini
            LEFT JOIN
            (
                SELECT
                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5,
                SUM(a.nilai) AS nilai
                FROM
                ta_spj_rinc AS a
                LEFT JOIN
                (
                    SELECT 
                    a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                    FROM ta_rkas_history a 
                    WHERE a.tahun = $tahun AND a.sekolah_id = $sekolah AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = $tahun AND sekolah_id = 1 AND tgl_peraturan <= '$tgl_spj')
                    GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                WHERE a.tahun = $tahun AND a.sekolah_id = $sekolah AND a.tgl_bukti <= '$tgl_spj' AND a.no_spj = '$no_spj'
                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5
            ) g ON a.tahun = g.tahun AND a.sekolah_id = g.sekolah_id AND a.kd_program = g.kd_program AND a.kd_sub_program = g.kd_sub_program AND a.kd_kegiatan = g.kd_kegiatan AND a.Kd_Rek_1 = g.Kd_Rek_1 AND a.Kd_rek_2 = g.Kd_Rek_2 AND a.Kd_Rek_3 = g.Kd_Rek_3 AND a.Kd_Rek_4 = g.Kd_Rek_4 AND a.Kd_Rek_5 = g.Kd_Rek_5
            LEFT JOIN ref_program_sekolah c ON a.kd_program = c.kd_program
            LEFT JOIN ref_sub_program_sekolah d ON a.kd_program = d.kd_program AND a.kd_sub_program = d.kd_sub_program
            LEFT JOIN ref_kegiatan_sekolah e ON a.kd_program = e.kd_program AND a.kd_sub_program = e.kd_sub_program AND a.kd_kegiatan = e.kd_kegiatan
            LEFT JOIN ref_rek_5 h ON a.Kd_Rek_1 = h.Kd_Rek_1 AND a.Kd_Rek_2 = h.Kd_Rek_2 AND a.Kd_Rek_3 = h.Kd_Rek_3 AND a.Kd_Rek_4 = h.Kd_Rek_4 AND a.Kd_Rek_5 = h.Kd_Rek_5
            ORDER BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5 ASC
            ");
        $data = $spjdata->queryAll();        
        //find all bukti
        $bukti = $this->findBukti($tahun, $no_spj);

        return $this->render('print', [
            'model' => $model,
            'data' => $data,
            'bukti' => $bukti,
        ]);
    }     

    public function actionSpjbukti($tahun, $no_spj)
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
        $model = $this->findModel($tahun, $no_spj);
        $searchModel = new \app\modules\penatausahaan\models\TaSPJRincSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tahun' => $Tahun]);
        $dataProvider->query->andWhere('(Kd_Rek_1 = 5)');
        IF(Yii::$app->user->identity->sekolah_id && $sekolah_id = Yii::$app->user->identity->sekolah_id){
            $dataProvider->query->andWhere(['sekolah_id' => $sekolah_id]);
        }
        $dataProvider->query->andWhere("tgl_bukti <= '".$model->tgl_spj."'");

        $dataProvider->query->andWhere(['no_spj' => $model->no_spj]);


        IF(isset($_POST) AND $_POST <> NULL){
            // var_dump($_POST); 
            foreach ($_POST['selection'] as $value) {
                //convert to array, array key tahun, no_bukti, tgl_bukti
                $data = \yii\helpers\Json::decode($value);
                $bukti = \app\models\TaSPJRinc::findOne(['tahun' => $data['tahun'], 'no_bukti' => $data['no_bukti'] ]);
                $bukti->no_spj = $no_spj;

                $bukti->save();

                // print_r($data);
                // echo '-';
                // print_r($data['tahun']);
                // echo '-';
                // print_r($data['no_bukti']);
                // echo '</br>';
            }
        }

        return $this->render('spjbukti', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }  

    public function actionAssign()
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
        var_dump($_POST);   
        // return $this->render('spjbukti', [
        //     'model' => $model,
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        //     'Tahun' => $Tahun,
        // ]);
    }        

    /**
     * Creates a new TaSPJ model.
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

        $model = new TaSPJ();
        $model->tahun = $Tahun;
        $model->sekolah_id = Yii::$app->user->identity->sekolah_id;
        $model->kd_sah = 1;
        $model->kd_verifikasi = 0;
        $model->user_id = Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post())) {
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
     * Updates an existing TaSPJ model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $tahun
     * @param string $no_spj
     * @return mixed
     */
    public function actionUpdate($tahun, $no_spj)
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

        $model = $this->findModel($tahun, $no_spj);
        IF($model->kd_sah <> 1){
            Yii::$app->getSession()->setFlash('warning',  'SPJ ini sudah diproses Tata Usaha, tidak dapat diubah atau dihapus.');
            return $this->redirect(Yii::$app->request->referrer);
        }        

        if ($model->load(Yii::$app->request->post())) {
            \app\models\TaSPJRinc::updateAll(['no_spj' => $model->no_spj], 'no_spj = \''.$no_spj.'\'');
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
     * Deletes an existing TaSPJ model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $tahun
     * @param string $no_spj
     * @return mixed
     */
    public function actionDelete($tahun, $no_spj)
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
        $model = $this->findModel($tahun, $no_spj);
        IF($model->kd_sah == 1){
            $model->delete();
        }ELSE{
            Yii::$app->getSession()->setFlash('warning',  'SPJ ini sudah diproses Tata Usaha, tidak dapat diubah atau dihapus.');
        }
        

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the TaSPJ model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $tahun
     * @param string $no_spj
     * @return TaSPJ the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($tahun, $no_spj)
    {
        if (($model = TaSPJ::findOne(['tahun' => $tahun, 'no_spj' => $no_spj])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findBukti($tahun, $no_spj)
    {
        if (($model = \app\models\TaSPJRinc::find()->where(['tahun' => $tahun, 'no_spj' => $no_spj])
        ->orderBy('tgl_bukti, no_bukti, kd_program, kd_sub_program, kd_kegiatan, Kd_Rek_1, Kd_Rek_2, Kd_Rek_3, Kd_Rek_4, Kd_Rek_5')
        ->all() ) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    } 

    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 503])->one();
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
