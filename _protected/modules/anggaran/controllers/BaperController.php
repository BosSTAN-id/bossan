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
