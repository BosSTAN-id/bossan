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
class InventarisasiController extends Controller
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
                    'bulk-delete' => ['POST'],
                    'rek-aset1' => ['POST'],
                    'rek-aset2' => ['POST'],
                    'rek-aset3' => ['POST'],
                    'rek-aset4' => ['POST'],
                    'rek-aset5' => ['POST'],
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

    /**
     * Creates a new TaAsetTetap model.
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

        $model = new TaAsetTetap();
        $model->tahun = $Tahun;
        if(Yii::$app->user->identity->sekolah_id){
            $model->sekolah_id = Yii::$app->user->identity->sekolah_id;
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->nilai_perolehan = str_replace(',', '.', $model->nilai_perolehan);
            list($Kd_Aset1, $model->Kd_Aset2, $model->Kd_Aset3, $model->Kd_Aset4, $model->Kd_Aset5) = explode('.', $model->kode25);
            if(!$model->Kd_Aset1) $model->Kd_Aset1 = $Kd_Aset1;
            
            if(!$model->jumlahBarang || $model->jumlahBarang == 1){
                $model->no_register = \thamtech\uuid\helpers\UuidHelper::uuid();
                $maxNoAsetIni = TaAsetTetap::find()->where([
                    'tahun' => $model->tahun,
                    'sekolah_id' => $model->sekolah_id,
                    'Kd_Aset1' => $model->Kd_Aset1,
                    'Kd_Aset2' => $model->Kd_Aset2,
                    'Kd_Aset3' => $model->Kd_Aset3,
                    'Kd_Aset4' => $model->Kd_Aset4,
                    'Kd_Aset5' => $model->Kd_Aset5,
                ])->orderBy('no_urut DESC')->one();
                $model->no_urut = $maxNoAsetIni['no_urut'] + 1;
                $model->kondisi = 1;
                // return var_dump($model->validate());
                IF($model->save()){
                    return $this->redirect(Yii::$app->request->referrer);
                    echo 1;
                }ELSE{
                    echo 0;
                }
            }else{
                
                IF($model->saveMulti()){
                    return $this->redirect(Yii::$app->request->referrer);
                    echo 1;
                }ELSE{
                    return $this->redirect(Yii::$app->request->referrer);
                    echo 0;
                }
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TaAsetTetap model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
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

        $model = $this->findModel($id);

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

    public function actionDelete($id)
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

        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

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

        if(Yii::$app->request->post() && $post = Yii::$app->request->post()){
            if(isset($post['selection'])){
                foreach($post['selection'] as $selection){
                    $this->findModel($selection)->delete();
                }
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRekAset1()
    {
        $searchModel = new RefRekAset1Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderAjax('_rek-aset1', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRekAset2($Kd_Aset1)
    {
        $query = \app\models\RefRekAset2::find()->where(['Kd_Aset1' => $Kd_Aset1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 0,
            ],
        ]);

        return $this->renderAjax('_rek-aset2', [
            'dataProvider' => $dataProvider,
        ]);
    } 
    
    public function actionRekAset3($Kd_Aset1, $Kd_Aset2)
    {
        $query = \app\models\RefRekAset3::find()->where(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 0,
            ],
        ]);

        return $this->renderAjax('_rek-aset3', [
            'dataProvider' => $dataProvider,
        ]);
    }  
    
    public function actionRekAset4($Kd_Aset1, $Kd_Aset2, $Kd_Aset3)
    {
        $query = \app\models\RefRekAset4::find()->where(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2, 'Kd_Aset3' => $Kd_Aset3]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 0,
            ],
        ]);

        return $this->renderAjax('_rek-aset4', [
            'dataProvider' => $dataProvider,
        ]);
    }  
    
    public function actionRekAset5($Kd_Aset1, $Kd_Aset2, $Kd_Aset3, $Kd_Aset4)
    {
        $query = \app\models\RefRekAset5::find()->where(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2, 'Kd_Aset3' => $Kd_Aset3, 'Kd_Aset4' => $Kd_Aset4]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 0,
            ],
        ]);

        return $this->renderAjax('_rek-aset5', [
            'dataProvider' => $dataProvider,
        ]);
    } 
    
    public function actionChooserek($Kd_Aset1, $Kd_Aset2, $Kd_Aset3, $Kd_Aset4, $Kd_Aset5)
    {
        $query = \app\models\RefRekAset5::find()->where(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2, 'Kd_Aset3' => $Kd_Aset3, 'Kd_Aset4' => $Kd_Aset4, 'Kd_Aset5' => $Kd_Aset5])->one();
        return Json::encode($query);
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
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 701])->one();
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
