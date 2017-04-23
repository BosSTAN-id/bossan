<?php

namespace app\modules\penatausahaan\controllers;

use Yii;
use app\models\TaSPJRinc;
use app\modules\penatausahaan\models\TaSPJRincSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

/**
 * BuktiController implements the CRUD actions for TaSPJRinc model.
 */
class BuktiController extends Controller
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
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
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

        $searchModel = new TaSPJRincSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tahun' => $Tahun, 'Kd_Rek_1' => 5]);
        IF(Yii::$app->user->identity->sekolah_id && $sekolah_id = Yii::$app->user->identity->sekolah_id){
            $dataProvider->query->andWhere(['sekolah_id' => $sekolah_id]);
        }
        $dataProvider->query->orderBy('tgl_bukti DESC, no_bukti DESC');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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

        $request = Yii::$app->request;
        $model = $this->findModel($tahun, $no_bukti, $tgl_bukti);
        $potongan = NULL; //(Take Potongan Query Here)
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Bukti Belanja #".$no_bukti,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'potongan' => $potongan,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-right','data-dismiss'=>"modal"])
                ];    
        }else{
            return $this->render('view', [
                'model' => $model,
                'potongan' => $potongan,
            ]);
        }
    }

    /**
     * Creates a new TaSPJRinc model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
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

        $request = Yii::$app->request;
        $model = new TaSPJRinc();
        $model->tahun = $Tahun;
        $model->sekolah_id = Yii::$app->user->identity->sekolah_id;
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
                    AND tahun = ".$model->tahun."
                    AND kd_program = ".$model->kd_program."
                    AND kd_sub_program = ".$model->kd_sub_program."
                    AND kd_kegiatan = ".$model->kd_kegiatan."
                    AND Kd_Rek_1 = ".$model->Kd_Rek_1."
                    AND Kd_Rek_2 = ".$model->Kd_Rek_2."
                    AND Kd_Rek_3 = ".$model->Kd_Rek_3."
                    AND Kd_Rek_4 = ".$model->Kd_Rek_4."
                    AND Kd_Rek_5 = ".$model->Kd_Rek_5."
                    AND perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE sekolah_id = ".$model->sekolah_id." AND tahun = ".$model->tahun." AND tgl_peraturan <= '".$model->tgl_bukti."'
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
                    AND tahun = ".$model->tahun."
                    AND kd_program = ".$model->kd_program."
                    AND kd_sub_program = ".$model->kd_sub_program."
                    AND kd_kegiatan = ".$model->kd_kegiatan."
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
                return $this->redirect(['create']);       
            }
            $query = \Yii::$app->db->createCommand("call sisa_kas($Tahun, ".$model->sekolah_id.",".$model->pembayaran.",'".$model->tgl_bukti."')");
            $sisa_kas = $query->queryOne();
            IF($sisa_kas['nilai'] < $model->nilai){
                IF($model->pembayaran == 1){
                    $metode = 'Bank';
                }ELSE{
                    $metode = 'Tunai';
                }
                $result = 0;
                Yii::$app->getSession()->setFlash('warning',  'Sisa Kas tidak mencukupi! Sisa Kas Untuk pembayaran '.$metode.' '.number_format($sisa_kas['nilai'], 0, ',', '.').' pembayaran diajukan senilai '.number_format($model->nilai, 0, ',', '.'));
                return $this->redirect(['create']);           
            }
            $komponen_id = \app\models\TaRkasHistory::find()->where("perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE sekolah_id = ".$model->sekolah_id." AND tahun = $Tahun AND tgl_peraturan <= '".$model->tgl_bukti."')")->andWhere([
                    'tahun' => $model->tahun,
                    'sekolah_id' => $model->sekolah_id,
                    'kd_program' => $model->kd_program,
                    'kd_sub_program' => $model->kd_sub_program,
                    'kd_kegiatan' => $model->kd_kegiatan,
                    'Kd_Rek_1' => $model->Kd_Rek_1,
                    'Kd_Rek_2' => $model->Kd_Rek_2,
                    'Kd_Rek_3' => $model->Kd_Rek_3,
                    'Kd_Rek_4' => $model->Kd_Rek_4,
                    'Kd_Rek_5' => $model->Kd_Rek_5,
                ])->one();
            $model->komponen_id = $komponen_id['komponen_id'];
            IF($model->save() && $result == 1){
                return $this->redirect(['view', 'tahun' => $model->tahun, 'no_bukti' => $model->no_bukti, 'tgl_bukti' => $model->tgl_bukti]);
            }ELSE{
                Yii::$app->getSession()->setFlash('warning', 'Terjadi masalah, penyimpanan gagal.' );
                return $this->redirect(['create']);
            }
        }else{
                return $this->render('create', [
                    'model' => $model,
                    'Tahun' => $Tahun,
                ]);
        }
       
    }

    /**
     * Updates an existing TaSPJRinc model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param string $tahun
     * @param string $no_bukti
     * @param string $tgl_bukti
     * @return mixed
     */
    public function actionUpdate($tahun, $no_bukti, $tgl_bukti)
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

        $request = Yii::$app->request;
        $model = $this->findModel($tahun, $no_bukti, $tgl_bukti);       
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
                    AND tahun = ".$model->tahun."
                    AND kd_program = ".$model->kd_program."
                    AND kd_sub_program = ".$model->kd_sub_program."
                    AND kd_kegiatan = ".$model->kd_kegiatan."
                    AND Kd_Rek_1 = ".$model->Kd_Rek_1."
                    AND Kd_Rek_2 = ".$model->Kd_Rek_2."
                    AND Kd_Rek_3 = ".$model->Kd_Rek_3."
                    AND Kd_Rek_4 = ".$model->Kd_Rek_4."
                    AND Kd_Rek_5 = ".$model->Kd_Rek_5."
                    AND perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE sekolah_id = ".$model->sekolah_id." AND tahun = ".$model->tahun." AND tgl_peraturan <= '".$model->tgl_bukti."'
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
                    AND tahun = ".$model->tahun."
                    AND kd_program = ".$model->kd_program."
                    AND kd_sub_program = ".$model->kd_sub_program."
                    AND kd_kegiatan = ".$model->kd_kegiatan."
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
                return $this->redirect(['create']);       
            }
            $query = \Yii::$app->db->createCommand("call sisa_kas($Tahun, ".$model->sekolah_id.",".$model->pembayaran.",'".$model->tgl_bukti."')");
            $sisa_kas = $query->queryOne();
            IF($sisa_kas['nilai'] < $model->nilai){
                IF($model->pembayaran == 1){
                    $metode = 'Bank';
                }ELSE{
                    $metode = 'Tunai';
                }
                $result = 0;
                Yii::$app->getSession()->setFlash('warning',  'Sisa Kas tidak mencukupi! Sisa Kas Untuk pembayaran '.$metode.' '.number_format($sisa_kas['nilai'], 0, ',', '.').' pembayaran diajukan senilai '.number_format($model->nilai, 0, ',', '.'));
                return $this->redirect(['create']);           
            }
            $komponen_id = \app\models\TaRkasHistory::find()->where("perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE sekolah_id = ".$model->sekolah_id." AND tahun = $Tahun AND tgl_peraturan <= '".$model->tgl_bukti."')")->andWhere([
                    'tahun' => $model->tahun,
                    'sekolah_id' => $model->sekolah_id,
                    'kd_program' => $model->kd_program,
                    'kd_sub_program' => $model->kd_sub_program,
                    'kd_kegiatan' => $model->kd_kegiatan,
                    'Kd_Rek_1' => $model->Kd_Rek_1,
                    'Kd_Rek_2' => $model->Kd_Rek_2,
                    'Kd_Rek_3' => $model->Kd_Rek_3,
                    'Kd_Rek_4' => $model->Kd_Rek_4,
                    'Kd_Rek_5' => $model->Kd_Rek_5,
                ])->one();
            $model->komponen_id = $komponen_id['komponen_id'];
            IF($model->save() && $result == 1){
                return $this->redirect(['view', 'tahun' => $model->tahun, 'no_bukti' => $model->no_bukti, 'tgl_bukti' => $model->tgl_bukti]);
            }ELSE{
                Yii::$app->getSession()->setFlash('warning', 'Terjadi masalah, penyimpanan gagal.' );
                return $this->redirect(['create']);
            }
        }else{
                return $this->render('update', [
                    'model' => $model,
                    'Tahun' => $Tahun,
                ]);
        }
    }

    /**
     * Delete an existing TaSPJRinc model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
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

        $request = Yii::$app->request;
        $model = $this->findModel($tahun, $no_bukti, $tgl_bukti);
        IF($model->no_spj == NULL){
            $model->delete();
        }ELSE{
            Yii::$app->getSession()->setFlash('warning',  'Sudah di SPJ kan, tidak dapat dihapus.');
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing TaSPJRinc model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $tahun
     * @param string $no_bukti
     * @param string $tgl_bukti
     * @return mixed
     */
    public function actionBulkDelete()
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

        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    // for modals belanja
    public function actionList()
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

        $request = Yii::$app->request;
        $searchModel = new \app\modules\anggaran\models\TaRkasKegiatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tahun' => $Tahun]);
        IF(Yii::$app->user->identity->sekolah_id && $sekolah_id = Yii::$app->user->identity->sekolah_id){
            $dataProvider->query->andWhere(['sekolah_id' => $sekolah_id]);
        }

        if($request->isAjax){
            return $this->renderAjax('kamuskegiatan', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'Tahun' => $Tahun,
            ]);
        }

    }    

    public function actionListbelanja($id)
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

        list($kd_program, $kd_sub_program, $kd_kegiatan) = explode('.', $id);
        $kegiatan = \app\models\RefKegiatanSekolah::findOne(['kd_program' => $kd_program, 'kd_sub_program' => $kd_sub_program, 'kd_kegiatan' => $kd_kegiatan]);
        $request = Yii::$app->request;
        $totalCount = Yii::$app->db->createCommand("
                    SELECT
                    COUNT(a.Kd_Rek_1)
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
                            sekolah_id = :sekolah_id
                        AND tahun = :tahun
                        AND kd_program = :kd_program
                        AND kd_sub_program = :kd_sub_program
                        AND kd_kegiatan = :kd_kegiatan
                        AND Kd_Rek_1 = :Kd_Rek_1
                        AND perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE perubahan_id IN (4,6) AND sekolah_id = :sekolah_id AND tahun = :tahun AND tgl_peraturan <= NOW()
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
                            sekolah_id = :sekolah_id
                        AND tahun = :tahun
                        AND kd_program = :kd_program
                        AND kd_sub_program = :kd_sub_program
                        AND kd_kegiatan = :kd_kegiatan
                        AND Kd_Rek_1 = :Kd_Rek_1
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
            ", [
                ':tahun' => $Tahun,
                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                ':kd_program' => $kd_program,
                ':kd_sub_program' => $kd_sub_program,
                ':kd_kegiatan' => $kd_kegiatan,
                ':Kd_Rek_1' => 5,
            ])->queryScalar();

        $data = new SqlDataProvider([
            'sql' => "
                    SELECT
                    a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, 
                    c.Nm_Rek_3, d.Nm_Rek_4, e.Nm_Rek_5,
                    CONCAT(a.Kd_Rek_1, '.', a.Kd_Rek_2, '.', a.Kd_Rek_3, '.', a.Kd_Rek_4, '.', a.Kd_Rek_5
                    ,' ', e.Nm_Rek_5,  ' (Sisa Pagu Rp ', CONVERT(FORMAT((a.total - IFNULL(b.nilai,0)),0, 'id_ID') using utf8) , ' ) '
                    ) AS name,
                    (a.total - IFNULL(b.nilai, 0)) AS sisa_anggaran
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
                            sekolah_id = :sekolah_id
                        AND tahun = :tahun
                        AND kd_program = :kd_program
                        AND kd_sub_program = :kd_sub_program
                        AND kd_kegiatan = :kd_kegiatan
                        AND Kd_Rek_1 = :Kd_Rek_1
                        AND perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE perubahan_id IN (4,6) AND sekolah_id = :sekolah_id AND tahun = :tahun AND tgl_peraturan <= NOW()
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
                            sekolah_id = :sekolah_id
                        AND tahun = :tahun
                        AND kd_program = :kd_program
                        AND kd_sub_program = :kd_sub_program
                        AND kd_kegiatan = :kd_kegiatan
                        AND Kd_Rek_1 = :Kd_Rek_1
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
                    ",
            'params' => [
                ':tahun' => $Tahun,
                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                ':kd_program' => $kd_program,
                ':kd_sub_program' => $kd_sub_program,
                ':kd_kegiatan' => $kd_kegiatan,
                ':Kd_Rek_1' => 5,
            ],
            'totalCount' => $totalCount,
            //'sort' =>false, to remove the table header sorting
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);                                          
        // $posisiAnggaran =\app\models\TaRkasPeraturan::find()->select('MAX(perubahan_id) AS perubahan_id')->where(['sekolah_id' => $sekolah_id])->andWhere('perubahan_id IN (4,6)')->one();
        // $searchModel = new \app\modules\anggaran\models\RefRek5Search();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $dataProvider->query->andWhere(['Kd_Rek_1' => 5, 'Kd_Rek_2' => 2]);
        // $dataProvider->pagination->pageSize=100;

        if($request->isAjax){
            return $this->renderAjax('kamusbelanja', [
                'data' => $data,
                // 'searchModel' => $searchModel,
                // 'dataProvider' => $dataProvider,
                'Tahun' => $Tahun,
                'kd_program' => $kd_program,
                'kd_sub_program' => $kd_sub_program,
                'kd_kegiatan' => $kd_kegiatan,
                'kegiatan' => $kegiatan,
            ]);
        }ELSE{
            Yii::$app->getSession()->setFlash('warning',  'Koneksi Timeout');
            return $this->redirect(['index']);
        }
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
