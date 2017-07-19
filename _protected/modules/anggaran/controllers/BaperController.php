<?php

namespace app\modules\anggaran\controllers;

use Yii;
use app\models\TaBaver;
use app\models\TaBaverRinc;
use app\modules\anggaran\models\TaBaverSearch;
use app\modules\anggaran\models\TaBaverRincSearch;
use app\models\TaRkasPeraturan;
use app\modules\anggaran\models\TaRkasPeraturanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

/**
 * BaperController implements the CRUD actions for TaBaver model.
 */
class BaperController extends Controller
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
                    'bulk-update' => ['POST'],
                    'deleterinc' => ['POST'],
                    'status' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TaBaver models.
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
        $searchModel = new TaBaverSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tahun' => $Tahun]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }

    /**
     * Displays a single TaBaver model.
     * @param string $tahun
     * @param string $no_ba
     * @return mixed
     */
    public function actionView($tahun, $no_ba)
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
            'model' => $this->findModel($tahun, $no_ba),
        ]);
    }

    public function actionPrintrka1($tahun, $no_ba)
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
                    a.tahun,
                    a.no_ba,
                    a.tgl_ba,
                    b.sekolah_id,
                    b.no_peraturan,
                    c.tgl_peraturan,
                    c.perubahan_id,
                    d.kd_program,
                    d.kd_sub_program,
                    d.kd_kegiatan,
                    d.Kd_Rek_1,
                    d.Kd_Rek_2,
                    d.Kd_Rek_3,
                    d.Kd_Rek_4,
                    d.Kd_Rek_5,
                    d.no_rinc,
                    d.keterangan,
                    d.satuan123,
                    d.jml_satuan,
                    d.nilai_rp,
                    d.total
                    FROM
                    ta_baver AS a
                    INNER JOIN ta_baver_rinc AS b ON b.tahun = a.tahun AND b.no_ba = a.no_ba
                    INNER JOIN ta_rkas_peraturan AS c ON c.tahun = b.tahun AND c.no_peraturan = b.no_peraturan AND c.sekolah_id = b.sekolah_id
                    INNER JOIN ta_rkas_history AS d ON d.tahun = c.tahun AND d.sekolah_id = c.sekolah_id AND d.perubahan_id = c.perubahan_id
                    WHERE a.tahun = :tahun AND a.no_ba = :no_ba AND d.Kd_Rek_1 = 4 AND (d.kd_penerimaan_1, d.kd_penerimaan_2) IN (SELECT kd_penerimaan_1, kd_penerimaan_2 FROM ref_penerimaan_sekolah_2 WHERE pengesahan = 1)
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
                GROUP BY a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.sekolah_id,a.jml_satuan, a.satuan123, a.nilai_rp, a.keterangan
                ORDER BY a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.sekolah_id ASC                   
        ")->bindValues([
                ':tahun' => $tahun,
                ':no_ba' => $no_ba,
        ])->queryAll();

        $references = \app\models\TaTh::findOne(['tahun' => $tahun]);

        return $this->render('printrka1', [
            'data' => $data,
            'model' => $this->findModel($tahun, $no_ba),
            'ref' => $references,
        ]);
    }


    public function actionPrintrka221($tahun, $no_ba)
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

        $data =  Yii::$app->db->createCommand("
                SELECT
                a.kd_program, b.uraian_program,
                a.kd_sub_program, c.uraian_sub_program,
                /* a.kd_kegiatan, d.uraian_kegiatan, */
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
                    a.tahun,
                    a.no_ba,
                    a.tgl_ba,
                    b.sekolah_id,
                    b.no_peraturan,
                    c.tgl_peraturan,
                    c.perubahan_id,
                    d.kd_program,
                    d.kd_sub_program,
                    d.kd_kegiatan,
                    d.Kd_Rek_1,
                    d.Kd_Rek_2,
                    d.Kd_Rek_3,
                    d.Kd_Rek_4,
                    d.Kd_Rek_5,
                    d.no_rinc,
                    d.keterangan,
                    d.satuan123,
                    d.jml_satuan,
                    d.nilai_rp,
                    d.total
                    FROM
                    ta_baver AS a
                    INNER JOIN ta_baver_rinc AS b ON b.tahun = a.tahun AND b.no_ba = a.no_ba
                    INNER JOIN ta_rkas_peraturan AS c ON c.tahun = b.tahun AND c.no_peraturan = b.no_peraturan AND c.sekolah_id = b.sekolah_id
                    INNER JOIN ta_rkas_history AS d ON d.tahun = c.tahun AND d.sekolah_id = c.sekolah_id AND d.perubahan_id = c.perubahan_id
                    WHERE a.tahun = :tahun AND a.no_ba = :no_ba AND d.Kd_Rek_1 = 5 AND d.Kd_Rek_2 = 2 AND (d.kd_penerimaan_1, d.kd_penerimaan_2) IN (SELECT kd_penerimaan_1, kd_penerimaan_2 FROM ref_penerimaan_sekolah_2 WHERE pengesahan = 1)
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
                GROUP BY a.kd_program, a.kd_sub_program, /* a.kd_kegiatan,*/  a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.sekolah_id,a.jml_satuan, a.satuan123, a.nilai_rp, a.keterangan
                ORDER BY a.kd_program, a.kd_sub_program, /* a.kd_kegiatan,*/ a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.sekolah_id ASC                   
        ")->bindValues([
                ':tahun' => $tahun,
                ':no_ba' => $no_ba,
        ])->queryAll();

        $references = \app\models\TaTh::findOne(['tahun' => $tahun]);

        return $this->render('printrka221', [
            'data' => $data,
            'model' => $this->findModel($tahun, $no_ba),
            'ref' => $references,
        ]);
    }        

    public function actionPreview($tahun, $no_ba, $sekolah_id, $no_peraturan)
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
            'model' => $this->findModel($tahun, $no_ba),
        ]);
    }

    public function actionRincian($tahun, $no_ba)
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

        // create session for bulk update
        $session = Yii::$app->session;
        IF($session['no_ba']){
            $session->remove('no_ba');
        }
        $session->set('no_ba', $no_ba);        

        $model = $this->findModel($tahun, $no_ba);
        if($model->status == 1){
            $searchModel = new TaBaverRincSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andWhere(['tahun' => $tahun]);
        }else{        
            $searchModel = new TaRkasPeraturanSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andWhere(['tahun' => $tahun]);
            $dataProvider->query->andWhere('perubahan_id > 3');
            $dataProvider->query->andWhere("no_peraturan NOT IN(SELECT no_peraturan FROM ta_baver_rinc WHERE tahun = $tahun AND no_ba <> '$no_ba') AND tgl_peraturan <= '".$model->tgl_ba."'");
            $dataProvider->query->orderBy('sekolah_id, tgl_peraturan DESC');
        }

        $view = '/baperrinc/index';
        if($model->status == 1) $view = 'terlampir';
        return $this->render($view, [
            'model' => $this->findModel($tahun, $no_ba),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'no_ba' => $no_ba,
        ]);
    }    

    /**
     * Creates a new TaBaver model.
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

        $model = new TaBaver();
        $model->tahun = $Tahun;

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
     * Updates an existing TaBaver model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $tahun
     * @param string $no_ba
     * @return mixed
     */
    public function actionUpdate($tahun, $no_ba)
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

        $model = $this->findModel($tahun, $no_ba);

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

    public function actionStatus($tahun, $no_ba)
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

        $model = $this->findModel($tahun, $no_ba);
        if($model->status == 1){
            $model->status = 0;
        }else{
            $model->status = 1;
        }
        if($model->save()) return $this->redirect(Yii::$app->request->referrer);
        
    }

    public function actionDelete($tahun, $no_ba)
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

        $this->findModel($tahun, $no_ba)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDeleterinc($tahun, $no_ba, $sekolah_id, $no_peraturan)
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

        $model = \app\models\TaBaverRinc::findOne(['tahun' => $tahun, 'no_ba' => $no_ba, 'sekolah_id' => $sekolah_id, 'no_peraturan' => $no_peraturan]);
        $model->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionBulkUpdate()
    {
        $request = Yii::$app->request;
        $data = $request->post( 'pks' );
        $data = str_replace('},', '}-', $data);
        $pks = explode('-', $data); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            // var_dump(json_decode($pk)->perubahan_id);
            $pk = json_decode($pk);
            $tahun = $pk->tahun;
            $sekolah_id = $pk->sekolah_id;
            $perubahan_id = $pk->perubahan_id;
            $peraturan = $this->findPeraturan($tahun, $sekolah_id, $perubahan_id);
            $model = TaBaverRinc::find()->where(['tahun' => $peraturan->tahun, 'no_peraturan' => $peraturan['no_peraturan']])->one();
            if($model == NULL) $model = new TaBaverRinc();
            $model->tahun = $tahun;
            $model->no_ba = Yii::$app->session->get('no_ba');
            $model->sekolah_id = $peraturan['sekolah_id'];
            $model->no_peraturan = $peraturan['no_peraturan'];
            if(!$model->save()){
                return 'Penyimpanan Gagal, coba lagi refresh halaman ini';
            }
            // $model->delete();
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
            return $this->redirect(Yii::$app->request->referrer);
        }
       
    }

    protected function findModel($tahun, $no_ba)
    {
        if (($model = TaBaver::findOne(['tahun' => $tahun, 'no_ba' => $no_ba])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 406])->one();
            IF($akses){
                return true;
            }else{
                return false;
            }
        }ELSE{
            return false;
        }
    }  

    protected function findPeraturan($tahun, $sekolah_id, $perubahan_id)
    {
        if (($model = TaRkasPeraturan::findOne(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'perubahan_id' => $perubahan_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }    

}
