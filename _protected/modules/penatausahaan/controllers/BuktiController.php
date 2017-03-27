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
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "TaSPJRinc #".$tahun, $no_bukti, $tgl_bukti,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($tahun, $no_bukti, $tgl_bukti),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','tahun, $no_bukti, $tgl_bukti'=>$tahun, $no_bukti, $tgl_bukti],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($tahun, $no_bukti, $tgl_bukti),
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

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new TaSPJRinc",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'Tahun' => $Tahun,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new TaSPJRinc",
                    'content'=>'<span class="text-success">Create TaSPJRinc success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new TaSPJRinc",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'Tahun' => $Tahun,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'tahun' => $model->tahun, 'no_bukti' => $model->no_bukti, 'tgl_bukti' => $model->tgl_bukti]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'Tahun' => $Tahun,
                ]);
            }
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

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update TaSPJRinc #".$tahun, $no_bukti, $tgl_bukti,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "TaSPJRinc #".$tahun, $no_bukti, $tgl_bukti,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','tahun, $no_bukti, $tgl_bukti'=>$tahun, $no_bukti, $tgl_bukti],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update TaSPJRinc #".$tahun, $no_bukti, $tgl_bukti,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'tahun' => $model->tahun, 'no_bukti' => $model->no_bukti, 'tgl_bukti' => $model->tgl_bukti]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
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
        $this->findModel($tahun, $no_bukti, $tgl_bukti)->delete();

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
        $request = Yii::$app->request;
                        // $totalCount = Yii::$app->db->createCommand("
                        // asdasd
                        //     ", [
                        //         ':tahun' => $Tahun,
                        //         ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                        //         ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                        //         ':kd_penerimaan_1' => $kd_penerimaan_1,
                        //         ':kd_penerimaan_2' => $kd_penerimaan_2,
                        //     ])->queryScalar();

                        // $data = new SqlDataProvider([
                        //     'sql' => "
                        //             asdasd
                        //             ",
                        //     'params' => [
                        //         ':tahun' => $Tahun,
                        //         ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                        //         ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                        //         ':kd_penerimaan_1' => $kd_penerimaan_1,
                        //         ':kd_penerimaan_2' => $kd_penerimaan_2,
                        //     ],
                        //     'totalCount' => $totalCount,
                        //     //'sort' =>false, to remove the table header sorting
                        //     'pagination' => [
                        //         'pageSize' => 50,
                        //     ],
                        // ]);                                          
        $searchModel = new \app\modules\anggaran\models\RefRek5Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['Kd_Rek_1' => 5, 'Kd_Rek_2' => 2]);
        $dataProvider->pagination->pageSize=100;

        // if($request->isAjax){
            return $this->renderAjax('kamusbelanja', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'Tahun' => $Tahun,
                'kd_program' => $kd_program,
                'kd_sub_program' => $kd_sub_program,
                'kd_kegiatan' => $kd_kegiatan,
            ]);
        // }

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
