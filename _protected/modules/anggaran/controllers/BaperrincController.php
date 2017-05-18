<?php

namespace app\modules\anggaran\controllers;

use Yii;
use app\models\TaBaverRinc;
use app\modules\anggaran\models\TaBaverRincSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * BaperrincController implements the CRUD actions for TaBaverRinc model.
 */
class BaperrincController extends Controller
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
     * Lists all TaBaverRinc models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new TaBaverRincSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single TaBaverRinc model.
     * @param string $tahun
     * @param string $no_ba
     * @param integer $sekolah_id
     * @param string $no_peraturan
     * @return mixed
     */
    public function actionView($tahun, $no_ba, $sekolah_id, $no_peraturan)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "TaBaverRinc #".$tahun, $no_ba, $sekolah_id, $no_peraturan,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($tahun, $no_ba, $sekolah_id, $no_peraturan),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','tahun, $no_ba, $sekolah_id, $no_peraturan'=>$tahun, $no_ba, $sekolah_id, $no_peraturan],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($tahun, $no_ba, $sekolah_id, $no_peraturan),
            ]);
        }
    }

    /**
     * Creates a new TaBaverRinc model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new TaBaverRinc();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new TaBaverRinc",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new TaBaverRinc",
                    'content'=>'<span class="text-success">Create TaBaverRinc success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new TaBaverRinc",
                    'content'=>$this->renderAjax('create', [
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
                return $this->redirect(['view', 'tahun' => $model->tahun, 'no_ba' => $model->no_ba, 'sekolah_id' => $model->sekolah_id, 'no_peraturan' => $model->no_peraturan]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing TaBaverRinc model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param string $tahun
     * @param string $no_ba
     * @param integer $sekolah_id
     * @param string $no_peraturan
     * @return mixed
     */
    public function actionUpdate($tahun, $no_ba, $sekolah_id, $no_peraturan)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($tahun, $no_ba, $sekolah_id, $no_peraturan);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update TaBaverRinc #".$tahun, $no_ba, $sekolah_id, $no_peraturan,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "TaBaverRinc #".$tahun, $no_ba, $sekolah_id, $no_peraturan,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','tahun, $no_ba, $sekolah_id, $no_peraturan'=>$tahun, $no_ba, $sekolah_id, $no_peraturan],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update TaBaverRinc #".$tahun, $no_ba, $sekolah_id, $no_peraturan,
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
                return $this->redirect(['view', 'tahun' => $model->tahun, 'no_ba' => $model->no_ba, 'sekolah_id' => $model->sekolah_id, 'no_peraturan' => $model->no_peraturan]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing TaBaverRinc model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $tahun
     * @param string $no_ba
     * @param integer $sekolah_id
     * @param string $no_peraturan
     * @return mixed
     */
    public function actionDelete($tahun, $no_ba, $sekolah_id, $no_peraturan)
    {
        $request = Yii::$app->request;
        $this->findModel($tahun, $no_ba, $sekolah_id, $no_peraturan)->delete();

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
     * Delete multiple existing TaBaverRinc model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $tahun
     * @param string $no_ba
     * @param integer $sekolah_id
     * @param string $no_peraturan
     * @return mixed
     */
    public function actionBulkDelete()
    {        
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

    /**
     * Finds the TaBaverRinc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $tahun
     * @param string $no_ba
     * @param integer $sekolah_id
     * @param string $no_peraturan
     * @return TaBaverRinc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($tahun, $no_ba, $sekolah_id, $no_peraturan)
    {
        if (($model = TaBaverRinc::findOne(['tahun' => $tahun, 'no_ba' => $no_ba, 'sekolah_id' => $sekolah_id, 'no_peraturan' => $no_peraturan])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
