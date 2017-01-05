<?php

namespace app\modules\penatausahaan\controllers;

use Yii;
use app\models\TaSPJRinc;
use app\modules\penatausahaan\models\TaSPJRincSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
/**
 * PenerimaanController implements the CRUD actions for TaSPJRinc model.
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
     * Lists all TaSPJRinc models.
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

        return $this->render('pilihan', [
            'Tahun' => $Tahun,
        ]);
    }

    public function actionBl()
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
        $searchModel = new \app\modules\anggaran\models\TaRkasKegiatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tahun' => $Tahun]);
        $dataProvider->query->andWhere('kd_program <> 0');
        IF(Yii::$app->user->identity->sekolah_id && $sekolah_id = Yii::$app->user->identity->sekolah_id){
            $dataProvider->query->andWhere(['sekolah_id' => $sekolah_id]);
        }

        return $this->render('indexbl', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }

    public function actionBlbelanja($tahun, $sekolah_id, $kd_program, $kd_sub_program, $kd_kegiatan)
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

        $kegiatan = \app\models\TaRkasKegiatan::findOne([
                'tahun' => $tahun,
                'sekolah_id' => $sekolah_id,
                'kd_program' => $kd_program,
                'kd_sub_program' => $kd_sub_program,
                'kd_kegiatan' => $kd_kegiatan,
                ]);

        $searchModel = new TaSPJRincSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tahun' => $Tahun]);
        $dataProvider->query->andWhere('(Kd_Rek_1 = 5 AND Kd_Rek_2 = 2)');
        $treeprogram = \app\models\TaRkasKegiatan::find()->select('tahun, sekolah_id, kd_program')->where(['tahun' => $tahun, 'sekolah_id' => $sekolah_id])->groupBy('tahun, sekolah_id, kd_program')->andWhere('kd_program <> 0')->all();

        return $this->render('belanja', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
            'kegiatan' => $kegiatan,
            'treeprogram' => $treeprogram,
        ]);
    }    

    public function actionBtl()
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
        $searchModel = new TaSPJRincSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tahun' => $Tahun]);
        $dataProvider->query->andWhere('(Kd_Rek_1 = 5 AND Kd_Rek_2 = 1) OR (Kd_Rek_1 = 6 AND Kd_Rek_2 = 2)');

        return $this->render('indexbtl', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }    

    /**
     * Displays a single TaSPJRinc model.
     * @param string $tahun
     * @param string $no_bukti
     * @param string $tgl_bukti
     * @return mixed
     */
    public function actionView($tahun, $no_bukti, $tgl_bukti)
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
            'model' => $this->findModel($tahun, $no_bukti, $tgl_bukti),
        ]);
    }

    /**
     * Creates a new TaSPJRinc model.
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

        $model = new TaSPJRinc();
        $model->sekolah_id = Yii::$app->user->identity->sekolah_id;
        $model->tahun = $Tahun;
        $model->kd_program = 0;
        $model->kd_sub_program = 0;
        $model->kd_kegiatan = 0;
        $model->pembayaran = 1;
        $session = Yii::$app->session;
        $model->Kd_Rek_1 = $session['Kd_Rek_1'];
        $model->Kd_Rek_2 = $session['Kd_Rek_2'];


        if ($model->load(Yii::$app->request->post())) {
            list($model->Kd_Rek_1, $model->Kd_Rek_2, $model->Kd_Rek_3, $model->Kd_Rek_4, $model->Kd_Rek_5) = explode('.', $model->rek5);
            $model->nilai = str_replace(',', '.', $model->nilai);
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
                'Tahun' => $Tahun,
            ]);
        }
    }

    public function actionCreatebtl()
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

        $model = new TaSPJRinc();
        $model->sekolah_id = Yii::$app->user->identity->sekolah_id;
        $model->tahun = $Tahun;
        $model->kd_program = 0;
        $model->kd_sub_program = 0;
        $model->kd_kegiatan = 0;
        $session = Yii::$app->session;
        //buat session kd_program
        IF($session['kd_program'] && $session['kd_sub_program'] && $session['kd_kegiatan']){
            $session->remove('kd_program');
            $session->remove('kd_sub_program');
            $session->remove('kd_kegiatan');
        }
        $session->set('kd_program', $model->kd_program);
        $session->set('kd_sub_program', $model->kd_sub_program);
        $session->set('kd_kegiatan', $model->kd_kegiatan);
        //buat session kd_rekening
        IF($session['Kd_Rek_1'] && $session['Kd_Rek_2']){
            $session->remove('Kd_Rek_1');
            $session->remove('Kd_Rek_2');
        }
        $session->set('Kd_Rek_1', 5);
        $session->set('Kd_Rek_2', 1);
        $model->Kd_Rek_1 =  $session['Kd_Rek_1'];
        $model->Kd_Rek_2 =  $session['Kd_Rek_2'];


        if ($model->load(Yii::$app->request->post())) {
            // list($model->Kd_Rek_1, $model->Kd_Rek_2, $model->Kd_Rek_3, $model->Kd_Rek_4, $model->Kd_Rek_5) = explode('.', $model->rek5);
            $model->nilai = str_replace(',', '.', $model->nilai);
            $query = \Yii::$app->db->createCommand("
                SELECT
                CONCAT(a.Kd_Rek_1, '.', a.Kd_Rek_2, '.', a.Kd_Rek_3, '.', a.Kd_Rek_4, '.', a.Kd_Rek_5) AS kd,
                CONCAT(a.Kd_Rek_1, '.', a.Kd_Rek_2, '.', a.Kd_Rek_3, '.', a.Kd_Rek_4, '.', a.Kd_Rek_5
                ,' ', c.Nm_Rek_3,'-',d.Nm_Rek_4,'-', e.Nm_Rek_5
                ) AS rekening,
                a.kd_penerimaan_1, a.kd_penerimaan_2,
                (a.total - IFNULL(b.nilai,0)) AS sisa_anggaran
                FROM
                (
                    SELECT
                        kd_program,
                        kd_sub_program,
                        kd_kegiatan,
                        Kd_Rek_1,
                        Kd_Rek_2,
                        Kd_Rek_3,
                        Kd_Rek_4,
                        Kd_Rek_5,
                        kd_penerimaan_1,
                        kd_penerimaan_2,
                        SUM(total) AS total
                    FROM
                        ta_rkas_history
                    WHERE
                        sekolah_id = ".$model->sekolah_id."
                    AND tahun = $Tahun
                    AND Kd_Rek_1 = ".$model->Kd_Rek_1."
                    AND Kd_Rek_2 = ".$model->Kd_Rek_2."
                    AND Kd_Rek_3 = ".$model->Kd_Rek_3."
                    AND Kd_Rek_4 = ".$model->Kd_Rek_4."
                    AND Kd_Rek_5 = ".$model->Kd_Rek_5."
                    AND perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE sekolah_id = ".$model->sekolah_id." AND tahun = $Tahun AND tgl_peraturan <= '".$model->tgl_bukti."'
                    )
                    GROUP BY
                        kd_program,
                        kd_sub_program,
                        kd_kegiatan,
                        Kd_Rek_1,
                        Kd_Rek_2,
                        Kd_Rek_3,
                        Kd_Rek_4,
                        Kd_Rek_5,
                        kd_penerimaan_1,
                        kd_penerimaan_2                        
                )a LEFT JOIN
                (
                    SELECT
                        kd_program,
                        kd_sub_program,
                        kd_kegiatan,
                        Kd_Rek_1,
                        Kd_Rek_2,
                        Kd_Rek_3,
                        Kd_Rek_4,
                        Kd_Rek_5,
                        SUM(nilai) AS nilai
                    FROM
                        ta_spj_rinc
                    WHERE
                        sekolah_id = ".$model->sekolah_id."
                    AND tahun = $Tahun
                    AND Kd_Rek_1 = ".$model->Kd_Rek_1."
                    AND Kd_Rek_2 = ".$model->Kd_Rek_2."
                    AND Kd_Rek_3 = ".$model->Kd_Rek_3."
                    AND Kd_Rek_4 = ".$model->Kd_Rek_4."
                    AND Kd_Rek_5 = ".$model->Kd_Rek_5."
                    AND tgl_bukti <=  '".$model->tgl_bukti."'
                    GROUP BY
                        kd_program,
                        kd_sub_program,
                        kd_kegiatan,
                        Kd_Rek_1,
                        Kd_Rek_2,
                        Kd_Rek_3,
                        Kd_Rek_4,
                        Kd_Rek_5
                ) b ON a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                AND a.Kd_Rek_1 = b.Kd_Rek_1
                AND a.Kd_Rek_2 = b.Kd_Rek_2
                AND a.Kd_Rek_3 = b.Kd_Rek_3
                AND a.Kd_Rek_4 = b.Kd_Rek_4
                AND a.Kd_Rek_5 = b.Kd_Rek_5
                LEFT JOIN ref_rek_3 c ON a.Kd_Rek_1 = c.Kd_Rek_1 AND a.Kd_Rek_2 = c.Kd_Rek_2 AND a.Kd_Rek_3 = c.Kd_Rek_3
                LEFT JOIN ref_rek_4 d ON a.Kd_Rek_1 = d.Kd_Rek_1 AND a.Kd_Rek_2 = d.Kd_Rek_2 AND a.Kd_Rek_3 = d.Kd_Rek_3 AND a.Kd_Rek_4 = d.Kd_Rek_4
                LEFT JOIN ref_rek_5 e ON a.Kd_Rek_1 = e.Kd_Rek_1 AND a.Kd_Rek_2 = e.Kd_Rek_2 AND a.Kd_Rek_3 = e.Kd_Rek_3 AND a.Kd_Rek_4 = e.Kd_Rek_4 AND a.Kd_Rek_5 = e.Kd_Rek_5
                ");            
            $sisa_anggaran = $query->queryOne();
            $result = 1;
            IF($sisa_anggaran['sisa_anggaran'] < $model->nilai){
                $result = 0;
                Yii::$app->getSession()->setFlash('warning',  'Sisa Anggaran tidak mencukupi! Sisa anggaran '.number_format($sisa_anggaran['sisa_anggaran'], 0, ',', '.').' pembayaran diajukan senilai '.number_format($model->nilai, 0, ',', '.'));
                return $this->redirect(Yii::$app->request->referrer);          
            }
            $query = \Yii::$app->db->createCommand("call sisa_kas($Tahun, ".$model->sekolah_id.",".$model->pembayaran.",NOW())");
            $sisa_kas = $query->queryOne();
            IF($sisa_kas['nilai'] < $model->nilai){
                IF($model->pembayaran == 1){
                    $metode = 'Bank';
                }ELSE{
                    $metode = 'Tunai';
                }
                $result = 0;
                Yii::$app->getSession()->setFlash('warning',  'Sisa Kas tidak mencukupi! Sisa Kas Untuk pembayaran '.$metode.' '.number_format($sisa_kas['nilai'], 0, ',', '.').' pembayaran diajukan senilai '.number_format($model->nilai, 0, ',', '.'));
                return $this->redirect(Yii::$app->request->referrer);              
            }        
            IF($model->save() && $result == 1){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_formbtl', [
                'model' => $model,
                'Tahun' => $Tahun,
            ]);
        }
    }    


    public function actionUpdatebtl($tahun, $no_bukti, $tgl_bukti)
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

        $model = $this->findModel($tahun, $no_bukti, $tgl_bukti);
        $session = Yii::$app->session;
        $model->Kd_Rek_1 = $session['Kd_Rek_1'];
        $model->Kd_Rek_2 = $session['Kd_Rek_2'];        

        if ($model->load(Yii::$app->request->post())) {
            $model->nilai = str_replace(',', '.', $model->nilai);
            $query = \Yii::$app->db->createCommand("
                SELECT
                CONCAT(a.Kd_Rek_1, '.', a.Kd_Rek_2, '.', a.Kd_Rek_3, '.', a.Kd_Rek_4, '.', a.Kd_Rek_5) AS kd,
                CONCAT(a.Kd_Rek_1, '.', a.Kd_Rek_2, '.', a.Kd_Rek_3, '.', a.Kd_Rek_4, '.', a.Kd_Rek_5
                ,' ', c.Nm_Rek_3,'-',d.Nm_Rek_4,'-', e.Nm_Rek_5
                ) AS rekening,
                a.kd_penerimaan_1, a.kd_penerimaan_2,
                (a.total - IFNULL(b.nilai,0)) AS sisa_anggaran
                FROM
                (
                    SELECT
                        kd_program,
                        kd_sub_program,
                        kd_kegiatan,
                        Kd_Rek_1,
                        Kd_Rek_2,
                        Kd_Rek_3,
                        Kd_Rek_4,
                        Kd_Rek_5,
                        kd_penerimaan_1,
                        kd_penerimaan_2,
                        SUM(total) AS total
                    FROM
                        ta_rkas_history
                    WHERE
                        sekolah_id = ".$model->sekolah_id."
                    AND tahun = $Tahun
                    AND Kd_Rek_1 = ".$model->Kd_Rek_1."
                    AND Kd_Rek_2 = ".$model->Kd_Rek_2."
                    AND Kd_Rek_3 = ".$model->Kd_Rek_3."
                    AND Kd_Rek_4 = ".$model->Kd_Rek_4."
                    AND Kd_Rek_5 = ".$model->Kd_Rek_5."
                    AND perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE sekolah_id = ".$model->sekolah_id." AND tahun = $Tahun AND tgl_peraturan <= '".$model->tgl_bukti."'
                    )
                    GROUP BY
                        kd_program,
                        kd_sub_program,
                        kd_kegiatan,
                        Kd_Rek_1,
                        Kd_Rek_2,
                        Kd_Rek_3,
                        Kd_Rek_4,
                        Kd_Rek_5,
                        kd_penerimaan_1,
                        kd_penerimaan_2                        
                )a LEFT JOIN
                (
                    SELECT
                        kd_program,
                        kd_sub_program,
                        kd_kegiatan,
                        Kd_Rek_1,
                        Kd_Rek_2,
                        Kd_Rek_3,
                        Kd_Rek_4,
                        Kd_Rek_5,
                        SUM(nilai) AS nilai
                    FROM
                        ta_spj_rinc
                    WHERE
                        sekolah_id = ".$model->sekolah_id."
                    AND tahun = $Tahun
                    AND Kd_Rek_1 = ".$model->Kd_Rek_1."
                    AND Kd_Rek_2 = ".$model->Kd_Rek_2."
                    AND Kd_Rek_3 = ".$model->Kd_Rek_3."
                    AND Kd_Rek_4 = ".$model->Kd_Rek_4."
                    AND Kd_Rek_5 = ".$model->Kd_Rek_5."
                    AND no_bukti <> '$no_bukti'
                    AND tgl_bukti <=  '".$model->tgl_bukti."'
                    GROUP BY
                        kd_program,
                        kd_sub_program,
                        kd_kegiatan,
                        Kd_Rek_1,
                        Kd_Rek_2,
                        Kd_Rek_3,
                        Kd_Rek_4,
                        Kd_Rek_5
                ) b ON a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                AND a.Kd_Rek_1 = b.Kd_Rek_1
                AND a.Kd_Rek_2 = b.Kd_Rek_2
                AND a.Kd_Rek_3 = b.Kd_Rek_3
                AND a.Kd_Rek_4 = b.Kd_Rek_4
                AND a.Kd_Rek_5 = b.Kd_Rek_5
                LEFT JOIN ref_rek_3 c ON a.Kd_Rek_1 = c.Kd_Rek_1 AND a.Kd_Rek_2 = c.Kd_Rek_2 AND a.Kd_Rek_3 = c.Kd_Rek_3
                LEFT JOIN ref_rek_4 d ON a.Kd_Rek_1 = d.Kd_Rek_1 AND a.Kd_Rek_2 = d.Kd_Rek_2 AND a.Kd_Rek_3 = d.Kd_Rek_3 AND a.Kd_Rek_4 = d.Kd_Rek_4
                LEFT JOIN ref_rek_5 e ON a.Kd_Rek_1 = e.Kd_Rek_1 AND a.Kd_Rek_2 = e.Kd_Rek_2 AND a.Kd_Rek_3 = e.Kd_Rek_3 AND a.Kd_Rek_4 = e.Kd_Rek_4 AND a.Kd_Rek_5 = e.Kd_Rek_5
                ");            
            $sisa_anggaran = $query->queryOne();
            $result = 1;
            IF($sisa_anggaran['sisa_anggaran'] < $model->nilai){
                $result = 0;
                Yii::$app->getSession()->setFlash('warning',  'Sisa Anggaran tidak mencukupi! Sisa anggaran '.number_format($sisa_anggaran['sisa_anggaran'], 0, ',', '.').' pembayaran diajukan senilai '.number_format($model->nilai, 0, ',', '.'));
                return $this->redirect(Yii::$app->request->referrer);          
            }
            $query = \Yii::$app->db->createCommand("call sisa_kas($Tahun, ".$model->sekolah_id.",".$model->pembayaran.",NOW())");
            $sisa_kas = $query->queryOne();
            IF($sisa_kas['nilai'] < $model->nilai){
                IF($model->pembayaran == 1){
                    $metode = 'Bank';
                }ELSE{
                    $metode = 'Tunai';
                }
                $result = 0;
                Yii::$app->getSession()->setFlash('warning',  'Sisa Kas tidak mencukupi! Sisa Kas Untuk pembayaran '.$metode.' '.number_format($sisa_kas['nilai'], 0, ',', '.').' pembayaran diajukan senilai '.number_format($model->nilai, 0, ',', '.'));
                return $this->redirect(Yii::$app->request->referrer);              
            }        
            IF($model->save() && $result == 1){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_formbtl', [
                'model' => $model,
                'Tahun' => $Tahun,
            ]);
        }
    }


    public function actionCreatebl($tahun, $sekolah_id, $kd_program, $kd_sub_program, $kd_kegiatan)
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

        $model = new TaSPJRinc();
        $model->sekolah_id = $sekolah_id;
        $model->tahun = $Tahun;
        $model->kd_program = $kd_program;
        $model->kd_sub_program = $kd_sub_program;
        $model->kd_kegiatan = $kd_kegiatan;
        $session = Yii::$app->session;
        //buat session kd_program
        IF($session['kd_program'] && $session['kd_sub_program'] && $session['kd_kegiatan']){
            $session->remove('kd_program');
            $session->remove('kd_sub_program');
            $session->remove('kd_kegiatan');
        }
        $session->set('kd_program', $model->kd_program);
        $session->set('kd_sub_program', $model->kd_sub_program);
        $session->set('kd_kegiatan', $model->kd_kegiatan);
        //buat session kd_rekening
        IF($session['Kd_Rek_1'] && $session['Kd_Rek_2']){
            $session->remove('Kd_Rek_1');
            $session->remove('Kd_Rek_2');
        }
        $session->set('Kd_Rek_1', 5);
        $session->set('Kd_Rek_2', 2);
        $model->Kd_Rek_1 =  $session['Kd_Rek_1'];
        $model->Kd_Rek_2 =  $session['Kd_Rek_2'];


        if ($model->load(Yii::$app->request->post())) {
            // list($model->Kd_Rek_1, $model->Kd_Rek_2, $model->Kd_Rek_3, $model->Kd_Rek_4, $model->Kd_Rek_5) = explode('.', $model->rek5);
            $model->nilai = str_replace(',', '.', $model->nilai);
            $query = \Yii::$app->db->createCommand("
                SELECT
                CONCAT(a.Kd_Rek_1, '.', a.Kd_Rek_2, '.', a.Kd_Rek_3, '.', a.Kd_Rek_4, '.', a.Kd_Rek_5) AS kd,
                CONCAT(a.Kd_Rek_1, '.', a.Kd_Rek_2, '.', a.Kd_Rek_3, '.', a.Kd_Rek_4, '.', a.Kd_Rek_5
                ,' ', c.Nm_Rek_3,'-',d.Nm_Rek_4,'-', e.Nm_Rek_5
                ) AS rekening,
                a.kd_penerimaan_1, a.kd_penerimaan_2,
                (a.total - IFNULL(b.nilai,0)) AS sisa_anggaran
                FROM
                (
                    SELECT
                        kd_program,
                        kd_sub_program,
                        kd_kegiatan,
                        Kd_Rek_1,
                        Kd_Rek_2,
                        Kd_Rek_3,
                        Kd_Rek_4,
                        Kd_Rek_5,
                        kd_penerimaan_1,
                        kd_penerimaan_2,
                        SUM(total) AS total
                    FROM
                        ta_rkas_history
                    WHERE
                        sekolah_id = ".$model->sekolah_id."
                    AND tahun = $Tahun
                    AND kd_program = $kd_program
                    AND kd_sub_program = $kd_sub_program
                    AND kd_kegiatan = $kd_kegiatan
                    AND Kd_Rek_1 = ".$model->Kd_Rek_1."
                    AND Kd_Rek_2 = ".$model->Kd_Rek_2."
                    AND Kd_Rek_3 = ".$model->Kd_Rek_3."
                    AND Kd_Rek_4 = ".$model->Kd_Rek_4."
                    AND Kd_Rek_5 = ".$model->Kd_Rek_5."
                    AND perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE sekolah_id = ".$model->sekolah_id." AND tahun = $Tahun AND tgl_peraturan <= '".$model->tgl_bukti."'
                    )
                    GROUP BY
                        kd_program,
                        kd_sub_program,
                        kd_kegiatan,
                        Kd_Rek_1,
                        Kd_Rek_2,
                        Kd_Rek_3,
                        Kd_Rek_4,
                        Kd_Rek_5,
                        kd_penerimaan_1,
                        kd_penerimaan_2                        
                )a LEFT JOIN
                (
                    SELECT
                        kd_program,
                        kd_sub_program,
                        kd_kegiatan,
                        Kd_Rek_1,
                        Kd_Rek_2,
                        Kd_Rek_3,
                        Kd_Rek_4,
                        Kd_Rek_5,
                        SUM(nilai) AS nilai
                    FROM
                        ta_spj_rinc
                    WHERE
                        sekolah_id = ".$model->sekolah_id."
                    AND tahun = $Tahun
                    AND kd_program = $kd_program
                    AND kd_sub_program = $kd_sub_program
                    AND kd_kegiatan = $kd_kegiatan
                    AND Kd_Rek_1 = ".$model->Kd_Rek_1."
                    AND Kd_Rek_2 = ".$model->Kd_Rek_2."
                    AND Kd_Rek_3 = ".$model->Kd_Rek_3."
                    AND Kd_Rek_4 = ".$model->Kd_Rek_4."
                    AND Kd_Rek_5 = ".$model->Kd_Rek_5."
                    AND tgl_bukti <=  '".$model->tgl_bukti."'
                    GROUP BY
                        kd_program,
                        kd_sub_program,
                        kd_kegiatan,
                        Kd_Rek_1,
                        Kd_Rek_2,
                        Kd_Rek_3,
                        Kd_Rek_4,
                        Kd_Rek_5
                ) b ON a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                AND a.Kd_Rek_1 = b.Kd_Rek_1
                AND a.Kd_Rek_2 = b.Kd_Rek_2
                AND a.Kd_Rek_3 = b.Kd_Rek_3
                AND a.Kd_Rek_4 = b.Kd_Rek_4
                AND a.Kd_Rek_5 = b.Kd_Rek_5
                LEFT JOIN ref_rek_3 c ON a.Kd_Rek_1 = c.Kd_Rek_1 AND a.Kd_Rek_2 = c.Kd_Rek_2 AND a.Kd_Rek_3 = c.Kd_Rek_3
                LEFT JOIN ref_rek_4 d ON a.Kd_Rek_1 = d.Kd_Rek_1 AND a.Kd_Rek_2 = d.Kd_Rek_2 AND a.Kd_Rek_3 = d.Kd_Rek_3 AND a.Kd_Rek_4 = d.Kd_Rek_4
                LEFT JOIN ref_rek_5 e ON a.Kd_Rek_1 = e.Kd_Rek_1 AND a.Kd_Rek_2 = e.Kd_Rek_2 AND a.Kd_Rek_3 = e.Kd_Rek_3 AND a.Kd_Rek_4 = e.Kd_Rek_4 AND a.Kd_Rek_5 = e.Kd_Rek_5
                ");            
            $sisa_anggaran = $query->queryOne();
            $result = 1;
            IF($sisa_anggaran['sisa_anggaran'] < $model->nilai){
                $result = 0;
                Yii::$app->getSession()->setFlash('warning',  'Sisa Anggaran tidak mencukupi! Sisa anggaran '.number_format($sisa_anggaran['sisa_anggaran'], 0, ',', '.').' pembayaran diajukan senilai '.number_format($model->nilai, 0, ',', '.'));
                return $this->redirect(Yii::$app->request->referrer);          
            }
            $query = \Yii::$app->db->createCommand("call sisa_kas($Tahun, ".$model->sekolah_id.",".$model->pembayaran.",NOW())");
            $sisa_kas = $query->queryOne();
            IF($sisa_kas['nilai'] < $model->nilai){
                IF($model->pembayaran == 1){
                    $metode = 'Bank';
                }ELSE{
                    $metode = 'Tunai';
                }
                $result = 0;
                Yii::$app->getSession()->setFlash('warning',  'Sisa Kas tidak mencukupi! Sisa Kas Untuk pembayaran '.$metode.' '.number_format($sisa_kas['nilai'], 0, ',', '.').' pembayaran diajukan senilai '.number_format($model->nilai, 0, ',', '.'));
                return $this->redirect(Yii::$app->request->referrer);              
            }
            $komponen_id = \app\models\TaRkasHistory::find()->where("perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE sekolah_id = ".$model->sekolah_id." AND tahun = $Tahun AND tgl_peraturan <= '".$model->tgl_bukti."')")->andWhere([
                    'tahun' => $Tahun,
                    'sekolah_id' => $sekolah_id,
                    'kd_program' => $kd_program,
                    'kd_sub_program' => $kd_sub_program,
                    'kd_kegiatan' => $kd_kegiatan,
                    'Kd_Rek_1' => $model->Kd_Rek_1,
                    'Kd_Rek_2' => $model->Kd_Rek_2,
                    'Kd_Rek_3' => $model->Kd_Rek_3,
                    'Kd_Rek_4' => $model->Kd_Rek_4,
                    'Kd_Rek_5' => $model->Kd_Rek_5,
                ])->one();
            $model->komponen_id = $komponen_id['komponen_id'];
            IF($model->save() && $result == 1){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_formbl', [
                'model' => $model,
                'Tahun' => $Tahun,
            ]);
        }
    }        

    public function actionUpdatebl($tahun, $no_bukti, $tgl_bukti)
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
        $model = $this->findModel($tahun, $no_bukti, $tgl_bukti);
        $session = Yii::$app->session;

        //buat session kd_program
        IF($session['kd_program'] && $session['kd_sub_program'] && $session['kd_kegiatan']){
            $session->remove('kd_program');
            $session->remove('kd_sub_program');
            $session->remove('kd_kegiatan');
        }
        $session->set('kd_program', $model->kd_program);
        $session->set('kd_sub_program', $model->kd_sub_program);
        $session->set('kd_kegiatan', $model->kd_kegiatan);

        $model->Kd_Rek_1 = $session['Kd_Rek_1'];
        $model->Kd_Rek_2 = $session['Kd_Rek_2'];        

        if ($model->load(Yii::$app->request->post())) {
            $model->nilai = str_replace(',', '.', $model->nilai);
            $query = \Yii::$app->db->createCommand("
                SELECT
                CONCAT(a.Kd_Rek_1, '.', a.Kd_Rek_2, '.', a.Kd_Rek_3, '.', a.Kd_Rek_4, '.', a.Kd_Rek_5) AS kd,
                CONCAT(a.Kd_Rek_1, '.', a.Kd_Rek_2, '.', a.Kd_Rek_3, '.', a.Kd_Rek_4, '.', a.Kd_Rek_5
                ,' ', c.Nm_Rek_3,'-',d.Nm_Rek_4,'-', e.Nm_Rek_5
                ) AS rekening,
                a.kd_penerimaan_1, a.kd_penerimaan_2,
                (a.total - IFNULL(b.nilai,0)) AS sisa_anggaran
                FROM
                (
                    SELECT
                        kd_program,
                        kd_sub_program,
                        kd_kegiatan,
                        Kd_Rek_1,
                        Kd_Rek_2,
                        Kd_Rek_3,
                        Kd_Rek_4,
                        Kd_Rek_5,
                        kd_penerimaan_1,
                        kd_penerimaan_2,
                        SUM(total) AS total
                    FROM
                        ta_rkas_history
                    WHERE
                        sekolah_id = ".$model->sekolah_id."
                    AND tahun = $Tahun
                    AND Kd_Rek_1 = ".$model->Kd_Rek_1."
                    AND Kd_Rek_2 = ".$model->Kd_Rek_2."
                    AND Kd_Rek_3 = ".$model->Kd_Rek_3."
                    AND Kd_Rek_4 = ".$model->Kd_Rek_4."
                    AND Kd_Rek_5 = ".$model->Kd_Rek_5."
                    AND perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE sekolah_id = ".$model->sekolah_id." AND tahun = $Tahun AND tgl_peraturan <= '".$model->tgl_bukti."'
                    )
                    GROUP BY
                        kd_program,
                        kd_sub_program,
                        kd_kegiatan,
                        Kd_Rek_1,
                        Kd_Rek_2,
                        Kd_Rek_3,
                        Kd_Rek_4,
                        Kd_Rek_5,
                        kd_penerimaan_1,
                        kd_penerimaan_2                        
                )a LEFT JOIN
                (
                    SELECT
                        kd_program,
                        kd_sub_program,
                        kd_kegiatan,
                        Kd_Rek_1,
                        Kd_Rek_2,
                        Kd_Rek_3,
                        Kd_Rek_4,
                        Kd_Rek_5,
                        SUM(nilai) AS nilai
                    FROM
                        ta_spj_rinc
                    WHERE
                        sekolah_id = ".$model->sekolah_id."
                    AND tahun = $Tahun
                    AND Kd_Rek_1 = ".$model->Kd_Rek_1."
                    AND Kd_Rek_2 = ".$model->Kd_Rek_2."
                    AND Kd_Rek_3 = ".$model->Kd_Rek_3."
                    AND Kd_Rek_4 = ".$model->Kd_Rek_4."
                    AND Kd_Rek_5 = ".$model->Kd_Rek_5."
                    AND no_bukti <> '$no_bukti'
                    AND tgl_bukti <=  '".$model->tgl_bukti."'
                    GROUP BY
                        kd_program,
                        kd_sub_program,
                        kd_kegiatan,
                        Kd_Rek_1,
                        Kd_Rek_2,
                        Kd_Rek_3,
                        Kd_Rek_4,
                        Kd_Rek_5
                ) b ON a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                AND a.Kd_Rek_1 = b.Kd_Rek_1
                AND a.Kd_Rek_2 = b.Kd_Rek_2
                AND a.Kd_Rek_3 = b.Kd_Rek_3
                AND a.Kd_Rek_4 = b.Kd_Rek_4
                AND a.Kd_Rek_5 = b.Kd_Rek_5
                LEFT JOIN ref_rek_3 c ON a.Kd_Rek_1 = c.Kd_Rek_1 AND a.Kd_Rek_2 = c.Kd_Rek_2 AND a.Kd_Rek_3 = c.Kd_Rek_3
                LEFT JOIN ref_rek_4 d ON a.Kd_Rek_1 = d.Kd_Rek_1 AND a.Kd_Rek_2 = d.Kd_Rek_2 AND a.Kd_Rek_3 = d.Kd_Rek_3 AND a.Kd_Rek_4 = d.Kd_Rek_4
                LEFT JOIN ref_rek_5 e ON a.Kd_Rek_1 = e.Kd_Rek_1 AND a.Kd_Rek_2 = e.Kd_Rek_2 AND a.Kd_Rek_3 = e.Kd_Rek_3 AND a.Kd_Rek_4 = e.Kd_Rek_4 AND a.Kd_Rek_5 = e.Kd_Rek_5
                ");            
            $sisa_anggaran = $query->queryOne();
            $result = 1;
            IF($sisa_anggaran['sisa_anggaran'] < $model->nilai){
                $result = 0;
                Yii::$app->getSession()->setFlash('warning',  'Sisa Anggaran tidak mencukupi! Sisa anggaran '.number_format($sisa_anggaran['sisa_anggaran'], 0, ',', '.').' pembayaran diajukan senilai '.number_format($model->nilai, 0, ',', '.'));
                return $this->redirect(Yii::$app->request->referrer);          
            }
            $query = \Yii::$app->db->createCommand("call sisa_kas($Tahun, ".$model->sekolah_id.",".$model->pembayaran.",NOW())");
            $sisa_kas = $query->queryOne();
            IF($sisa_kas['nilai'] < $model->nilai){
                IF($model->pembayaran == 1){
                    $metode = 'Bank';
                }ELSE{
                    $metode = 'Tunai';
                }
                $result = 0;
                Yii::$app->getSession()->setFlash('warning',  'Sisa Kas tidak mencukupi! Sisa Kas Untuk pembayaran '.$metode.' '.number_format($sisa_kas['nilai'], 0, ',', '.').' pembayaran diajukan senilai '.number_format($model->nilai, 0, ',', '.'));
                return $this->redirect(Yii::$app->request->referrer);              
            }        
            IF($model->save() && $result == 1){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_formbl', [
                'model' => $model,
                'Tahun' => $Tahun,
            ]);
        }
    }

    /**
     * Deletes an existing TaSPJRinc model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $tahun
     * @param string $no_bukti
     * @param string $tgl_bukti
     * @return mixed
     */
    public function actionDelete($tahun, $no_bukti, $tgl_bukti)
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
        $model = $this->findModel($tahun, $no_bukti, $tgl_bukti);
        IF($model->no_spj == NULL){
            $model->delete();
        }ELSE{
            Yii::$app->getSession()->setFlash('warning',  'Sudah di SPJ kan, tidak dapat dihapus.');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }


    //Bagian untuk kamus-----------------------------------------------------------------------------------------
    public function actionKamuskegiatan()
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
        $searchModel = new \app\modules\anggaran\models\RefKegiatanSekolahSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy('kd_program, kd_sub_program, kd_kegiatan ASC');
        $dataProvider->pagination->pageSize=100;

        return $this->renderAjax('kamuskegiatan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }

    public function actionKamusbelanja()
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
        $searchModel = new \app\modules\anggaran\models\RefRek5Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['Kd_Rek_1' => 5, 'Kd_Rek_2' => 2]);
        $dataProvider->pagination->pageSize=100;

        return $this->renderAjax('kamusbelanja', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }    

    //for depdrop action ----@hoaaah
    public function actionSubprogram() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $kd_program = $parents[0];
                $out = \app\models\RefSubProgramSekolah::find()
                           ->where([
                            'kd_program' => $kd_program,
                            ])
                           ->select(['kd_sub_program AS id','CONCAT(kd_program,\'.\',kd_sub_program,\' \',uraian_sub_program) AS name'])->asArray()->all();
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
     
    public function actionKegiatan() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $kd_program = empty($ids[0]) ? null : $ids[0];
            $kd_sub_program = empty($ids[1]) ? null : $ids[1];
            if ($kd_program != null) {
               //$data = self::getProdList($cat_id, $subcat_id);
               $data = \app\models\RefKegiatanSekolah::find()
                           ->where([
                            'kd_program' => $kd_program,
                            'kd_sub_program' => $kd_sub_program,
                            ])
                           ->select(['kd_kegiatan AS id','CONCAT(kd_program,\'.\',kd_sub_program,\'.\',kd_kegiatan,\' \',uraian_kegiatan) AS name'])->asArray()->all();
                /**
                 * the getProdList function will query the database based on the
                 * cat_id and sub_cat_id and return an array like below:
                 *  [
                 *      'out'=>[
                 *          ['id'=>'<prod-id-1>', 'name'=>'<prod-name1>'],
                 *          ['id'=>'<prod_id_2>', 'name'=>'<prod-name2>']
                 *       ],
                 *       'selected'=>'<prod-id-1>'
                 *  ]
                 */
               
               echo Json::encode(['output'=>$data, 'selected'=>'']);
               return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionKdrek4() {
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }        
        $out = [];
        $session = Yii::$app->session;
        $kd_program = 0;
        $kd_sub_program = 0;
        $kd_kegiatan = 0;
        IF(isset($session['kd_program'])) $kd_program = $session['kd_program'];
        IF(isset($session['kd_sub_program'])) $kd_sub_program = $session['kd_sub_program'];
        IF(isset($session['kd_kegiatan'])) $kd_kegiatan = $session['kd_kegiatan'];

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $Kd_Rek_3 = $parents[0];
                // $out = \app\models\RefRek4::find()
                //            ->where([
                //             'Kd_Rek_1' => $session['Kd_Rek_1'],
                //             'Kd_Rek_2' => $session['Kd_Rek_2'],
                //             'Kd_Rek_3' => $Kd_Rek_3,
                //             ])
                //            ->select(['Kd_Rek_4 AS id','CONCAT(Kd_Rek_3,\'.\',Kd_Rek_4,\' \',Nm_Rek_4) AS name'])->asArray()->all();
                $connection = \Yii::$app->db;
                $skpd = $connection->createCommand("
                    SELECT
                    a.Kd_Rek_4 AS id,
                    CONCAT(a.Kd_Rek_1, '.', a.Kd_Rek_2, '.', a.Kd_Rek_3, '.', a.Kd_Rek_4
                    ,' ', d.Nm_Rek_4
                    ) AS name
                    FROM
                    (
                        SELECT
                            kd_program,
                            kd_sub_program,
                            kd_kegiatan,
                            Kd_Rek_1,
                            Kd_Rek_2,
                            Kd_Rek_3,
                            Kd_Rek_4,
                            Kd_Rek_5,
                            SUM(total) AS total
                        FROM
                            ta_rkas_history
                        WHERE
                            sekolah_id = ".Yii::$app->user->identity->sekolah_id."
                        AND tahun = $Tahun
                        AND kd_program = $kd_program
                        AND kd_sub_program = $kd_sub_program
                        AND kd_kegiatan = $kd_kegiatan
                        AND Kd_Rek_1 = ".$session['Kd_Rek_1']."
                        AND Kd_Rek_2 = ".$session['Kd_Rek_2']."
                        AND Kd_Rek_3 = $Kd_Rek_3
                        AND perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE sekolah_id = ".Yii::$app->user->identity->sekolah_id." AND tahun = $Tahun AND tgl_peraturan <= NOW()
                        )
                        GROUP BY
                            kd_program,
                            kd_sub_program,
                            kd_kegiatan,
                            Kd_Rek_1,
                            Kd_Rek_2,
                            Kd_Rek_3,
                            Kd_Rek_4,
                            Kd_Rek_5
                    )a LEFT JOIN
                    (
                        SELECT
                            kd_program,
                            kd_sub_program,
                            kd_kegiatan,
                            Kd_Rek_1,
                            Kd_Rek_2,
                            Kd_Rek_3,
                            Kd_Rek_4,
                            Kd_Rek_5,
                            SUM(nilai) AS nilai
                        FROM
                            ta_spj_rinc
                        WHERE
                            sekolah_id = ".Yii::$app->user->identity->sekolah_id."
                        AND tahun = $Tahun
                        AND kd_program = $kd_program
                        AND kd_sub_program = $kd_sub_program
                        AND kd_kegiatan = $kd_kegiatan
                        AND Kd_Rek_1 = ".$session['Kd_Rek_1']."
                        AND Kd_Rek_2 = ".$session['Kd_Rek_2']."
                        AND Kd_Rek_3 = $Kd_Rek_3
                        AND tgl_bukti <= NOW()
                        GROUP BY
                            kd_program,
                            kd_sub_program,
                            kd_kegiatan,
                            Kd_Rek_1,
                            Kd_Rek_2,
                            Kd_Rek_3,
                            Kd_Rek_4,
                            Kd_Rek_5
                    ) b ON a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                    AND a.Kd_Rek_1 = b.Kd_Rek_1
                    AND a.Kd_Rek_2 = b.Kd_Rek_2
                    AND a.Kd_Rek_3 = b.Kd_Rek_3
                    AND a.Kd_Rek_4 = b.Kd_Rek_4
                    AND a.Kd_Rek_5 = b.Kd_Rek_5
                    LEFT JOIN ref_rek_3 c ON a.Kd_Rek_1 = c.Kd_Rek_1 AND a.Kd_Rek_2 = c.Kd_Rek_2 AND a.Kd_Rek_3 = c.Kd_Rek_3
                    LEFT JOIN ref_rek_4 d ON a.Kd_Rek_1 = d.Kd_Rek_1 AND a.Kd_Rek_2 = d.Kd_Rek_2 AND a.Kd_Rek_3 = d.Kd_Rek_3 AND a.Kd_Rek_4 = d.Kd_Rek_4
                    LEFT JOIN ref_rek_5 e ON a.Kd_Rek_1 = e.Kd_Rek_1 AND a.Kd_Rek_2 = e.Kd_Rek_2 AND a.Kd_Rek_3 = e.Kd_Rek_3 AND a.Kd_Rek_4 = e.Kd_Rek_4 AND a.Kd_Rek_5 = e.Kd_Rek_5
                    GROUP BY a.Kd_Rek_4
                    ");
                $out = $skpd->queryAll();                
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
     
    public function actionKdrek5() {
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }          
        $out = [];
        $session = Yii::$app->session;     
        $kd_program = 0;
        $kd_sub_program = 0;
        $kd_kegiatan = 0;
        IF(isset($session['kd_program'])) $kd_program = $session['kd_program'];
        IF(isset($session['kd_sub_program'])) $kd_sub_program = $session['kd_sub_program'];
        IF(isset($session['kd_kegiatan'])) $kd_kegiatan = $session['kd_kegiatan'];

        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $Kd_Rek_3 = empty($ids[0]) ? null : $ids[0];
            $Kd_Rek_4 = empty($ids[1]) ? null : $ids[1];
            if ($Kd_Rek_3 != null) {
               //$data = self::getProdList($cat_id, $subcat_id);
               // $data = \app\models\RefRek5::find()
               //             ->where([
               //              'Kd_Rek_1' => $session['Kd_Rek_1'],
               //              'Kd_Rek_2' => $session['Kd_Rek_2'],
               //              'Kd_Rek_3' => $Kd_Rek_3,
               //              'Kd_Rek_4' => $Kd_Rek_4,
               //              // 'sekolah' => 1,
               //              ])
               //             ->select(['Kd_Rek_5 AS id','CONCAT(Kd_Rek_3,\'.\',Kd_Rek_4,\'.\',Kd_Rek_5,\' \',Nm_Rek_5) AS name'])->asArray()->all();
                $connection = \Yii::$app->db;
                $skpd = $connection->createCommand("
                    SELECT
                    a.Kd_Rek_5 AS id,
                    CONCAT(a.Kd_Rek_1, '.', a.Kd_Rek_2, '.', a.Kd_Rek_3, '.', a.Kd_Rek_4, '.', a.Kd_Rek_5
                    ,' ', e.Nm_Rek_5,  ' (Sisa Pagu Rp ', CONVERT(FORMAT((a.total - IFNULL(b.nilai,0)),0, 'id_ID') using utf8) , ' ) '
                    ) AS name
                    FROM
                    (
                        SELECT
                            kd_program,
                            kd_sub_program,
                            kd_kegiatan,
                            Kd_Rek_1,
                            Kd_Rek_2,
                            Kd_Rek_3,
                            Kd_Rek_4,
                            Kd_Rek_5,
                            SUM(total) AS total
                        FROM
                            ta_rkas_history
                        WHERE
                            sekolah_id = ".Yii::$app->user->identity->sekolah_id."
                        AND tahun = $Tahun
                        AND kd_program = $kd_program
                        AND kd_sub_program = $kd_sub_program
                        AND kd_kegiatan = $kd_kegiatan
                        AND Kd_Rek_1 = ".$session['Kd_Rek_1']."
                        AND Kd_Rek_2 = ".$session['Kd_Rek_2']."
                        AND Kd_Rek_3 = $Kd_Rek_3
                        AND Kd_Rek_4 = $Kd_Rek_4
                        AND perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE sekolah_id = ".Yii::$app->user->identity->sekolah_id." AND tahun = $Tahun AND tgl_peraturan <= NOW()
                        )
                        GROUP BY
                            kd_program,
                            kd_sub_program,
                            kd_kegiatan,
                            Kd_Rek_1,
                            Kd_Rek_2,
                            Kd_Rek_3,
                            Kd_Rek_4,
                            Kd_Rek_5
                    )a LEFT JOIN
                    (
                        SELECT
                            kd_program,
                            kd_sub_program,
                            kd_kegiatan,
                            Kd_Rek_1,
                            Kd_Rek_2,
                            Kd_Rek_3,
                            Kd_Rek_4,
                            Kd_Rek_5,
                            SUM(nilai) AS nilai
                        FROM
                            ta_spj_rinc
                        WHERE
                            sekolah_id = ".Yii::$app->user->identity->sekolah_id."
                        AND tahun = $Tahun
                        AND kd_program = $kd_program
                        AND kd_sub_program = $kd_sub_program
                        AND kd_kegiatan = $kd_kegiatan
                        AND Kd_Rek_1 = ".$session['Kd_Rek_1']."
                        AND Kd_Rek_2 = ".$session['Kd_Rek_2']."
                        AND Kd_Rek_3 = $Kd_Rek_3
                        AND Kd_Rek_4 = $Kd_Rek_4
                        AND tgl_bukti <= NOW()
                        GROUP BY
                            kd_program,
                            kd_sub_program,
                            kd_kegiatan,
                            Kd_Rek_1,
                            Kd_Rek_2,
                            Kd_Rek_3,
                            Kd_Rek_4,
                            Kd_Rek_5
                    ) b ON a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                    AND a.Kd_Rek_1 = b.Kd_Rek_1
                    AND a.Kd_Rek_2 = b.Kd_Rek_2
                    AND a.Kd_Rek_3 = b.Kd_Rek_3
                    AND a.Kd_Rek_4 = b.Kd_Rek_4
                    AND a.Kd_Rek_5 = b.Kd_Rek_5
                    LEFT JOIN ref_rek_3 c ON a.Kd_Rek_1 = c.Kd_Rek_1 AND a.Kd_Rek_2 = c.Kd_Rek_2 AND a.Kd_Rek_3 = c.Kd_Rek_3
                    LEFT JOIN ref_rek_4 d ON a.Kd_Rek_1 = d.Kd_Rek_1 AND a.Kd_Rek_2 = d.Kd_Rek_2 AND a.Kd_Rek_3 = d.Kd_Rek_3 AND a.Kd_Rek_4 = d.Kd_Rek_4
                    LEFT JOIN ref_rek_5 e ON a.Kd_Rek_1 = e.Kd_Rek_1 AND a.Kd_Rek_2 = e.Kd_Rek_2 AND a.Kd_Rek_3 = e.Kd_Rek_3 AND a.Kd_Rek_4 = e.Kd_Rek_4 AND a.Kd_Rek_5 = e.Kd_Rek_5
                    ");
                $out = $skpd->queryAll();                                
                /**
                 * the getProdList function will query the database based on the
                 * cat_id and sub_cat_id and return an array like below:
                 *  [
                 *      'out'=>[
                 *          ['id'=>'<prod-id-1>', 'name'=>'<prod-name1>'],
                 *          ['id'=>'<prod_id_2>', 'name'=>'<prod-name2>']
                 *       ],
                 *       'selected'=>'<prod-id-1>'
                 *  ]
                 */
               
               echo Json::encode(['output'=>$out, 'selected'=>'']);
               return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }      

    /**
     * Finds the TaSPJRinc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $tahun
     * @param string $no_bukti
     * @param string $tgl_bukti
     * @return TaSPJRinc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($tahun, $no_bukti, $tgl_bukti)
    {
        if (($model = TaSPJRinc::findOne(['tahun' => $tahun, 'no_bukti' => $no_bukti, 'tgl_bukti' => $tgl_bukti])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 506])->one();
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
