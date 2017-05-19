<?php

namespace app\modules\anggaran\controllers;

use Yii;
use app\models\TaRkasPeraturan;
use app\modules\anggaran\models\TaRkasPeraturanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * BaperrincController implements the CRUD actions for TaRkasPeraturan model.
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
     * Lists all TaRkasPeraturan models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new TaRkasPeraturanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single TaRkasPeraturan model.
     * @param string $tahun
     * @param integer $sekolah_id
     * @param integer $perubahan_id
     * @return mixed
     */
    public function actionView($tahun, $sekolah_id, $perubahan_id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "TaRkasPeraturan #".$tahun, $sekolah_id, $perubahan_id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($tahun, $sekolah_id, $perubahan_id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','tahun, $sekolah_id, $perubahan_id'=>$tahun, $sekolah_id, $perubahan_id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($tahun, $sekolah_id, $perubahan_id),
            ]);
        }
    }


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
     * Finds the TaRkasPeraturan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $tahun
     * @param integer $sekolah_id
     * @param integer $perubahan_id
     * @return TaRkasPeraturan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($tahun, $sekolah_id, $perubahan_id)
    {
        if (($model = TaRkasPeraturan::findOne(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'perubahan_id' => $perubahan_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
