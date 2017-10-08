<?php

namespace app\modules\asettetap\controllers;

use Yii;
use app\models\TaAsetTetap;
use app\modules\asettetap\models\TaAsetTetapSearch;
use app\models\RefRekAset1;
use app\modules\parameter\models\RefRekAset1Search;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * InventarisasiController implements the CRUD actions for TaAsetTetap model.
 */
class KondisiController extends Controller
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
                    'bulk-update' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TaAsetTetap models.
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
        $searchModel = new TaAsetTetapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $model = new TaAsetTetap();
        $model->tahun = $Tahun;
        if(Yii::$app->user->identity->sekolah_id){
            $dataProvider->query->andWhere(['sekolah_id' => Yii::$app->user->identity->sekolah_id]);
            $model->sekolah_id = Yii::$app->user->identity->sekolah_id;
        }
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
            'model' => $model,
        ]);
    }

    public function actionTanah()
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
        $searchModel = new TaAsetTetapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('kondisi != 4');
        $dataProvider->query->andWhere(['Kd_Aset1' => 1]);

        $model = new TaAsetTetap();
        $model->tahun = $Tahun;
        if(Yii::$app->user->identity->sekolah_id){
            $dataProvider->query->andWhere(['sekolah_id' => Yii::$app->user->identity->sekolah_id]);
            $model->sekolah_id = Yii::$app->user->identity->sekolah_id;
            $model->Kd_Aset1 = 1;
        }
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
            'model' => $model,
        ]);
    } 
    
    public function actionPeralatanMesin()
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
        $searchModel = new TaAsetTetapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('kondisi != 4');
        $dataProvider->query->andWhere(['Kd_Aset1' => 2]);

        $model = new TaAsetTetap();
        $model->tahun = $Tahun;
        if(Yii::$app->user->identity->sekolah_id){
            $dataProvider->query->andWhere(['sekolah_id' => Yii::$app->user->identity->sekolah_id]);
            $model->sekolah_id = Yii::$app->user->identity->sekolah_id;
            $model->Kd_Aset1 = 2;
        }
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
            'model' => $model,
        ]);
    }

    public function actionGedung()
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
        $searchModel = new TaAsetTetapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('kondisi != 4');
        $dataProvider->query->andWhere(['Kd_Aset1' => 3]);

        $model = new TaAsetTetap();
        $model->tahun = $Tahun;
        if(Yii::$app->user->identity->sekolah_id){
            $dataProvider->query->andWhere(['sekolah_id' => Yii::$app->user->identity->sekolah_id]);
            $model->sekolah_id = Yii::$app->user->identity->sekolah_id;
            $model->Kd_Aset1 = 3;
        }
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
            'model' => $model,
        ]);
    }

    public function actionJji()
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
        $searchModel = new TaAsetTetapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('kondisi != 4');
        $dataProvider->query->andWhere(['Kd_Aset1' => 4]);

        $model = new TaAsetTetap();
        $model->tahun = $Tahun;
        if(Yii::$app->user->identity->sekolah_id){
            $dataProvider->query->andWhere(['sekolah_id' => Yii::$app->user->identity->sekolah_id]);
            $model->sekolah_id = Yii::$app->user->identity->sekolah_id;
            $model->Kd_Aset1 = 4;
        }
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
            'model' => $model,
        ]);
    }

    public function actionAtl()
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
        $searchModel = new TaAsetTetapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('kondisi != 4');
        $dataProvider->query->andWhere(['Kd_Aset1' => 5]);

        $model = new TaAsetTetap();
        $model->tahun = $Tahun;
        if(Yii::$app->user->identity->sekolah_id){
            $dataProvider->query->andWhere(['sekolah_id' => Yii::$app->user->identity->sekolah_id]);
            $model->sekolah_id = Yii::$app->user->identity->sekolah_id;
            $model->Kd_Aset1 = 5;
        }
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
            'model' => $model,
        ]);
    }     

    /**
     * Displays a single TaAsetTetap model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
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
            'model' => $this->findModel($id),
        ]);
    }

    public function actionBulkUpdate()
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

        if(Yii::$app->request->post() && $post = Yii::$app->request->post()){
            $kondisi = $post['kondisi_aset'];
            $tgl_pemutakhiran = $post['tgl_pemutakhiran'];
            if(isset($post['selection'])){
                foreach($post['selection'] as $selection){
                    $model = $this->findModel($selection);
                    $model->kondisi = $kondisi;
                    $dumpKondisi = new \app\models\TaAsetTetapKondisi();
                    $dumpKondisi->no_register = $model->no_register;
                    $dumpKondisi->tgl_pemutakhiran = $tgl_pemutakhiran;
                    $dumpKondisi->kondisi = $kondisi;
                    if(!$dumpKondisi->save() || !$model->save()){
                        Yii::$app->getSession()->setFlash('warning',  'Terjadi kesalahan dalam pengubahan kondisi! Aset dengan No_Register '.$selection);
                        return $this->redirect(Yii::$app->request->referrer);
                    }
                }
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the TaAsetTetap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TaAsetTetap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaAsetTetap::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 702])->one();
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
